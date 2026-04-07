<?php
include '../config/db.php';
include '../includes/header.php';

if(!isset($_GET['id'])){
    header('Location: list.php');
    exit();
}

$id = $_GET['id'];

// Fetch class
$stmt = $conn->prepare("SELECT * FROM classes WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$class = $stmt->get_result()->fetch_assoc();

// Fetch teachers
$teachers = $conn->query("SELECT * FROM teachers");

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $teacher_id = $_POST['teacher_id'];

    $stmt = $conn->prepare("UPDATE classes SET name=?, teacher_id=? WHERE id=?");
    $stmt->bind_param("sii", $name, $teacher_id, $id);
    $stmt->execute();
    header('Location: list.php');
}
?>

<h2 class="mb-4">Edit Class</h2>
<form method="post">
    <div class="mb-3">
        <label>Class Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $class['name']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Assign Teacher</label>
        <select name="teacher_id" class="form-control">
            <option value="">Select Teacher</option>
            <?php while($t = $teachers->fetch_assoc()){
                $selected = $t['id'] == $class['teacher_id'] ? "selected" : "";
                echo "<option value='{$t['id']}' $selected>{$t['name']}</option>";
            } ?>
        </select>
    </div>
    <button name="update" class="btn btn-primary">Update Class</button>
</form>

<?php include '../includes/footer.php'; ?>