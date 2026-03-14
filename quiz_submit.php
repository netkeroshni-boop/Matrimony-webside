<?php

session_start();
include("db.php");

$user_id = $_SESSION['user_id'];

$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$q3 = $_POST['q3'];

$score = 0;

if($q1=="travel") $score += 30;
if($q1=="music") $score += 20;
if($q1=="movies") $score += 10;

if($q2=="veg") $score += 30;
if($q2=="nonveg") $score += 20;

if($q3=="home") $score += 20;
if($q3=="outing") $score += 30;

mysqli_query($conn,"UPDATE users SET match_score='$score' WHERE id='$user_id'");

header("Location: dashboard.php");

?>