<?php
include '../config/db.php';
include '../includes/header.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $teacher_id = $_POST['teacher_id'];

    $stmt = $conn->prepare("INSERT INTO classes (name, teacher_id) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $teacher_id);
    $stmt->execute();
    header('Location: list.php');
}

// Fetch teachers for dropdown
$teachers = $conn->query("SELECT * FROM teachers");
?>

<h2 class="mb-4">Add Class</h2>
<form method="post">
    <div class="mb-3">
        <label>Class Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Assign Teacher</label>
        <select name="teacher_id" class="form-control">
            <option value="">Select Teacher</option>
            <?php while($t = $teachers->fetch_assoc()){
                echo "<option value='{$t['id']}'>{$t['name']}</option>";
            } ?>
        </select>
    </div>
    <button name="add" class="btn btn-success">Add Class</button>
</form>

<?php include '../includes/footer.php'; ?>