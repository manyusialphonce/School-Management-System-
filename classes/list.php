<?php
include '../config/db.php';
include '../includes/header.php';
?>

<h2 class="mb-4">Classes</h2>
<a href="add.php" class="btn btn-success mb-3">Add Class</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Class Name</th>
            <th>Teacher</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT c.id, c.name, t.name AS teacher_name 
            FROM classes c 
            LEFT JOIN teachers t ON c.teacher_id = t.id";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['teacher_name']}</td>
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