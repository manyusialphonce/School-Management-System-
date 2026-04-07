<?php
include '../config/db.php';
include '../includes/header.php';

if(!isset($_GET['id'])){
    header('Location: list.php');
    exit();
}

$id = $_GET['id'];

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Fetch classes
$classes = $conn->query("SELECT * FROM classes");

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $class_id = $_POST['class_id'];
    $parent_contact = $_POST['parent_contact'];

    $stmt = $conn->prepare("UPDATE students SET name=?, dob=?, class_id=?, parent_contact=? WHERE id=?");
    $stmt->bind_param("ssisi", $name, $dob, $class_id, $parent_contact, $id);
    $stmt->execute();
    header('Location: list.php');
}
?>

<h2 class="mb-4">Edit Student</h2>
<form method="post">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Date of Birth</label>
        <input type="date" name="dob" class="form-control" value="<?php echo $student['dob']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Class</label>
        <select name="class_id" class="form-control" required>
            <option value="">Select Class</option>
            <?php while($c = $classes->fetch_assoc()){
                $selected = $c['id'] == $student['class_id'] ? "selected" : "";
                echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
            } ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Parent Contact</label>
        <input type="text" name="parent_contact" class="form-control" value="<?php echo $student['parent_contact']; ?>" required>
    </div>
    <button name="update" class="btn btn-primary">Update Student</button>
</form>

<?php include '../includes/footer.php'; ?>