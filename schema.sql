CREATE DATABASE `47230-yeticave-10`
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE `47230-yeticave-10`;
CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(255) NOT NULL UNIQUE,
    symbol_code CHAR(64) NOT NULL
);
CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_create DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    name CHAR(255) NOT NULL,
    description CHAR(255) NOT NULL,
    image_url CHAR(255) NOT NULL,
    start_price DECIMAL(10,2) NOT NULL,
    date_expire DATETIME NOT NULL,
    bid_step DECIMAL NOT NULL,
    seller_id INT NOT NULL,
    winner_id INT DEFAULT NULL,
    category_id INT NOT NULL
);
CREATE TABLE bid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    value INT NOT NULL,
    user_id INT NOT NULL,
    lot_id INT NOT NULL
);
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    email CHAR(255) NOT NULL UNIQUE,
    name CHAR(255) NOT NULL,
    password CHAR(64) NOT NULL,
    contacts TEXT NOT NULL
);
CREATE INDEX lot_name ON lot(name);
CREATE INDEX lot_desc ON lot(description);
