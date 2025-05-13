-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS guidance_system;

-- Use the database
USE guidance_system;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS appointment_history;
DROP TABLE IF EXISTS appointment;

-- Create appointment table (singular name as requested)
CREATE TABLE appointment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    requester_name VARCHAR(100) NOT NULL,
    requester_type ENUM('parent', 'teacher') NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending', 'approved', 'completed', 'canceled') DEFAULT 'pending',
    counselor_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create appointment_history table
CREATE TABLE appointment_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    appointment_id INT,
    action ENUM('created', 'approved', 'rescheduled', 'canceled', 'completed') NOT NULL,
    old_date DATE,
    old_time TIME,
    new_date DATE,
    new_time TIME,
    reason TEXT,
    action_by VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointment(id)
);