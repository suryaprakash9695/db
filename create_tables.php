<?php
require_once('config.php');

// Create appointments table
$sql_appointments = "CREATE TABLE IF NOT EXISTS appointments (
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
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
)";

// Create prescriptions table
$sql_prescriptions = "CREATE TABLE IF NOT EXISTS prescriptions (
    prescription_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    medications JSON NOT NULL,
    prescribed_date DATE NOT NULL,
    valid_until DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
)";

// Create medical_records table
$sql_medical_records = "CREATE TABLE IF NOT EXISTS medical_records (
    record_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    diagnosis TEXT NOT NULL,
    treatment TEXT NOT NULL,
    notes TEXT,
    record_date DATE NOT NULL,
    next_followup DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
)";

try {
    // Execute the table creation queries
    if ($con->query($sql_appointments)) {
        echo "Appointments table created successfully<br>";
    } else {
        echo "Error creating appointments table: " . $con->error . "<br>";
    }

    if ($con->query($sql_prescriptions)) {
        echo "Prescriptions table created successfully<br>";
    } else {
        echo "Error creating prescriptions table: " . $con->error . "<br>";
    }

    if ($con->query($sql_medical_records)) {
        echo "Medical records table created successfully<br>";
    } else {
        echo "Error creating medical records table: " . $con->error . "<br>";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 