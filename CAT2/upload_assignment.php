<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_id = $_SESSION['user_id'];

    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $filePath = 'uploads/' . basename($fileName);
    move_uploaded_file($fileTmpName, $filePath);

    $sql = "INSERT INTO assignments (title, description, file_path, teacher_id) VALUES ('$title', '$description', '$filePath', '$teacher_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Assignment uploaded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Assignment</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Upload Assignment</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
