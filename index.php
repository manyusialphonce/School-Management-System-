<?php
session_start();
require 'config/db.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows==1){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: dashboard.php');
            exit;
        }else{
            $error = "Invalid password!";
        }
    }else{
        $error = "User not found! Please <a href='register.php'>register</a> first.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - School SMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="login-box mt-5">
    <h3>School SMS Login</h3>
    <?php if(isset($error)){ echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="post">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button name="login" class="btn btn-custom">Login</button>
    </form>
    <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>