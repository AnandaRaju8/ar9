<?php
include 'db.php';
$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM student WHERE id = ?");
$query->execute([$id]);
$student = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "DELETE FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    // Delete image file
    if (file_exists('uploads/' . $student['image'])) {
        unlink('uploads/' . $student['image']);
    }

    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Delete Student</h1>
    <p>Are you sure you want to delete <strong><?php echo $student['name']; ?></strong>?</p>
    <form action="delete.php?id=<?php echo $id; ?>" method="POST">
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
