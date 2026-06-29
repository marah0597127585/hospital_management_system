CREATE DATABASE IF NOT EXISTS hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hospital_db;

DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','doctor','receptionist') NOT NULL DEFAULT 'receptionist',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE patients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  gender ENUM('ذكر','أنثى') NOT NULL,
  birth_date DATE NOT NULL,
  address TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  specialization VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  department_id INT NOT NULL,
  FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATETIME NOT NULL,
  status ENUM('مجدول','مكتمل','ملغي') NOT NULL DEFAULT 'مجدول',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO users(name,email,password,role) VALUES
('Admin','admin@hospital.com','$2y$12$PZkhi/4cdLIjk8h7MQi.pu5iFBue.UEJmpaBmKrFc.GbTWW6Lt84O','admin');
-- Password: admin123

INSERT INTO departments(name,description) VALUES
('الطوارئ','قسم استقبال الحالات الطارئة'),('القلب','قسم أمراض القلب'),('الأطفال','قسم طب الأطفال');
INSERT INTO patients(name,phone,gender,birth_date,address) VALUES
('أحمد علي','0790000001','ذكر','1998-05-10','عمان'),('سارة محمد','0790000002','أنثى','2001-08-20','إربد');
INSERT INTO doctors(name,specialization,phone,department_id) VALUES
('د. خالد حسن','قلب','0781111111',2),('د. ريم عبدالله','أطفال','0782222222',3);
INSERT INTO appointments(patient_id,doctor_id,appointment_date,status,notes) VALUES
(1,1,NOW(),'مجدول','فحص أولي'),(2,2,NOW(),'مجدول','متابعة');
