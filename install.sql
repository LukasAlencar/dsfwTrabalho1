CREATE DATABASE IF NOT EXISTS sistema_login;
USE sistema_login;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('professor', 'aluno') NOT NULL,
    failed_attempts INT DEFAULT 0
);

INSERT INTO users (username, password, role) VALUES 
('professor1', '123456', 'professor'), 
('aluno1', '123456', 'aluno');
