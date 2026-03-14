<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "matrimony";

// Connect to MySQL
$conn = mysqli_connect($host, $user, $pass);
if (!$conn) die("Connection failed: ".mysqli_connect_error());

// Create DB if not exists
mysqli_query($conn,"CREATE DATABASE IF NOT EXISTS $dbname");
mysqli_select_db($conn,$dbname);

// Create users table
$create_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    age INT NOT NULL,
    city VARCHAR(100) NOT NULL,
    photo VARCHAR(255) DEFAULT '',
    last_seen DATETIME NULL
)";
mysqli_query($conn,$create_table);
?>
