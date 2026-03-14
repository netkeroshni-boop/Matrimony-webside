<?php
session_start();
include("db.php");

$error = "";

if(isset($_POST['login'])){

$email = mysqli_real_escape_string($conn,$_POST['email']);
$password = mysqli_real_escape_string($conn,$_POST['password']);

$query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");

if(mysqli_num_rows($query) > 0){

$row = mysqli_fetch_assoc($query);

$_SESSION['user_id'] = $row['id'];
$_SESSION['user'] = $row['name'];

header("Location: dashboard.php");
exit();

}else{
$error = "Invalid Email or Password!";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>

body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#8b0000,#b22222,#ff4d6d);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
color:white;
}

.box{
background:rgba(255,255,255,0.1);
padding:40px;
border-radius:15px;
text-align:center;
width:320px;
backdrop-filter:blur(10px);
}

h1{
margin-bottom:20px;
}

input{
width:100%;
padding:10px;
margin:10px 0;
border:none;
border-radius:5px;
}

button{
width:100%;
padding:10px;
background:white;
color:#8b0000;
border:none;
border-radius:5px;
font-weight:bold;
cursor:pointer;
}

a{
color:#ffdede;
}

</style>

</head>

<body>

<div class="box">

<h1>❤️ Login 💍</h1>

<?php if($error!=""){ echo "<p>$error</p>"; } ?>

<form method="post">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>

</form>

<p>Don't have account? <a href="register.php">Register</a></p>

</div>

</body>
</html>