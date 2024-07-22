<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

// Track attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO attendance (student_id, date, status) VALUES ('$student_id', '$date', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Attendance recorded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$students = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track Attendance</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Track Attendance</h1>
    <form method="POST">
        <select name="student_id" required>
            <?php while ($student = $students->fetch_assoc()): ?>
                <option value="<?php echo $student['id']; ?>">
                    <?php echo $student['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="date" name="date" required>
        <select name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>
        <button type="submit">Record Attendance</button>
    </form>
</body>
</html>