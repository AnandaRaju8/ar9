<?php
include 'db.php';
$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM student WHERE id = ?");
$query->execute([$id]);
$student = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $student['image'];

    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg', 'png'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } else {
            echo "Invalid image format. Only JPG and PNG are allowed.";
            exit;
        }
    }

    $sql = "UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $address, $class_id, $image, $id]);

    header('Location: index.php');
}

$classes = $conn->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h1 class="text-center m-2 p-3">Edit Student Details</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo $student['email']; ?>">
        </div>
        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" class="form-control"><?php echo $student['address']; ?></textarea>
        </div>
        <div class="form-group">
            <label>Class:</label>
            <select name="class_id" class="form-control">
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['class_id']; ?>" <?php if ($class['class_id'] == $student['class_id']) echo 'selected'; ?>>
                        <?php echo $class['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Image:</label>
            <input type="file" name="image" class="form-control">
            <img src="uploads/<?php echo $student['image']; ?>" alt="" width="50">
        </div>
        <button type="submit" class="btn btn-primary m-3">Update</button>
        <a href="index.php" class="btn btn-light m-3">Cancel</button>
    </form>
</div>
</body>
</html>
