-- Add profile_image column to doctors table
ALTER TABLE doctors
ADD COLUMN profile_image VARCHAR(255) DEFAULT NULL;

-- Add profile_image column to patients table
ALTER TABLE patients
ADD COLUMN profile_image VARCHAR(255) DEFAULT NULL; 