<?php
include 'db.php';
$id = $_GET['id'];
$query = $conn->prepare("SELECT student.*, classes.name AS class_name FROM student JOIN classes ON student.class_id = classes.class_id WHERE student.id = ?");
$query->execute([$id]);
$student = $query->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h1 class="text-center p-2 m-1">Student Details</h1>
    <div class="card text-center p-4" style="width:400px">
    <img src="uploads/<?php echo $student['image']; ?>" alt="" class="card-img-top rounded-circle img-fluid" style="width:300px;height:300px">
        <div class="card-body">
            <h2 class="card-title"><?php echo $student['name']; ?></h2>
            <p class="card-text">Email: <?php echo $student['email']; ?></p>
            <p class="card-text">Address: <?php echo $student['address']; ?></p>
            <p class="card-text">Class: <?php echo $student['class_name']; ?></p>
            <p class="card-text">Created At: <?php echo $student['created_at']; ?></p>
        </div>
    </div>
    <a href="index.php" class="btn btn-secondary m-3">Back</a>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
