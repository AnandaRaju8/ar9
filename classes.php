<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $sql = "INSERT INTO classes (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name]);
    } elseif (isset($_POST['edit'])) {
        $class_id = $_POST['class_id'];
        $name = $_POST['name'];
        $sql = "UPDATE classes SET name = ? WHERE class_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $class_id]);
    } elseif (isset($_POST['delete'])) {
        $class_id = $_POST['class_id'];
        $sql = "DELETE FROM classes WHERE class_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$class_id]);
    }
}

$classes = $conn->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Manage Classes</h1>
    <form action="classes.php" method="POST">
        <div class="form-group">
            <label>Class Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" name="add" class="btn btn-primary m-2">Add Class</button>
    </form>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($classes as $class): ?>
        <tr>
            <td><?php echo $class['class_id']; ?></td>
            <td><?php echo $class['name']; ?></td>
            <td>
                <form action="classes.php" method="POST" style="display:inline;">
                    <input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">
                    <input type="text" name="name" value="<?php echo $class['name']; ?>">
                    <button type="submit" name="edit" class="btn btn-warning">Edit</button>
                </form>
                <form action="classes.php" method="POST" style="display:inline;">
                    <input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
