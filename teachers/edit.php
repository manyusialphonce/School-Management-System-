<?php
include '../config/db.php';
include '../includes/header.php';

if(!isset($_GET['id'])){
    header('Location: list.php');
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM teachers WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("UPDATE teachers SET name=?, subject=?, contact=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $subject, $contact, $id);
    $stmt->execute();
    header('Location: list.php');
}
?>

<h2 class="mb-4">Edit Teacher</h2>
<form method="post">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $teacher['name']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Subject</label>
        <input type="text" name="subject" class="form-control" value="<?php echo $teacher['subject']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control" value="<?php echo $teacher['contact']; ?>" required>
    </div>
    <button name="update" class="btn btn-primary">Update Teacher</button>
</form>

<?php include '../includes/footer.php'; ?>