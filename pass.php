<?php
session_start();
include("db.php");

$user_id = $_SESSION['user_id'];
$pass_id = $_GET['id'];

mysqli_query($conn,"INSERT INTO pass_profiles(user_id,pass_id)
VALUES('$user_id','$pass_id')");

header("Location: dashboard.php");
?>