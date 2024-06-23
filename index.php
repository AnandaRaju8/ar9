<?php
include 'db.php';
$query = $conn->query("SELECT student.*, classes.name AS class_name FROM student JOIN classes ON student.class_id = classes.class_id");
$students = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>School Demo</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    *{
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
    }
    h1{
        text-align: center;
        padding: 10px;
    }
    </style>
</head>
<body>
<div class="container">
    <h1>Students List</h1>
    <a href="create.php" class="btn btn-primary btn-rounded" style="margin-bottom:15px;">Add Student</a>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Email</th>
            
            <th>Class</th>
            <th>Image</th>
            <th>Actions</th>
            <th>Creation Date</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?php echo $student['name']; ?></td>
            <td><?php echo $student['email']; ?></td>
            
            <td><?php echo $student['class_name']; ?></td>
            <td><img src="uploads/<?php echo $student['image']; ?>" alt="" width="50"></td>
            <td>
                <a href="view.php?id=<?php echo $student['id']; ?>" class="btn btn-info">View</a>
                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Edit</a>
                <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger">Delete</a>
            </td>
            <td><?php echo $student['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
