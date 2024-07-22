<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Process results
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $exam_id = $_POST['exam_id'];
    $marks = $_POST['marks'];

    $sql = "INSERT INTO results (student_id, exam_id, marks) VALUES ('$student_id', '$exam_id', '$marks')";

    if ($conn->query($sql) === TRUE) {
        echo "Results processed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$students = $conn->query("SELECT * FROM students");
$exams = $conn->query("SELECT * FROM exams");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Process Results</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Process Results</h1>
    <form method="POST">
        <select name="student_id" required>
            <?php while ($student = $students->fetch_assoc()): ?>
                <option value="<?php echo $student['id']; ?>">
                    <?php echo $student['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="exam_id" required>
            <?php while ($exam = $exams->fetch_assoc()): ?>
                <option value="<?php echo $exam['id']; ?>">
                    <?php echo $exam['exam_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="marks" placeholder="Marks" required>
        <button type="submit">Process Results</button>
    </form>
</body>
</html>
