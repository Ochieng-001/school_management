<?php
include 'config.php';
session_start();

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .dashboard h1 {
            margin-bottom: 20px;
        }

        .dashboard a {
            display: block;
            width: 200px;
            padding: 15px;
            margin: 10px;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .dashboard a:hover {
            background-color: #45a049;
        }

        .dashboard .link-button {
            background-color: #2196F3;
        }

        .dashboard .link-button:hover {
            background-color: #0b7dda;
        }

        .dashboard .logout {
            background-color: #f44336;
        }

        .dashboard .logout:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Admin Dashboard</h1>
        <a href="register.php" class="link-button">Add User</a>
        <a href="add_student.php" class="link-button">Add Student</a>
        <a href="add_teacher.php" class="link-button">Add Teacher</a>
        <a href="manage_classes.php" class="link-button">Manage Classes</a>
        <a href="upload_assignment.php" class="link-button">Upload Assignment</a>
        <a href="result_processing.php" class="link-button">Process Results</a>
        <a href="internal_messaging.php" class="link-button">Internal Messaging</a>
        <a href="announcement_board.php" class="link-button">Announcement Board</a>
        <a href="notification.php" class="link-button">Send Notifications</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
