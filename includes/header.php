<?php
session_start();
if(!isset($_SESSION['username'])){
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Management System</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="bg-success text-white p-3 vh-100" style="width: 220px;">
        <h3 class="text-center">School SMS</h3>
        <ul class="nav flex-column mt-4">
            <li class="nav-item"><a href="../dashboard.php" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="../students/list.php" class="nav-link text-white">Students</a></li>
            <li class="nav-item"><a href="../teachers/list.php" class="nav-link text-white">Teachers</a></li>
            <li class="nav-item"><a href="../classes/list.php" class="nav-link text-white">Classes</a></li>
            <li class="nav-item"><a href="../attendance/view.php" class="nav-link text-white">Attendance</a></li>
            <li class="nav-item"><a href="../exams/results.php" class="nav-link text-white">Exams</a></li>
            <li class="nav-item"><a href="../fees/list.php" class="nav-link text-white">Fees</a></li>
            <li class="nav-item"><a href="../index.php?logout=1" class="nav-link text-white">Logout</a></li>
        </ul>
    </nav>
    <!-- Page Content -->
    <div class="flex-grow-1 p-4">