<?php
include 'config/db.php';
session_start();
if(!isset($_SESSION['username'])){
    header('Location: index.php');
    exit();
}
include 'includes/header.php';

// Fetch stats
$studentsCount = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];
$teachersCount = $conn->query("SELECT COUNT(*) as total FROM teachers")->fetch_assoc()['total'];
$classesCount = $conn->query("SELECT COUNT(*) as total FROM classes")->fetch_assoc()['total'];
$feesCollected = $conn->query("SELECT SUM(amount) as total FROM fees WHERE status='Paid'")->fetch_assoc()['total'];
?>

<h2 class="mb-4">Dashboard</h2>
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Students</h5>
                <p class="card-text fs-3"><?php echo $studentsCount; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Teachers</h5>
                <p class="card-text fs-3"><?php echo $teachersCount; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Classes</h5>
                <p class="card-text fs-3"><?php echo $classesCount; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Fees Collected</h5>
                <p class="card-text fs-3">$<?php echo number_format($feesCollected,2); ?></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>