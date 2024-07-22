<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

echo "Welcome Teacher!";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Teacher Dashboard</h1>
    <a href="upload_assignment.php">Upload Assignment</a>
    <a href="attendance.php">Track Attendance</a>
    <a href="logout.php">Logout</a>
</body>
</html>
