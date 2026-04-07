<?php
include '../config/db.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM classes WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

header('Location: list.php');
exit();