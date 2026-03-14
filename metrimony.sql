CREATE DATABASE IF NOT EXISTS matrimony;
USE matrimony;



CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(100) UNIQUE,
 password VARCHAR(100),
 age INT,
 city VARCHAR(100),
 caste VARCHAR(100),
 photo VARCHAR(255),
 voice VARCHAR(255),
 last_seen DATETIME,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE requests (
 id INT AUTO_INCREMENT PRIMARY KEY,
 sender_id INT,
 receiver_id INT,
 status VARCHAR(20) DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messages (
 id INT AUTO_INCREMENT PRIMARY KEY,
 sender_id INT,
 receiver_id INT,
 message TEXT,
 read_status INT DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE likes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 liked_user_id INT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pass_profiles (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 passed_user_id INT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE chat_requests (
 id INT AUTO_INCREMENT PRIMARY KEY,
 sender_id INT,
 receiver_id INT,
 status VARCHAR(20) DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
