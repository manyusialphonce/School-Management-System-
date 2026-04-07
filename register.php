<?php
session_start();
require 'config/db.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if username exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows>0){
        $error = "Username already taken!";
    }else{
        $stmt = $conn->prepare("INSERT INTO users(username,password,role) VALUES(?,?,?)");
        $stmt->bind_param("sss",$username,$password,$role);
        $stmt->execute();
        $success = "Account created successfully! You can now <a href='index.php'>login</a>.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - School SMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="login-box mt-5">
    <h3>Register Account</h3>
    <?php
    if(isset($error)){ echo "<div class='alert alert-danger'>$error</div>"; }
    if(isset($success)){ echo "<div class='alert alert-success'>$success</div>"; }
    ?>
    <form method="post">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <select name="role" class="form-control" required>
            <option value="">--Select Role--</option>
            <option value="headmaster">Headmaster/Admin</option>
            <option value="teacher">Teacher</option>
            <option value="secretary">Secretary</option>
            <option value="second_master">Second Master</option>
        </select>
        <button name="register" class="btn btn-custom">Register</button>
    </form>
    <p class="mt-3 text-center">Already have an account? <a href="index.php">Login here</a></p>
</div>
</body>
</html>