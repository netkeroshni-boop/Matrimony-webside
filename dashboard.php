<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
date_default_timezone_set("Asia/Kolkata");
$time = date("Y-m-d H:i:s");

// Update last activity
mysqli_query($conn,"UPDATE users SET last_activity='$time' WHERE id='$user_id'");

// Logged-in user info
$user_result = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user_row = mysqli_fetch_assoc($user_result);

// Fetch other users
$result = mysqli_query($conn,"SELECT * FROM users WHERE id!='$user_id'");
$current_time = time();

// Latest 5 pending requests
$requests = mysqli_query($conn,"SELECT r.*, u.name, u.photo FROM requests r 
                               JOIN users u ON r.sender_id=u.id
                               WHERE r.receiver_id='$user_id' AND r.status='pending'
                               ORDER BY r.id DESC LIMIT 5");

// Latest 5 unread messages
$messages = mysqli_query($conn,"SELECT m.*, u.name, u.photo, u.id as sender_id FROM messages m 
                               JOIN users u ON m.sender_id=u.id
                               WHERE m.receiver_id='$user_id' AND m.read_status=0
                               ORDER BY m.id DESC LIMIT 5");

$total_notif = mysqli_num_rows($requests) + mysqli_num_rows($messages);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Matrimony Dashboard</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#8b0000,#b22222,#ff4d6d);color:white;}

/* Mini profile */
.mini-card{position:fixed;top:20px;left:20px;z-index:10;}
.mini-card img{width:60px;height:60px;border-radius:50%;object-fit:cover;cursor:pointer;border:2px solid white;box-shadow:0 2px 6px rgba(0,0,0,0.3);}

/* Notification icon */
.notif{position:fixed;top:20px;right:20px;cursor:pointer;z-index:50;}
.notif img{width:40px;height:40px;}
.notif-count{position:absolute;top:-5px;right:-5px;background:red;color:white;font-size:12px;padding:2px 6px;border-radius:50%;font-weight:bold;}

/* Notification popup */
.notif-popup{display:none;position:absolute;top:45px;right:0;width:320px;background:white;color:black;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.3);z-index:50;}
.notif-popup h4{margin:0;padding:10px;border-bottom:1px solid #ddd;font-size:14px;}
.notif-popup .item{display:flex;align-items:center;padding:8px 10px;border-bottom:1px solid #f0f0f0;cursor:pointer;}
.notif-popup .item img{width:35px;height:35px;border-radius:50%;object-fit:cover;margin-right:10px;}
.notif-popup .item:hover{background:#f9f9f9;}
.type{font-size:12px;color:#888;}
.time{font-size:10px;color:#aaa;margin-left:auto;}

/* Top buttons */
.top-buttons{position:fixed;top:90px;right:20px;}
.top-buttons a{background:white;color:#8b0000;padding:8px 15px;border-radius:5px;text-decoration:none;display:block;margin-bottom:5px;font-weight:bold;}

/* Header */
.header{text-align:center;padding:20px;}
.header p{font-size:18px;}

/* Users cards */
.container{display:flex;flex-wrap:wrap;justify-content:center;gap:25px;margin-top:130px;}
.card{background:white;color:black;width:240px;border-radius:10px;overflow:hidden;text-align:center;box-shadow:0 5px 15px rgba(0,0,0,0.3);}
.card img{width:100%;height:200px;object-fit:cover;}
.info{padding:10px;}
.name{font-size:20px;font-weight:bold;}
.status{font-size:12px;font-weight:bold;}
.match{color:#ff4d6d;font-weight:bold;}
.progress{width:100%;background:#ddd;height:8px;border-radius:5px;margin-bottom:10px;}
.progress-bar{height:8px;background:#ff4d6d;border-radius:5px;}
.btn{border:none;padding:8px 12px;margin:4px;border-radius:5px;cursor:pointer;}
.interested{background:#ff4d6d;color:white;}
.not{background:#555;color:white;}
.chat{background:#4CAF50;color:white;}
.profile{background:#333;color:white;}
</style>
</head>
<body>

<!-- Mini profile circle -->
<div class="mini-card">
    <img src="uploads/<?php echo $user_row['photo']; ?>" 
         onclick="window.location.href='profile.php?id=<?php echo $user_id; ?>'">
</div>

<!-- Notification bell -->
<div class="notif">
    <img src="bell.png" alt="Notifications" onclick="toggleNotif()">
    <?php if($total_notif>0): ?>
        <span class="notif-count"><?php echo $total_notif; ?></span>
    <?php endif; ?>

    <div class="notif-popup" id="notifPopup">
        <h4>Notifications</h4>

        <!-- Requests -->
        <?php while($req = mysqli_fetch_assoc($requests)): ?>
            <div class="item" onclick="window.location.href='requests.php'">
                <img src="uploads/<?php echo $req['photo']; ?>">
                <div>
                    <?php echo $req['name']; ?><br>
                    <span class="type">💌 Request</span>
                </div>
                <span class="time"><?php echo isset($req['created_at']) ? date("H:i", strtotime($req['created_at'])) : ''; ?></span>
            </div>
        <?php endwhile; ?>

        <!-- Messages -->
        <?php while($msg = mysqli_fetch_assoc($messages)): ?>
            <div class="item" onclick="window.location.href='chat.php?id=<?php echo $msg['sender_id']; ?>'">
                <img src="uploads/<?php echo $msg['photo']; ?>">
                <div>
                    <?php echo $msg['name']; ?><br>
                    <span class="type">💬 New message</span>
                </div>
                <span class="time"><?php echo isset($msg['created_at']) ? date("H:i", strtotime($msg['created_at'])) : ''; ?></span>
            </div>
        <?php endwhile; ?>

        <?php if($total_notif==0): ?>
            <div style="padding:10px;text-align:center;color:#888;">No notifications</div>
        <?php endif; ?>
    </div>
</div>

<!-- Top buttons -->
<div class="top-buttons">
    <a href="quiz.php">🎮 Quiz</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Header -->
<div class="header">
    <h1>❤️ Welcome <?php echo $_SESSION['user']; ?> ❤️</h1>
    <p>💍 Find Your Perfect Life Partner</p>
</div>

<!-- Users cards -->
<div class="container">
<?php
while($row = mysqli_fetch_assoc($result)):
    $user_last_activity = isset($row['last_activity']) && $row['last_activity'] != null ? strtotime($row['last_activity']) : 0;
    $status = (($current_time - $user_last_activity) < 60) ? "🟢 Online" : "⚫ Offline";
    $match = $row['match_score'];
?>
<div class="card">
    <img src="uploads/<?php echo $row['photo']; ?>">
    <div class="info">
        <div class="name"><?php echo $row['name']; ?></div>
        <div class="status"><?php echo $status; ?></div>
        <p>🎂 Age: <?php echo $row['age']; ?></p>
        <p>📍 <?php echo $row['city']; ?></p>
        <p>💫 <?php echo $row['caste']; ?></p>
        <p class="match">❤️ Compatibility: <?php echo $match; ?>%</p>
        <div class="progress">
            <div class="progress-bar" style="width:<?php echo $match; ?>%"></div>
        </div>
        <a href="profile.php?id=<?php echo $row['id']; ?>"><button class="btn profile">👤 View Profile</button></a>
        <a href="send_request.php?id=<?php echo $row['id']; ?>"><button class="btn interested">❤️ Interested</button></a>
        <a href="pass.php?id=<?php echo $row['id']; ?>"><button class="btn not">💔 Not Interested</button></a>
        <a href="chat.php?id=<?php echo $row['id']; ?>"><button class="btn chat">💬 Chat</button></a>
    </div>
</div>
<?php endwhile; ?>
</div>

<script>
function toggleNotif(){
    var popup = document.getElementById('notifPopup');
    popup.style.display = (popup.style.display==='block') ? 'none' : 'block';
}
document.addEventListener('click', function(e){
    var popup = document.getElementById('notifPopup');
    var notifImg = document.querySelector('.notif img');
    if(!notifImg.contains(e.target) && !popup.contains(e.target)){
        popup.style.display='none';
    }
});
</script>

</body>
</html>