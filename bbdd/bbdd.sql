-- Tabla: role
CREATE TABLE role (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL
);

-- Tabla: user
CREATE TABLE user (
  id INT PRIMARY KEY AUTO_INCREMENT,
  dni VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Tabla: user_role
CREATE TABLE user_role (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  role_id INT NOT NULL,
  assigned_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES user(id),
  FOREIGN KEY (role_id) REFERENCES role(id)
);

-- Tabla: patient
CREATE TABLE patient (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(180) NOT NULL,
  birth_date DATE NOT NULL,
  created_at DATETIME NOT NULL,
  user_id INT UNIQUE,
  FOREIGN KEY (user_id) REFERENCES user(id)
);

-- Tabla: doctor
CREATE TABLE doctor (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  speciality VARCHAR(100) NOT NULL,
  user_id INT UNIQUE,
  FOREIGN KEY (user_id) REFERENCES user(id)
);

-- Tabla: receptionist
CREATE TABLE receptionist (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  user_id INT UNIQUE,
  FOREIGN KEY (user_id) REFERENCES user(id)
);

-- Tabla: appointment
CREATE TABLE appointment (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date DATETIME NOT NULL,
  status VARCHAR(20) NOT NULL,
  created_at DATETIME NOT NULL,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  FOREIGN KEY (patient_id) REFERENCES patient(id),
  FOREIGN KEY (doctor_id) REFERENCES doctor(id)
);

-- Tabla: invoice
CREATE TABLE invoice (
  id INT PRIMARY KEY AUTO_INCREMENT,
  base_amount DECIMAL(10,2) NOT NULL,
  tax_rate DECIMAL(5,2) NOT NULL,
  tax_amount DECIMAL(10,2) NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  issued_at DATETIME NOT NULL,
  status VARCHAR(50) NOT NULL,
  pdf_file LONGBLOB,
  appointment_id INT NOT NULL,
  FOREIGN KEY (appointment_id) REFERENCES appointment(id)
);

-- Tabla: treatment
CREATE TABLE treatment (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  description LONGTEXT,
  price DECIMAL(10,2) NOT NULL,
  doctor_id INT NOT NULL,
  FOREIGN KEY (doctor_id) REFERENCES doctor(id)
);

