CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;
CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(255) NOT NULL UNIQUE,
    symbol_code CHAR(128) NOT NULL
);
CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    name CHAR(255) NOT NULL,
    description CHAR(255) NOT NULL,
    image CHAR(255) NOT NULL,
    start_price DECIMAL NOT NULL,
    delete_date DATETIME NOT NULL,
    rate_step DECIMAL NOT NULL,
    user_id INT NOT NULL,
    winner_id INT,
    category_id INT NOT NULL
);
CREATE TABLE rate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    sum DECIMAL NOT NULL,
    user_id INT NOT NULL,
    lot_id INT NOT NULL
);
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_account_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    email CHAR(255) NOT NULL UNIQUE,
    name CHAR(255) NOT NULL UNIQUE,
    password CHAR(64) NOT NULL,
    avatar CHAR(255),
    contacts TEXT NOT NULL,
    lot_id INT,
    rate_id INT
);
CREATE INDEX lot_name ON lot(name);
CREATE INDEX lot_desc ON lot(description);
