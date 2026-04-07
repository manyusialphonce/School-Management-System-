<?php
include '../config/db.php';
include '../includes/header.php';
?>

<h2 class="mb-4">Fees Records</h2>
<a href="add.php" class="btn btn-success mb-3">Add Fee</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT f.*, s.name AS student_name 
            FROM fees f 
            LEFT JOIN students s ON f.student_id=s.id";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['student_name']}</td>
            <td>{$row['amount']}</td>
            <td>{$row['status']}</td>
            <td>{$row['date']}</td>
            <td>
                <a href='edit.php?id={$row['id']}' class='btn btn-primary btn-sm'>Edit</a>
                <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
            </td>
        </tr>";
    }
    ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>