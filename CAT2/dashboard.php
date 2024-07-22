<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user role
$role_id = $_SESSION['role_id'];

if ($role_id == 1) {
    echo "Welcome Admin!";
    header("Location: admin_dashboard.php");
    // Display admin dashboard
} elseif ($role_id == 2) {
    echo "Welcome Teacher!";
    // Display teacher dashboard
} elseif ($role_id == 3) {
    echo "Welcome Student!";
    // Display student dashboard
} elseif ($role_id == 4) {
    echo "Welcome Parent!";
    // Display parent dashboard
}
?>
