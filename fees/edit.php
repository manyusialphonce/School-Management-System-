<?php
include '../config/db.php';
include '../includes/header.php';

if(!isset($_GET['id'])){
    header('Location: list.php');
    exit();
}

$id = $_GET['id'];

// Fetch fee record
$stmt = $conn->prepare("SELECT * FROM fees WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$fee = $stmt->get_result()->fetch_assoc();

// Fetch students for dropdown
$students = $conn->query("SELECT * FROM students");

if(isset($_POST['update_fee'])){
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE fees SET student_id=?, amount=?, status=?, date=? WHERE id=?");
    $stmt->bind_param("idssi",$student_id,$amount,$status,$date,$id);
    $stmt->execute();
    header('Location: list.php');
}
?>

<h2 class="mb-4">Edit Fee</h2>
<form method="post">
    <div class="mb-3">
        <label>Student</label>
        <select name="student_id" class="form-control" required>
            <?php while($s = $students->fetch_assoc()){
                $selected = $s['id']==$fee['student_id']?'selected':'';
                echo "<option value='{$s['id']}' $selected>{$s['name']}</option>";
            } ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Amount</label>
        <input type="number" name="amount" class="form-control" value="<?php echo $fee['amount']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="Paid" <?php echo $fee['status']=='Paid'?'selected':''; ?>>Paid</option>
            <option value="Unpaid" <?php echo $fee['status']=='Unpaid'?'selected':''; ?>>Unpaid</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="<?php echo $fee['date']; ?>" required>
    </div>
    <button name="update_fee" class="btn btn-primary">Update Fee</button>
</form>

<?php include '../includes/footer.php'; ?>