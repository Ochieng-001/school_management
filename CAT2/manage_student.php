<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Add or edit student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $class_id = $_POST['class_id'];
    $section_id = $_POST['section_id'];
    $student_id = $_POST['student_id'];

    if ($student_id) {
        $sql = "UPDATE students SET name='$name', address='$address', contact='$contact', class_id='$class_id', section_id='$section_id' WHERE id='$student_id'";
    } else {
        $sql = "INSERT INTO students (name, address, contact, class_id, section_id) VALUES ('$name', '$address', '$contact', '$class_id', '$section_id')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Student information saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch student data for editing
$student_data = null;
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $result = $conn->query("SELECT * FROM students WHERE id='$student_id'");
    $student_data = $result->fetch_assoc();
}

$classes = $conn->query("SELECT * FROM classes");
$sections = $conn->query("SELECT * FROM sections");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Student</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Manage Student</h1>
    <form method="POST">
        <input type="hidden" name="student_id" value="<?php echo $student_data['id'] ?? ''; ?>">
        <input type="text" name="name" placeholder="Name" value="<?php echo $student_data['name'] ?? ''; ?>" required>
        <input type="text" name="address" placeholder="Address" value="<?php echo $student_data['address'] ?? ''; ?>" required>
        <input type="text" name="contact" placeholder="Contact" value="<?php echo $student_data['contact'] ?? ''; ?>" required>
        <select name="class_id" required>
            <?php while ($class = $classes->fetch_assoc()): ?>
                <option value="<?php echo $class['id']; ?>" <?php echo isset($student_data['class_id']) && $student_data['class_id'] == $class['id'] ? 'selected' : ''; ?>>
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="section_id" required>
            <?php while ($section = $sections->fetch_assoc()): ?>
                <option value="<?php echo $section['id']; ?>" <?php echo isset($student_data['section_id']) && $student_data['section_id'] == $section['id'] ? 'selected' : ''; ?>>
                    <?php echo $section['section_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Save Student</button>
    </form>
</body>
</html>
