-- Add preferred_communication column to appointments table
ALTER TABLE appointments 
ADD COLUMN preferred_communication ENUM('email', 'phone', 'sms') NOT NULL DEFAULT 'email' 
AFTER notes; 