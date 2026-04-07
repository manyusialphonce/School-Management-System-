<?php
include '../config/db.php';
include '../includes/header.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $class_id = $_POST['class_id'];
    $parent_contact = $_POST['parent_contact'];

    $stmt = $conn->prepare("INSERT INTO students (name, dob, class_id, parent_contact) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $dob, $class_id, $parent_contact);
    $stmt->execute();
    header('Location: list.php');
}

// Fetch classes
$classes = $conn->query("SELECT * FROM classes");
?>

<h2 class="mb-4">Add Student</h2>
<form method="post">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Date of Birth</label>
        <input type="date" name="dob" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Class</label>
        <select name="class_id" class="form-control" required>
            <option value="">Select Class</option>
            <?php while($c = $classes->fetch_assoc()){
                echo "<option value='{$c['id']}'>{$c['name']}</option>";
            } ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Parent Contact</label>
        <input type="text" name="parent_contact" class="form-control" required>
    </div>
    <button name="add" class="btn btn-success">Add Student</button>
</form>

<?php include '../includes/footer.php'; ?>