<?php
include '../config/db.php';
include '../includes/header.php';

// Fetch classes for dropdown
$classes = $conn->query("SELECT * FROM classes");

$students = [];
if(isset($_POST['class_id'])){
    $class_id = $_POST['class_id'];
    $subject = $_POST['subject'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE class_id=?");
    $stmt->bind_param("i",$class_id);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

if(isset($_POST['add_marks'])){
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $marks_list = $_POST['marks']; // student_id => marks

    foreach($marks_list as $student_id => $marks){
        // Calculate grade
        $grade = '';
        if($marks >= 90) $grade='A+';
        elseif($marks >= 80) $grade='A';
        elseif($marks >= 70) $grade='B+';
        elseif($marks >= 60) $grade='B';
        elseif($marks >= 50) $grade='C';
        else $grade='F';

        // Check if record exists
        $check = $conn->prepare("SELECT * FROM exams WHERE student_id=? AND subject=?");
        $check->bind_param("is",$student_id,$subject);
        $check->execute();
        $res = $check->get_result();

        if($res->num_rows>0){
            // Update
            $upd = $conn->prepare("UPDATE exams SET marks=?, grade=? WHERE student_id=? AND subject=?");
            $upd->bind_param("disi",$marks,$grade,$student_id,$subject);
            $upd->execute();
        } else {
            // Insert
            $ins = $conn->prepare("INSERT INTO exams (student_id, subject, marks, grade) VALUES (?,?,?,?)");
            $ins->bind_param("isds",$student_id,$subject,$marks,$grade);
            $ins->execute();
        }
    }
    $success = "Marks added successfully!";
}
?>

<h2 class="mb-4">Add Exam Marks</h2>

<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

<form method="post" class="mb-3">
    <div class="row mb-3">
        <div class="col-md-4">
            <label>Class</label>
            <select name="class_id" class="form-control" required onchange="this.form.submit()">
                <option value="">Select Class</option>
                <?php while($c = $classes->fetch_assoc()){
                    $selected = (isset($class_id) && $c['id']==$class_id)?'selected':'';
                    echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
                } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" value="<?php echo isset($subject)?$subject:''; ?>" required>
        </div>
        <div class="col-md-4">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo isset($date)?$date:date('Y-m-d'); ?>" required>
        </div>
    </div>
</form>

<?php if(count($students)>0): ?>
<form method="post">
    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
    <input type="hidden" name="subject" value="<?php echo $subject; ?>">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $s): ?>
            <tr>
                <td><?php echo $s['id']; ?></td>
                <td><?php echo $s['name']; ?></td>
                <td>
                    <input type="number" name="marks[<?php echo $s['id']; ?>]" class="form-control" max="100" min="0" required>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button name="add_marks" class="btn btn-success">Save Marks</button>
</form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>