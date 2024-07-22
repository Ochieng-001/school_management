<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Send notification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Notification sent successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Notification</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Send Notification</h1>
    <form method="POST">
        <select name="user_id" required>
            <?php while ($user = $users->fetch_assoc()): ?>
                <option value="<?php echo $user['id']; ?>">
                    <?php echo $user['username']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <textarea name="message" placeholder="Message" required></textarea>
        <button type="submit">Send Notification</button>
    </form>
</body>
</html>
