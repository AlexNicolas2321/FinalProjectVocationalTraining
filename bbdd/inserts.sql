create database PrivateClinic;

INSERT INTO role (name)
VALUES 
  ('admin'),
  ('receptionist'),
  ('doctor'),
  ('patient');

-- Insertar usuarios (contraseña: 1234567)
INSERT INTO user (dni, password) VALUES 
  ('99999999A', '$2y$10$ygErp8WPcCjrEuTY9qJ4hekPHcxT1XfGuk2Qw2tnXWk/g6YnZ7rWq'), -- user_id = 1 (admin)
  ('88888888A', '$2y$10$ygErp8WPcCjrEuTY9qJ4hekPHcxT1XfGuk2Qw2tnXWk/g6YnZ7rWq'), -- user_id = 2 (receptionist)
  ('77777777A', '$2y$10$ygErp8WPcCjrEuTY9qJ4hekPHcxT1XfGuk2Qw2tnXWk/g6YnZ7rWq'), -- user_id = 3 (doctor 1)
  ('66666666A', '$2y$10$ygErp8WPcCjrEuTY9qJ4hekPHcxT1XfGuk2Qw2tnXWk/g6YnZ7rWq'), -- user_id = 4 (doctor 2)
  ('55555555A', '$2y$10$ygErp8WPcCjrEuTY9qJ4hekPHcxT1XfGuk2Qw2tnXWk/g6YnZ7rWq'); -- user_id = 5 (doctor 3)

-- Asignar roles
INSERT INTO user_role (assigned_at, user_id, role_id) VALUES 
  (NOW(), 1, 1), -- admin
  (NOW(), 2, 2), -- receptionist
  (NOW(), 3, 3), -- doctor 1
  (NOW(), 4, 3), -- doctor 2
  (NOW(), 5, 3); -- doctor 3

-- Insertar datos en receptionist
INSERT INTO receptionist (first_name, last_name, phone, user_id)
VALUES ('rec', 'rec', '123213321', 2);

-- Insertar datos en doctor
INSERT INTO doctor (first_name, last_name, phone, speciality, user_id) VALUES
  ('Laura', 'Gómez', '123456789', 'Higiene Bucodental', 3), -- doctor_id = 1
  ('Carlos', 'Pérez', '987654321', 'Podología', 4),          -- doctor_id = 2
  ('Ana', 'López', '111222333', 'Otorrinolaringología', 5); -- doctor_id = 3

-- Insertar tratamientos

-- Doctor 1 (Higiene Bucodental)
INSERT INTO treatment (name, description, price, doctor_id) VALUES
  ('limpieza_bucal', 'Eliminación de placa y sarro con limpieza profesional.', 50.00, 1);

-- Doctor 2 (Podología)
INSERT INTO treatment (name, description, price, doctor_id) VALUES
  ('plantillas_ortopédicas', 'Estudio y fabricación de plantillas personalizadas.', 100.00, 2);

-- Doctor 3 (Otorrinolaringología)
INSERT INTO treatment (name, description, price, doctor_id) VALUES
  ('revisión_auditiva', 'Evaluación básica de la audición con equipamiento clínico.', 60.00, 3);
