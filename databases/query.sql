-- Create Database called "iitspath"
CREATE DATABASE iitspath;

-- Use the database
USE iitspath;

-- Create Table called "roles"
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Insert data into the roles table
INSERT INTO roles (id, name)
VALUES (1, 'Admin'), (2, 'Manager'), (3, 'Employee');

-- Create Table called "employee-roles"
CREATE TABLE employee_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employees_id INT NOT NULL,
    roles_id INT NOT NULL,
    FOREIGN KEY (employees_id) REFERENCES employees(id),
    FOREIGN KEY (roles_id) REFERENCES roles(id)
);

-- Create Table called "admin"
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insert data into the admin table
INSERT INTO admin (id, email, password) 
VALUES (1, 'test@gmail.com', 'test123');

-- Create Table called "managers"
CREATE TABLE managers(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    salary DECIMAL(50, 2) NOT NULL,
    joining_date DATE NOT NULL,
    designation VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NOT NULL,
    educational_document VARCHAR(255) NOT NULL,
    previous_certificate VARCHAR(255) NOT NULL
);

-- Create Table called "employees"
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    salary DECIMAL(50, 2) NOT NULL,
    joining_date DATE NOT NULL
    designation VARCHAR(255) DEFAULT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    educational_document VARCHAR(255) DEFAULT NULL,
    previous_certificate VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY managers_name VARCHAR(255) REFERENCES managers(name),
    FOREIGN KEY (managers_id) REFERENCES employees(id)
);

-- Create Table called "leave_applications"
CREATE TABLE leave_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employees_id INT NOT NULL,
    applied_date DATE NOT NULL,
    start_date DATE NOT NULL,
    resume_date DATE NOT NULL,
    days_of_leave INT NOT NULL,
    reason VARCHAR(255) NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending',
    FOREIGN KEY (employees_id) REFERENCES employees(id)
);

-- Create Table called "attendance"
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employees_id INT NOT NULL,
    date DATE NOT NULL,
    check_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    check_out TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Present', 'Absent', 'Late', 'Leave') NOT NULL,
    leave_reason VARCHAR(255),
    FOREIGN KEY (employees_id) REFERENCES employees(id)
);

-- Create Table called "payroll"
CREATE TABLE payroll (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employees_id INT NOT NULL,
    month VARCHAR(255) NOT NULL,
    year VARCHAR(255) NOT NULL,
    salary DECIMAL(50, 2) NOT NULL,
    bonus DECIMAL(50, 2) NOT NULL,
    deduction DECIMAL(50, 2) NOT NULL,
    net_salary DECIMAL(50, 2) NOT NULL,
    FOREIGN KEY (employees_id) REFERENCES employees(id)
);

-- Add Some Data to the employees table
ALTER TABLE employees
ADD managers INT;

ALTER TABLE employees
MODIFY COLUMN managers VARCHAR(255);

ALTER TABLE employees
MODIFY phone VARCHAR(255) DEFAULT '';
-- OR --
ALTER TABLE employees
MODIFY phone VARCHAR(255) NULL;

ALTER TABLE employees
MODIFY manager_name VARCHAR(255) DEFAULT ''; -- set a default value

ALTER TABLE employees
MODIFY manager_name VARCHAR(255) NULL; -- allow NULL values

ALTER TABLE managers ADD employee_id INT;
DESCRIBE managers; -- show the table structure

ALTER TABLE leave_applications
MODIFY employees_id INT NULL;