<?php
include '../config/db.php';
include '../includes/header.php';

if(isset($_POST['mark'])){
    $class_id = $_POST['class_id'];
    $date = $_POST['date'];
    $statuses = $_POST['status']; // array student_id => status

    foreach($statuses as $student_id => $status){
        // Check if already marked for this date
        $check = $conn->prepare("SELECT * FROM attendance WHERE student_id=? AND class_id=? AND date=?");
        $check->bind_param("iis",$student_id,$class_id,$date);
        $check->execute();
        $res = $check->get_result();
        if($res->num_rows > 0){
            // Update existing
            $upd = $conn->prepare("UPDATE attendance SET status=? WHERE student_id=? AND class_id=? AND date=?");
            $upd->bind_param("siis",$status,$student_id,$class_id,$date);
            $upd->execute();
        } else {
            // Insert new
            $ins = $conn->prepare("INSERT INTO attendance (student_id, class_id, date, status) VALUES (?, ?, ?, ?)");
            $ins->bind_param("iiss",$student_id,$class_id,$date,$status);
            $ins->execute();
        }
    }
    $success = "Attendance marked successfully!";
}

// Fetch classes for dropdown
$classes = $conn->query("SELECT * FROM classes");

// If class selected, fetch students
$students = [];
if(isset($_POST['class_id'])){
    $class_id_selected = $_POST['class_id'];
    $students_res = $conn->query("SELECT * FROM students WHERE class_id=$class_id_selected");
    while($row = $students_res->fetch_assoc()){
        $students[] = $row;
    }
    $selected_date = $_POST['date'];
}
?>

<h2 class="mb-4">Mark Attendance</h2>

<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

<form method="post">
    <div class="row mb-3">
        <div class="col-md-4">
            <label>Class</label>
            <select name="class_id" class="form-control" required onchange="this.form.submit()">
                <option value="">Select Class</option>
                <?php while($c = $classes->fetch_assoc()){
                    $selected = (isset($class_id_selected) && $c['id'] == $class_id_selected) ? "selected" : "";
                    echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
                } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo isset($selected_date) ? $selected_date : date('Y-m-d'); ?>" required onchange="this.form.submit()">
        </div>
    </div>
</form>

<?php if(count($students) > 0): ?>
<form method="post">
    <input type="hidden" name="class_id" value="<?php echo $class_id_selected; ?>">
    <input type="hidden" name="date" value="<?php echo $selected_date; ?>">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $s): 
                // Check existing attendance
                $stmt = $conn->prepare("SELECT status FROM attendance WHERE student_id=? AND class_id=? AND date=?");
                $stmt->bind_param("iis",$s['id'],$class_id_selected,$selected_date);
                $stmt->execute();
                $att = $stmt->get_result()->fetch_assoc();
                $status_checked = isset($att['status']) ? $att['status'] : 'Absent';
            ?>
            <tr>
                <td><?php echo $s['id']; ?></td>
                <td><?php echo $s['name']; ?></td>
                <td>
                    <select name="status[<?php echo $s['id']; ?>]" class="form-control">
                        <option value="Present" <?php echo $status_checked=='Present'?'selected':''; ?>>Present</option>
                        <option value="Absent" <?php echo $status_checked=='Absent'?'selected':''; ?>>Absent</option>
                    </select>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button name="mark" class="btn btn-success">Save Attendance</button>
</form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>