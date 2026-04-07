<?php
include '../config/db.php';
include '../includes/header.php';
?>

<h2 class="mb-4">Teachers</h2>
<a href="add.php" class="btn btn-success mb-3">Add Teacher</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $result = $conn->query("SELECT * FROM teachers");
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['subject']}</td>
            <td>{$row['contact']}</td>
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