/* Nmap Commands Keeper - Initial Setup */

-- Create database
CREATE DATABASE nmap_keeper;

-- Use the database
USE nmap_keeper;

-- Create table for storing Nmap commands
CREATE TABLE nmap_commands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    command TEXT NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/* Nmap Commands Keeper - Initial Setup */

-- Create database
CREATE DATABASE nmap_keeper;

-- Use the database
USE nmap_keeper;

-- Create table for storing Nmap commands
CREATE TABLE nmap_commands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    command TEXT NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for storing command execution logs
CREATE TABLE command_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    command_id INT NOT NULL,
    output TEXT,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (command_id) REFERENCES nmap_commands(id) ON DELETE CASCADE
);
