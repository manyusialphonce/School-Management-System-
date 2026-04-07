<?php
include '../config/db.php';
include '../includes/header.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("INSERT INTO teachers (name, subject, contact) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $subject, $contact);
    $stmt->execute();
    header('Location: list.php');
}
?>

<h2 class="mb-4">Add Teacher</h2>
<form method="post">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Subject</label>
        <input type="text" name="subject" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control" required>
    </div>
    <button name="add" class="btn btn-success">Add Teacher</button>
</form>

<?php include '../includes/footer.php'; ?>