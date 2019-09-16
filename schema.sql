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
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    start_price DECIMAL(10, 2) NOT NULL,
    date_expire DATETIME NOT NULL,
    bid_step DECIMAL(10, 2) NOT NULL,
    seller_id INT NOT NULL,
    winner_id INT DEFAULT NULL,
    category_id INT NOT NULL
);
CREATE TABLE bid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    value DECIMAL(10, 2) NOT NULL,
    user_id INT NOT NULL,
    lot_id INT NOT NULL
);
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    password CHAR(64) NOT NULL,
    contacts TEXT NOT NULL
);
CREATE INDEX lot_name ON lot(name);
CREATE FULLTEXT INDEX lot_ft_search ON lot(name, description);
CREATE INDEX fk_idx_seller ON lot(seller_id ASC);
CREATE INDEX fk_idx_user ON bid(user_id ASC);
CREATE INDEX fk_idx_lot ON bid(lot_id ASC);
CREATE INDEX fk_idx_category ON lot(category_id ASC);

ALTER TABLE lot
ADD CONSTRAINT fk_lot_user
    FOREIGN KEY (seller_id)
    REFERENCES user(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE bid
ADD CONSTRAINT fk_bid_user
    FOREIGN KEY (user_id)
    REFERENCES user(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE bid
ADD CONSTRAINT fk_bid_lot
    FOREIGN KEY (lot_id)
    REFERENCES lot(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE lot
ADD CONSTRAINT fk_lot_category
    FOREIGN KEY (category_id)
    REFERENCES category(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
