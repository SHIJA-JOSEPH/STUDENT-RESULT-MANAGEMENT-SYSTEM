-- Secondary School Students Registration System Database

CREATE TABLE IF NOT EXISTS admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admission_number VARCHAR(50) NOT NULL UNIQUE,
    student_name VARCHAR(100) NOT NULL,
    class VARCHAR(20) NOT NULL,
    stream VARCHAR(50),
    region VARCHAR(100),
    district VARCHAR(100),
    parent_name VARCHAR(100) NOT NULL,
    parent_phone VARCHAR(20) NOT NULL,
    school_fees DECIMAL(10, 2) NOT NULL,
    school_fees_paid DECIMAL(10, 2) DEFAULT 0,
    fees_status ENUM('Pending', 'Partial', 'Paid') DEFAULT 'Pending',
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin account (username: admin, password: admin123)
INSERT INTO admin (username, password, email) VALUES 
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@school.com');

-- Create index for faster queries
CREATE INDEX idx_admission ON students(admission_number);
CREATE INDEX idx_student_name ON students(student_name);
CREATE INDEX idx_class ON students(class);
