<?php
session_start();
include("db.php");

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>

<title>Profile</title>

<style>

body{
font-family:Arial;
background:#ff4d6d;
text-align:center;
color:white;
}

.card{
background:white;
color:black;
width:350px;
margin:auto;
margin-top:100px;
padding:20px;
border-radius:10px;
}

img{
width:200px;
height:200px;
border-radius:50%;
object-fit:cover;
}

button{
padding:10px 15px;
background:#ff4d6d;
border:none;
color:white;
margin-top:10px;
cursor:pointer;
}

</style>

</head>

<body>

<div class="card">

<img src="uploads/<?php echo $row['photo']; ?>">

<h2><?php echo $row['name']; ?></h2>

<p>🎂 Age: <?php echo $row['age']; ?></p>

<p>📍 City: <?php echo $row['city']; ?></p>

<p>💫 Caste: <?php echo $row['caste']; ?></p>

<p>📧 Email: <?php echo $row['email']; ?></p>

<a href="send_request.php?id=<?php echo $row['id']; ?>">
<button>💌 Send Request</button>
</a>

</div>

</body>
</html>