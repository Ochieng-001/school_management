<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    // Check if role_id exists in the roles table
    $roleCheck = $conn->prepare("SELECT id FROM roles WHERE id = ?");
    $roleCheck->bind_param("i", $role_id);
    $roleCheck->execute();
    $roleCheck->store_result();

    if ($roleCheck->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $password, $role_id);

        if ($stmt->execute()) {
            echo "User registered successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid role ID.";
    }

    $roleCheck->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Register</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role_id" required>
            <option value="1">Admin</option>
            <option value="2">Teacher</option>
            <option value="3">Student</option>
            <option value="4">Parent</option>
        </select>
        <button type="submit">Register</button>
    </form>
</body>
</html>
