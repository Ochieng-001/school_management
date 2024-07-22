<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Create or edit exam
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $class_id = $_POST['class_id'];
    $section_id = $_POST['section_id'];
    $date = $_POST['date'];
    $exam_id = $_POST['exam_id'];

    if ($exam_id) {
        $sql = "UPDATE exams SET exam_name='$exam_name', class_id='$class_id', section_id='$section_id', date='$date' WHERE id='$exam_id'";
    } else {
        $sql = "INSERT INTO exams (exam_name, class_id, section_id, date) VALUES ('$exam_name', '$class_id', '$section_id', '$date')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Exam saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$classes = $conn->query("SELECT * FROM classes");
$sections = $conn->query("SELECT * FROM sections");

// Fetch exam data for editing
$exam_data = null;
if (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];
    $result = $conn->query("SELECT * FROM exams WHERE id='$exam_id'");
    $exam_data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Exam</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Create Exam</h1>
    <form method="POST">
        <input type="hidden" name="exam_id" value="<?php echo $exam_data['id'] ?? ''; ?>">
        <input type="text" name="exam_name" placeholder="Exam Name" value="<?php echo $exam_data['exam_name'] ?? ''; ?>" required>
        <select name="class_id" required>
            <?php while ($class = $classes->fetch_assoc()): ?>
                <option value="<?php echo $class['id']; ?>" <?php
                echo isset($exam_data['class_id']) && $exam_data['class_id'] == $class['id'] ? 'selected' : ''; ?>>
                <?php echo $class['class_name']; ?>
                </option>
                <?php endwhile; ?>
                </select>
                <select name="section_id" required>
                <?php while ($section = $sections->fetch_assoc()): ?>
                <option value="<?php echo $section['id']; ?>" <?php echo isset($exam_data['section_id']) && $exam_data['section_id'] == $section['id'] ? 'selected' : ''; ?>>
                <?php echo $section['section_name']; ?>
                </option>
                <?php endwhile; ?>
                </select>
                <input type="date" name="date" value="<?php echo $exam_data['date'] ?? ''; ?>" required>
                <button type="submit">Save Exam</button>
                </form>
                
                </body>
                </html>