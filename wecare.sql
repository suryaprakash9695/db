-- Drop database if exists to start fresh
DROP DATABASE IF EXISTS wecare;

-- Create the WeCare database
CREATE DATABASE IF NOT EXISTS wecare;
USE wecare;

-- Create admin table
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(191) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_email (email)
);

-- Insert default admin credentials
INSERT INTO admin (email, password) VALUES ('admin@gmail.com', 'admin1');

-- Create doctors table
CREATE TABLE IF NOT EXISTS doctors (
    doctor_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    specialization VARCHAR(100) NOT NULL,
    qualification VARCHAR(100) NOT NULL,
    experience INT NOT NULL,
    license_no VARCHAR(50) UNIQUE NOT NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create patients table
CREATE TABLE IF NOT EXISTS patients (
    patient_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create medical_records table
CREATE TABLE IF NOT EXISTS medical_records (
    record_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    diagnosis TEXT NOT NULL,
    treatment TEXT NOT NULL,
    notes TEXT,
    record_date DATE NOT NULL,
    next_followup DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

-- Create appointments table
CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason TEXT NOT NULL,
    notes TEXT,
    preferred_communication VARCHAR(50) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

-- Create consultations table
CREATE TABLE consultations (
    consultation_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    consultation_date DATETIME,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

-- Create feedback table
CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    rating INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE,
    CHECK (rating >= 1 AND rating <= 5)
);

-- Create notifications table
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    user_type ENUM('admin', 'doctor', 'patient'),
    message TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create prescriptions table
CREATE TABLE IF NOT EXISTS prescriptions (
    prescription_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    medications JSON NOT NULL,
    prescribed_date DATE NOT NULL,
    valid_until DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

-- Insert test patient
INSERT INTO patients (full_name, email, password, phone, date_of_birth, gender) 
VALUES ('Test Patient', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567890', '1990-01-01', 'Male')
ON DUPLICATE KEY UPDATE email = email;

-- Insert test doctor
INSERT INTO doctors (full_name, email, password, phone, specialization, qualification, experience, license_no, is_verified) 
VALUES ('Dr. Test Doctor', 'doctor@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', 'General Medicine', 'MBBS', 5, 'LIC123456', TRUE)
ON DUPLICATE KEY UPDATE email = email;

-- Insert sample appointment
INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason, preferred_communication, status)
SELECT 
    (SELECT patient_id FROM patients WHERE email = 'test@example.com'),
    (SELECT doctor_id FROM doctors WHERE email = 'doctor@example.com'),
    CURDATE(),
    '10:00:00',
    'Regular checkup',
    'Phone',
    'Scheduled'
WHERE NOT EXISTS (
    SELECT 1 FROM appointments 
    WHERE patient_id = (SELECT patient_id FROM patients WHERE email = 'test@example.com')
    AND doctor_id = (SELECT doctor_id FROM doctors WHERE email = 'doctor@example.com')
    AND appointment_date = CURDATE()
);

-- Insert sample prescription
INSERT INTO prescriptions (patient_id, doctor_id, medications, prescribed_date, valid_until, notes)
SELECT 
    (SELECT patient_id FROM patients WHERE email = 'test@example.com'),
    (SELECT doctor_id FROM doctors WHERE email = 'doctor@example.com'),
    '[{"name": "Paracetamol", "dosage": "500mg", "frequency": "Twice daily"}]',
    CURDATE(),
    DATE_ADD(CURDATE(), INTERVAL 7 DAY),
    'Take after meals'
WHERE NOT EXISTS (
    SELECT 1 FROM prescriptions 
    WHERE patient_id = (SELECT patient_id FROM patients WHERE email = 'test@example.com')
    AND doctor_id = (SELECT doctor_id FROM doctors WHERE email = 'doctor@example.com')
    AND prescribed_date = CURDATE()
);

-- Insert sample medical record
INSERT INTO medical_records (patient_id, doctor_id, diagnosis, treatment, record_date, next_followup)
SELECT 
    (SELECT patient_id FROM patients WHERE email = 'test@example.com'),
    (SELECT doctor_id FROM doctors WHERE email = 'doctor@example.com'),
    'Common cold with mild fever',
    'Rest and prescribed medications',
    CURDATE(),
    DATE_ADD(CURDATE(), INTERVAL 7 DAY)
WHERE NOT EXISTS (
    SELECT 1 FROM medical_records 
    WHERE patient_id = (SELECT patient_id FROM patients WHERE email = 'test@example.com')
    AND doctor_id = (SELECT doctor_id FROM doctors WHERE email = 'doctor@example.com')
    AND record_date = CURDATE()
);

-- Add indexes for better performance
CREATE INDEX idx_doctors_email ON doctors(email);
CREATE INDEX idx_patients_email ON patients(email);
CREATE INDEX idx_appointments_date ON appointments(appointment_date);
CREATE INDEX idx_consultations_date ON consultations(consultation_date);
CREATE INDEX idx_medical_records_date ON medical_records(record_date); 