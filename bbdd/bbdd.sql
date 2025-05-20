DROP DATABASE IF EXISTS PrivateClinic;
CREATE DATABASE PrivateClinic;
USE PrivateClinic;

CREATE TABLE role (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dni VARCHAR(100) NOT NULL unique,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE doctor (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  speciality VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL unique,
  user_id INT NOT NULL unique,
  FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE patient (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL unique,
  birth_date DATE NOT NULL,
  created_at DATETIME NOT NULL,
  user_id INT NOT NULL unique,
  FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE receptionist (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL unique,
  user_id INT NOT NULL unique,
  FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE user_role (
  id INT AUTO_INCREMENT PRIMARY KEY,
  assigned_at DATETIME DEFAULT NULL,
  user_id INT NOT NULL,
  role_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user(id),
  FOREIGN KEY (role_id) REFERENCES role(id)
);

CREATE TABLE appointment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATETIME NOT NULL,
  treatment_name VARCHAR(255) NOT NULL,
  treatment_description TEXT NOT NULL,
  treatment_price DECIMAL(10,2) NOT NULL,
  notes TEXT DEFAULT NULL,
  created_at DATETIME NOT NULL,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  FOREIGN KEY (patient_id) REFERENCES patient(id),
  FOREIGN KEY (doctor_id) REFERENCES doctor(id)
);

CREATE TABLE invoice (
  id INT AUTO_INCREMENT PRIMARY KEY,
  amount DECIMAL(10,2) NOT NULL,
  issued_at DATETIME NOT NULL,
  status VARCHAR(50) NOT NULL,
  appointment_id INT NOT NULL,
  FOREIGN KEY (appointment_id) REFERENCES appointment(id)
);
