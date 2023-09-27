CREATE DATABASE my_database;

USE my_database;

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    gbs INT NOT NULL,
    photo VARCHAR(255) NOT NULL,
    value DECIMAL(10, 2) NOT NULL
);
