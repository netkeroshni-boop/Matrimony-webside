<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Matrimony Home</title>
<link rel="stylesheet" href="style.css">
<style>
/* Full screen hero with red gradient */
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', sans-serif;
}

.hero {
    display: flex;
    flex-direction: column;
    justify-content: center;   /* vertical center */
    align-items: center;       /* horizontal center */
    height: 100vh;
    text-align: center;
    color: #fff;
    background: linear-gradient(135deg, #ff4d6d, #ff1a40); /* romantic red gradient */
    text-shadow: 2px 2px 12px rgba(0,0,0,0.5);
}

/* Main heading */
.hero h1 {
    font-family: 'cursive', sans-serif;
    font-size: 60px;
    margin: 0;
}

/* Make “Matrimony” part redder with heartbeat animation */
.hero h1 span {
    color: #ffd6e0; /* light pink contrast */
    animation: heartbeat 1.5s infinite;
}

/* Heartbeat animation */
@keyframes heartbeat {
    0%,100% { transform: scale(1); }
    25% { transform: scale(1.2); }
    50% { transform: scale(1); }
    75% { transform: scale(1.2); }
}

/* Subtitle */
.hero p {
    font-size: 24px;
    margin: 20px 0;
    color: #ffe6f0; /* soft pink */
}

/* Buttons */
.btn {
    background: #fff;
    color: #ff1a40; /* red */
    padding: 15px 40px;
    margin: 10px;
    border-radius: 50px;
    text-decoration: none;
    font-size: 18px;
    transition: 0.3s;
    cursor: pointer;
    border: none;
}

.btn:hover {
    background: #ffe6f0; /* soft pink hover */
    color: #ff1a40;
}

/* Responsive */
@media (max-width: 768px){
    .hero h1 { font-size: 40px; }
    .hero p { font-size: 18px; }
    .btn { padding: 12px 30px; font-size: 16px; }
}
</style>
</head>
<body>
<div class="hero">
    <h1>❤️ <span>Matrimony</span> 💍</h1>
    <p>Find your perfect life partner & celebrate love ❤️💑</p>
    <div>
        <a href="register.php" class="btn">Register</a>
        <a href="login.php" class="btn">Login</a>
    </div>
</div>
</body>
</html>