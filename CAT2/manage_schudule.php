<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Schedule management
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = $_POST['class_id'];
    $section_id = $_POST['section_id'];
    $schedule = $_POST['schedule'];

    $sql = "INSERT INTO schedule (class_id, section_id, schedule) VALUES ('$class_id', '$section_id', '$schedule')";

    if ($conn->query($sql) === TRUE) {
        echo "Schedule saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$classes = $conn->query("SELECT * FROM classes");
$sections = $conn->query("SELECT * FROM sections");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Schedule</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Manage Schedule</h1>
    <form method="POST">
        <select name="class_id" required>
            <?php while ($class = $classes->fetch_assoc()): ?>
                <option value="<?php echo $class['id']; ?>">
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="section_id" required>
            <?php while ($section = $sections->fetch_assoc()): ?>
                <option value="<?php echo $section['id']; ?>">
                    <?php echo $section['section_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <textarea name="schedule" placeholder="Schedule" required></textarea>
        <button type="submit">Save Schedule</button>
    </form>
</body>
</html>
