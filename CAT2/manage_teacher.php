<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Add or edit teacher
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $teacher_id = $_POST['teacher_id'];

    if ($teacher_id) {
        $sql = "UPDATE teachers SET name='$name', contact='$contact', email='$email' WHERE id='$teacher_id'";
    } else {
        $sql = "INSERT INTO teachers (name, contact, email) VALUES ('$name', '$contact', '$email')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Teacher information saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch teacher data for editing
$teacher_data = null;
if (isset($_GET['teacher_id'])) {
    $teacher_id = $_GET['teacher_id'];
    $result = $conn->query("SELECT * FROM teachers WHERE id='$teacher_id'");
    $teacher_data = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Teacher</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Manage Teacher</h1>
    <form method="POST">
        <input type="hidden" name="teacher_id" value="<?php echo $teacher_data['id'] ?? ''; ?>">
        <input type="text" name="name" placeholder="Name" value="<?php echo $teacher_data['name'] ?? ''; ?>" required>
        <input type="text" name="contact" placeholder="Contact" value="<?php echo $teacher_data['contact'] ?? ''; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo $teacher_data['email'] ?? ''; ?>" required>
        <button type="submit">Save Teacher</button>
    </form>
</body>
</html>
