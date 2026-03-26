-- ============================================================
-- EduSkill System – MySQL Database Schema
-- data/eduskill_db.sql
-- Run: mysql -u root -p < data/eduskill_db.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS eduskill_db
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;
USE eduskill_db;

-- Students
CREATE TABLE IF NOT EXISTS students (
  id          INT          AUTO_INCREMENT PRIMARY KEY,
  first_name  VARCHAR(80)  NOT NULL,
  last_name   VARCHAR(80)  NOT NULL,
  email       VARCHAR(150) NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,
  phone       VARCHAR(20),
  dob         DATE,
  education   VARCHAR(100),
  is_verified TINYINT(1) DEFAULT 0,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Training Providers
CREATE TABLE IF NOT EXISTS providers (
  id           INT          AUTO_INCREMENT PRIMARY KEY,
  org_name     VARCHAR(200) NOT NULL,
  reg_no       VARCHAR(50)  NOT NULL UNIQUE,
  org_type     VARCHAR(100),
  address      TEXT,
  website      VARCHAR(200),
  email        VARCHAR(150) NOT NULL UNIQUE,
  password     VARCHAR(255) NOT NULL,
  contact_name VARCHAR(100),
  contact_role VARCHAR(100),
  phone        VARCHAR(20),
  status       ENUM('pending','approved','rejected') DEFAULT 'pending',
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Admins
CREATE TABLE IF NOT EXISTS admins (
  id         INT          AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(100) NOT NULL,
  email      VARCHAR(150) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  role       ENUM('super_admin','officer') DEFAULT 'officer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Courses
CREATE TABLE IF NOT EXISTS courses (
  id          INT           AUTO_INCREMENT PRIMARY KEY,
  provider_id INT           NOT NULL,
  title       VARCHAR(200)  NOT NULL,
  category    VARCHAR(80),
  description TEXT,
  level       ENUM('Beginner','Intermediate','Advanced') DEFAULT 'Beginner',
  duration    VARCHAR(50),
  price       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  max_students INT          DEFAULT 30,
  is_active   TINYINT(1)   DEFAULT 1,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (provider_id) REFERENCES providers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Enrolments
CREATE TABLE IF NOT EXISTS enrolments (
  id             INT           AUTO_INCREMENT PRIMARY KEY,
  student_id     INT           NOT NULL,
  course_id      INT           NOT NULL,
  amount_paid    DECIMAL(10,2) NOT NULL,
  payment_ref    VARCHAR(100),
  payment_method VARCHAR(50)   DEFAULT 'Online Transfer',
  status         ENUM('active','completed','cancelled') DEFAULT 'active',
  progress       INT           DEFAULT 0,
  enrolled_at    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  completed_at   TIMESTAMP     NULL,
  UNIQUE KEY uq_enrolment (student_id, course_id),
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id)  REFERENCES courses(id)  ON DELETE CASCADE
) ENGINE=InnoDB;

-- Reviews
CREATE TABLE IF NOT EXISTS reviews (
  id          INT     AUTO_INCREMENT PRIMARY KEY,
  student_id  INT     NOT NULL,
  course_id   INT     NOT NULL,
  role_label  ENUM('Student','Training Provider') DEFAULT 'Student',
  rating      TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
  review_text TEXT,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_review (student_id, course_id),
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id)  REFERENCES courses(id)  ON DELETE CASCADE
) ENGINE=InnoDB;

-- Receipts
CREATE TABLE IF NOT EXISTS receipts (
  id           INT         AUTO_INCREMENT PRIMARY KEY,
  enrolment_id INT         NOT NULL UNIQUE,
  receipt_no   VARCHAR(30) NOT NULL UNIQUE,
  issued_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (enrolment_id) REFERENCES enrolments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Seed Data ──────────────────────────────────────────────

-- Admin account (password: Admin@2025! — bcrypt hash placeholder)
-- Admin account (password: Admin@2025!)
INSERT IGNORE INTO admins (name, email, password, role)
VALUES ('Officer Hamid','admin@mohr.gov.my','Admin@2025!','super_admin');

-- Approved provider (password: Provider@123)
INSERT IGNORE INTO providers
  (org_name, reg_no, org_type, address, email, password, contact_name, contact_role, phone, status)
VALUES
  ('TechPro Academy Sdn Bhd','SSM-1234567-A','Private Training Centre',
   'No. 12, Jalan Teknologi, 63000 Cyberjaya, Selangor',
   'provider@techpro.my','Provider@123',
   "Dato' Ahmad Syafiq",'Director','+603-8888-1234','approved'),
  ('DesignHub MY','SSM-2345678-B','Private Training Centre',
   'Lot 5, Damansara Perdana, 47820 Petaling Jaya',
   'info@designhub.my','Provider2@123',
   'Nurul Hidayah','Manager','+603-7777-5678','approved'),
  ('MarketPro Institute','SSM-3456789-C','Professional Body',
   'Level 8, Menara KL, 50450 Kuala Lumpur',
   'contact@marketpro.my','Provider3@123',
   'Raj Subramaniam','CEO','+603-2222-9876','approved');

-- Pending provider (password: Pending@123)
INSERT IGNORE INTO providers
  (org_name, reg_no, org_type, address, email, password, contact_name, contact_role, phone, status)
VALUES
  ('LearnHub Malaysia','SSM-9876543-X','Private Training Centre',
   'No. 3, Jalan Duta, 50480 Kuala Lumpur',
   'pending@learn.my','Pending@123',
   'Tan Wei Ming','Director','+603-3333-1111','pending');

-- Student (password: Student@123)
INSERT IGNORE INTO students (first_name, last_name, email, password, phone, education)
VALUES ('Alex','Rahim','student@eduskill.my','Student@123','+60 12-345 6789',"Bachelor's Degree");

-- Courses
INSERT IGNORE INTO courses (provider_id, title, category, description, level, duration, price)
VALUES
  (1,'Full-Stack Web Development',  'Technology','Master HTML, CSS, JavaScript, PHP & MySQL.','Beginner',    '8 Weeks', 1500.00),
  (1,'Python for Data Science',     'Technology','NumPy, pandas, and ML fundamentals.',       'Intermediate','10 Weeks',1800.00),
  (2,'UI/UX Design Fundamentals',   'Design',    'User research, wireframing, prototyping.',  'Intermediate','6 Weeks', 1500.00),
  (2,'Graphic Design Essentials',   'Design',    'Photoshop, Illustrator, and Canva.',        'Beginner',    '4 Weeks',  950.00),
  (3,'Digital Marketing Mastery',   'Business',  'SEO, social media, and paid advertising.',  'Beginner',    '4 Weeks', 1500.00),
  (3,'Business Communication',      'Business',  'Professional writing and presentation.',    'Beginner',    '3 Weeks',  800.00);
