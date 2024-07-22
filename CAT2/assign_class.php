<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Assign class and section
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_id'];
    $section_id = $_POST['section_id'];

    $sql = "INSERT INTO student_classes (student_id, class_id, section_id) VALUES ('$student_id', '$class_id', '$section_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Class and section assigned successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$students = $conn->query("SELECT * FROM students");
$classes = $conn->query("SELECT * FROM classes");
$sections = $conn->query("SELECT * FROM sections");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Class and Section</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Assign Class and Section</h1>
    <form method="POST">
        <select name="student_id" required>
            <?php while ($student = $students->fetch_assoc()): ?>
                <option value="<?php echo $student['id']; ?>">
                    <?php echo $student['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="class_id" required>
            <?php while ($class = $classes->fetch_assoc()): ?>
                <option value="<?php echo $class['id']; ?>">
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="section_id" required>
            <?php while ($section = $sections->fetch_assoc()): ?>
                <option value="<?php echo $section['id']; ?>">
                    <?php echo $section['section_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Assign Class and Section</button>
    </form>
</body>
</html>
