<?php
include '../config/db.php';
include '../includes/header.php';

// Fetch students for dropdown
$students = $conn->query("SELECT * FROM students");

if(isset($_POST['add_fee'])){
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO fees (student_id, amount, status, date) VALUES (?,?,?,?)");
    $stmt->bind_param("idss",$student_id, $amount, $status, $date);
    $stmt->execute();
    $success = "Fee record added successfully!";
}
?>

<h2 class="mb-4">Add Fee</h2>

<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

<form method="post">
    <div class="mb-3">
        <label>Student</label>
        <select name="student_id" class="form-control" required>
            <option value="">Select Student</option>
            <?php while($s = $students->fetch_assoc()){
                echo "<option value='{$s['id']}'>{$s['name']}</option>";
            } ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Amount</label>
        <input type="number" name="amount" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    <button name="add_fee" class="btn btn-success">Add Fee</button>
</form>

<?php include '../includes/footer.php'; ?>