<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get current user data
$res = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($res);

$error = '';
$success = '';

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $city = mysqli_real_escape_string($conn,$_POST['city']);
    $caste = mysqli_real_escape_string($conn,$_POST['caste']);

    // Photo upload
    if(isset($_FILES['photo']) && $_FILES['photo']['name'] != ''){
        $photo_name = time().'_'.$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'],'uploads/'.$photo_name);
    } else {
        $photo_name = $user['photo'];
    }

    $update = mysqli_query($conn,"UPDATE users SET name='$name', age='$age', city='$city', caste='$caste', photo='$photo_name' WHERE id='$user_id'");

    if($update){
        $success = "Profile updated successfully!";
        $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'"));
    }else{
        $error = "Failed to update profile!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<style>
body{font-family:Arial; background:linear-gradient(135deg,#8b0000,#b22222,#ff4d6d); color:white; margin:0; padding:0;}
.container{max-width:500px; margin:50px auto; background:rgba(255,255,255,0.1); padding:20px; border-radius:10px; backdrop-filter: blur(10px);}
input[type=text], input[type=number], input[type=file]{width:100%; padding:10px; margin:10px 0; border-radius:5px; border:none;}
input[type=submit]{padding:10px 20px; border:none; background:#ff4d6d; color:white; border-radius:5px; cursor:pointer;}
.success{color:#00ff00;}
.error{color:#ffcccc;}
</style>
</head>
<body>
<div class="container">
<h2>Edit Your Profile</h2>

<?php if($error){echo '<p class="error">'.$error.'</p>';} ?>
<?php if($success){echo '<p class="success">'.$success.'</p>';} ?>

<form method="post" enctype="multipart/form-data">
<label>Name</label>
<input type="text" name="name" value="<?php echo $user['name']; ?>" required>

<label>Age</label>
<input type="number" name="age" value="<?php echo $user['age']; ?>" required>

<label>City</label>
<input type="text" name="city" value="<?php echo $user['city']; ?>" required>

<label>Caste</label>
<input type="text" name="caste" value="<?php echo $user['caste']; ?>" required>

<label>Photo</label>
<input type="file" name="photo">
<?php if($user['photo']){ ?>
<img src="uploads/<?php echo $user['photo']; ?>" width="100">
<?php } ?>

<input type="submit" name="update" value="Update Profile">
</form>

<a href="dashboard.php" style="color:white; text-decoration:underline;">Back to Dashboard</a>
</div>
</body>
</html>