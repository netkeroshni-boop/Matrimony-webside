<?php
session_start();
include("db.php");

$sender = $_SESSION['user_id'];
$receiver = $_GET['id'];

mysqli_query($conn,"INSERT INTO requests(sender_id,receiver_id) VALUES('$sender','$receiver')");

header("Location: dashboard.php");
?>