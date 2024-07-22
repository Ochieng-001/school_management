<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Post announcement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $announcement = $_POST['announcement'];

    $sql = "INSERT INTO announcements (announcement) VALUES ('$announcement')";

    if ($conn->query($sql) === TRUE) {
        echo "Announcement posted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$announcements = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Announcement Board</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Announcement Board</h1>
    <form method="POST">
        <textarea name="announcement" placeholder="Write an announcement" required></textarea>
        <button type="submit">Post Announcement</button>
    </form>
    <h2>Recent Announcements</h2>
    <?php while ($announcement = $announcements->fetch_assoc()): ?>
        <div class="announcement">
            <p><?php echo $announcement['announcement']; ?></p>
            <small>Posted on: <?php echo $announcement['created_at']; ?></small>
        </div>
    <?php endwhile; ?>
</body>
</html>
