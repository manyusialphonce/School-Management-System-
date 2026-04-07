CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','teacher','student','parent') NOT NULL
);

-- Students Table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    dob DATE,
    class_id INT,
    parent_contact VARCHAR(50)
);

-- Teachers Table
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    subject VARCHAR(50),
    contact VARCHAR(50)
);

-- Classes Table
CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    teacher_id INT
);

-- Attendance Table
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    class_id INT,
    date DATE,
    status ENUM('Present','Absent') DEFAULT 'Absent'
);

-- Fees Table
CREATE TABLE fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    amount DECIMAL(10,2),
    status ENUM('Paid','Unpaid') DEFAULT 'Unpaid'
);

-- Exams Table
CREATE TABLE exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject VARCHAR(50),
    marks DECIMAL(5,2),
    grade VARCHAR(5)
);

-- Add a default admin user (password: admin123)
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$ZpJpXYN2ykFQpi6QpOgf7uYVRycDafKj2nQJ6by0oI0uZWJY6cG8u', 'admin');