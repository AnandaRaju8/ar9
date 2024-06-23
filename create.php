<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image file type
    if (in_array($imageFileType, ['jpg', 'png'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $email, $address, $class_id, $image]);
        
        header('Location: index.php');
    } else {
        echo "Invalid image format. Only JPG and PNG are allowed.";
    }
}

$classes = $conn->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        h1{
            text-align:center;
            margin-bottom:10px;
            padding:10px;
        }
        .btn{
            margin-top:10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Create Student</h1>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Class:</label>
            <select name="class_id" class="form-control">
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Image:</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Create</button>
        <a href="index.php" class="btn btn-light">Cancel</button>
    </form>
</div>
</body>
</html>
