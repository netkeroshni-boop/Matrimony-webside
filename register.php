<?php
session_start();
include("db.php");

$msg="";

if(isset($_POST['register'])){

$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$gender=$_POST['gender'];
$age=$_POST['age'];
$city=$_POST['city'];
$caste=$_POST['caste'];
$question=$_POST['question'];
$answer=$_POST['answer'];

$photo=$_FILES['photo']['name'];
$tmp=$_FILES['photo']['tmp_name'];

$folder="uploads/".$photo;

if(move_uploaded_file($tmp,$folder)){

$query="INSERT INTO users(name,email,password,gender,age,city,caste,photo,security_question,security_answer)
VALUES('$name','$email','$password','$gender','$age','$city','$caste','$photo','$question','$answer')";

if(mysqli_query($conn,$query)){
$msg="Registration Successful! Please Login.";
}else{
$msg="Database Error!";
}

}else{
$msg="Photo upload failed!";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>

body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#ff4d6d,#ff1a40,#8b0000);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
color:white;
}

.box{
background:rgba(255,255,255,0.1);
padding:35px;
border-radius:15px;
width:350px;
backdrop-filter:blur(10px);
text-align:center;
}

input,select{
width:100%;
padding:10px;
margin:8px 0;
border:none;
border-radius:5px;
}

button{
width:100%;
padding:10px;
margin-top:10px;
background:white;
color:#8b0000;
border:none;
border-radius:5px;
font-weight:bold;
cursor:pointer;
}

.msg{
margin-bottom:10px;
}

</style>

</head>

<body>

<div class="box">

<h1>💍 Register ❤️</h1>

<div class="msg"><?php echo $msg; ?></div>

<form method="post" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<select name="gender" required>
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
</select>

<input type="number" name="age" placeholder="Age" required>

<input type="text" name="city" placeholder="City">

<input type="text" name="caste" placeholder="Caste">

<input type="file" name="photo" required>

<select name="question">
<option>What is your favorite color?</option>
<option>What is your pet name?</option>
<option>What is your childhood nickname?</option>
</select>

<input type="text" name="answer" placeholder="Security Answer">

<button name="register">Register</button>

</form>

<p>Already have account? <a href="login.php">Login</a></p>

</div>

</body>
</html>
