<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$receiver_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($receiver_id == 0) die("Invalid user.");

// Send message
if(isset($_POST['send'])){
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    if($msg != ''){
        mysqli_query($conn,"INSERT INTO messages (sender_id, receiver_id, message, read_status, created_at) 
                            VALUES ('$user_id','$receiver_id','$msg',0,NOW())");
    }
}

// Fetch chat history
$chat = mysqli_query($conn,"SELECT m.*, u.name, u.photo FROM messages m
                            JOIN users u ON m.sender_id=u.id
                            WHERE (sender_id='$user_id' AND receiver_id='$receiver_id')
                               OR (sender_id='$receiver_id' AND receiver_id='$user_id')
                            ORDER BY m.id ASC");

// Mark unread messages as read
mysqli_query($conn,"UPDATE messages SET read_status=1 WHERE sender_id='$receiver_id' AND receiver_id='$user_id'");

// Receiver info
$receiver = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$receiver_id'"));
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Chat with <?php echo $receiver['name']; ?></title>
<style>
body{font-family:Arial;margin:0;padding:0;background:#f0f0f0;}
.chat-container{max-width:600px;margin:50px auto;background:white;padding:20px;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.2);}
.chat-header{display:flex;align-items:center;margin-bottom:10px;}
.chat-header img{width:50px;height:50px;border-radius:50%;margin-right:10px;}
.chat-header h3{margin:0;}
.messages{max-height:400px;overflow-y:auto;padding:10px;background:#eee;border-radius:10px;}
.message{padding:8px 12px;margin:5px 0;border-radius:10px;max-width:70%;word-wrap:break-word;}
.sender{background:#4CAF50;color:white;margin-left:auto;text-align:right;}
.receiver{background:#ddd;color:black;margin-right:auto;text-align:left;}
form{display:flex;margin-top:15px;}
#message{flex:1;padding:10px;border-radius:20px;border:1px solid #ccc;outline:none;}
#send-btn,#emoji-btn{padding:10px 15px;margin-left:5px;border-radius:20px;border:none;background:#4CAF50;color:white;cursor:pointer;}

/* Back button */
.back-btn{
    background:#4CAF50;
    border:none;
    color:white;
    font-size:16px;
    padding:8px 12px;
    margin-right:10px;
    border-radius:50%;
    cursor:pointer;
}
</style>

<!-- Emoji Picker -->
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/index.min.js"></script>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        <button onclick="history.back()" class="back-btn">⬅</button>
        <img src="uploads/<?php echo $receiver['photo']; ?>" alt="Profile Photo">
        <h3><?php echo $receiver['name']; ?></h3>
    </div>

    <div class="messages" id="messages">
        <?php while($row=mysqli_fetch_assoc($chat)): ?>
            <div class="message <?php echo $row['sender_id']==$user_id ? 'sender':'receiver'; ?>">
                <?php echo htmlspecialchars($row['message']); ?>
            </div>
        <?php endwhile; ?>
    </div>

    <form method="post">
        <input type="text" id="message" name="message" placeholder="Type a message..." required>
        <button type="button" id="emoji-btn">😊</button>
        <input type="submit" name="send" id="send-btn" value="Send">
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const button = document.querySelector('#emoji-btn');
    const input = document.querySelector('#message');

    const picker = new EmojiButton({
        position: 'top-start',
        autoHide: true
    });

    button.addEventListener('click', () => picker.togglePicker(button));

    picker.on('emoji', emoji => {
        input.value += emoji;
        input.focus();
    });

    // Auto scroll to bottom
    const messagesDiv = document.getElementById('messages');
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
});
</script>

</body>
</html>
