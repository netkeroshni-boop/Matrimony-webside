<?php
session_start();
include("db.php");

$id=$_GET['id'];

mysqli_query($conn,"UPDATE requests SET status='accepted' WHERE id='$id'");

header("Location: requests.php");
?>