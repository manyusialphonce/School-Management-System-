<?php
include '../config/db.php';
include '../includes/header.php';

$classes = $conn->query("SELECT * FROM classes");
$students = [];

if(isset($_POST['class_id'])){
    $class_id = $_POST['class_id'];
    $subject = $_POST['subject'];

    $stmt = $conn->prepare("
        SELECT s.id, s.name, e.marks, e.grade
        FROM students s
        LEFT JOIN exams e ON s.id=e.student_id AND e.subject=?
        WHERE s.class_id=?");
    $stmt->bind_param("si",$subject,$class_id);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<h2 class="mb-4">Exam Results</h2>

<form method="post" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label>Class</label>
            <select name="class_id" class="form-control" required>
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
        <div class="col-md-4 mt-4">
            <button class="btn btn-primary mt-2">View Results</button>
        </div>
    </div>
</form>

<?php if(count($students)>0): ?>
<table class="table table-striped table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Marks</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($students as $s): ?>
        <tr>
            <td><?php echo $s['id']; ?></td>
            <td><?php echo $s['name']; ?></td>
            <td><?php echo isset($s['marks'])?$s['marks']:'N/A'; ?></td>
            <td><?php echo isset($s['grade'])?$s['grade']:'N/A'; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>