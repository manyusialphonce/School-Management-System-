<?php
include '../config/db.php';
include '../includes/header.php';
?>

<h2 class="mb-4">Students</h2>
<a href="add.php" class="btn btn-success mb-3">Add Student</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>DOB</th>
            <th>Class</th>
            <th>Parent Contact</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT s.*, c.name as class_name FROM students s LEFT JOIN classes c ON s.class_id=c.id";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['dob']}</td>
            <td>{$row['class_name']}</td>
            <td>{$row['parent_contact']}</td>
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