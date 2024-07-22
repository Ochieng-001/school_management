<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Add or edit class
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];
    $class_id = $_POST['class_id'];

    if ($class_id) {
        $sql = "UPDATE classes SET class_name='$class_name' WHERE id='$class_id'";
    } else {
        $sql = "INSERT INTO classes (class_name) VALUES ('$class_name')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Class information saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch class data for editing
$class_data = null;
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $result = $conn->query("SELECT * FROM classes WHERE id='$class_id'");
    $class_data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
head>
    <title>Manage Classes</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Manage Classes</h1>
    <form method="POST">
        <input type="hidden" name="class_id" value="<?php echo $class_data['id'] ?? ''; ?>">
        <input type="text" name="class_name" placeholder="Class Name" value="<?php echo $class_data['class_name'] ?? ''; ?>" required>
        <button type="submit">Save Class</button>
    </form>
</body>
</html>
