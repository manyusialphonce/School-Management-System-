<?php
include '../config/db.php';
include '../includes/header.php';

$classes = $conn->query("SELECT * FROM classes");

$students = [];
if(isset($_POST['class_id'])){
    $class_id = $_POST['class_id'];
    $date = $_POST['date'];
    $stmt = $conn->prepare("
        SELECT s.id, s.name, a.status 
        FROM students s 
        LEFT JOIN attendance a ON s.id=a.student_id AND a.class_id=? AND a.date=?
        WHERE s.class_id=?");
    $stmt->bind_param("isi",$class_id,$date,$class_id);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<h2 class="mb-4">View Attendance</h2>

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
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo isset($date)?$date:date('Y-m-d'); ?>" required>
        </div>
        <div class="col-md-4 mt-4">
            <button class="btn btn-primary mt-2">View</button>
        </div>
    </div>
</form>

<?php if(count($students)>0): ?>
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($students as $s): ?>
        <tr>
            <td><?php echo $s['id']; ?></td>
            <td><?php echo $s['name']; ?></td>
            <td><?php echo isset($s['status'])?$s['status']:'Absent'; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>