<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<title>Love Match Quiz</title>

<style>

body{
font-family:Arial;
background:#ff4d6d;
text-align:center;
color:white;
}

.box{
background:white;
color:black;
width:400px;
margin:auto;
margin-top:100px;
padding:30px;
border-radius:10px;
}

button{
background:#ff4d6d;
border:none;
color:white;
padding:10px 20px;
margin-top:10px;
cursor:pointer;
}

</style>

</head>

<body>

<div class="box">

<h2>💘 Love Compatibility Quiz</h2>

<p>Favourite Activity?</p>

<button onclick="result()">Travel</button>
<button onclick="result()">Movies</button>
<button onclick="result()">Music</button>

<p id="match"></p>

</div>

<script>

function result(){

var percent=Math.floor(Math.random()*100)+1;

document.getElementById("match").innerHTML =
"❤️ Your Match Compatibility: "+percent+"%";

}

</script>

</body>

</html>