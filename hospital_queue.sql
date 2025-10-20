-- =======================
-- Create database
-- =======================
CREATE DATABASE IF NOT EXISTS hospital_queue;
USE hospital_queue;

-- =======================
-- ADMIN TABLE
-- =======================
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Default admin credentials (for setup only — hash later)
INSERT INTO admin (username, password) VALUES ('admin', 'admin');

-- =======================
-- QUEUE TABLE
-- =======================
CREATE TABLE queue (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  department VARCHAR(100) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  age INT NOT NULL,
  patient_type ENUM('New', 'Returning') DEFAULT 'New',
  complaint TEXT NOT NULL,
  queue_number INT NOT NULL,
  status ENUM('waiting','processing','approved') DEFAULT 'waiting',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =======================
-- TRIGGER: AUTO QUEUE NUMBER (GLOBAL)
-- =======================
DELIMITER $$
CREATE TRIGGER assign_queue_number
BEFORE INSERT ON queue
FOR EACH ROW
BEGIN
    DECLARE last_number INT DEFAULT 0;
    SELECT IFNULL(MAX(queue_number), 0)
    INTO last_number
    FROM queue;
    SET NEW.queue_number = last_number + 1;
END $$
DELIMITER ;

-- =======================
-- SAMPLE DATA
-- =======================
INSERT INTO queue (patient_name, phone, department, gender, age, patient_type, complaint, status)
VALUES
('John Doe', '08123456789', 'Cardiology', 'Male', 45, 'New', 'Feeling sharp pain in the left chest and shortness of breath.', 'waiting'),
('Mary Smith', '07011223344', 'Radiology', 'Female', 29, 'Returning', 'Severe headache after previous scan result.', 'waiting'),
('James Brown', '09099887766', 'Pediatrics', 'Male', 7, 'New', 'Persistent cough for 3 days with high temperature.', 'waiting');
