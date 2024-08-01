CREATE DATABASE IF NOT EXISTS registration_system;
USE registration_system;

CREATE TABLE IF NOT EXISTS subjectenrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subjectclass VARCHAR(255) NOT NULL,
    enrollment_count INT NOT NULL
);