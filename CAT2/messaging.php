<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Send message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$users = $conn->query("SELECT * FROM users WHERE id != '".$_SESSION['user_id']."'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Internal Messaging</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Internal Messaging</h1>
    <form method="POST">
        <select name="receiver_id" required>
            <?php while ($user = $users->fetch_assoc()): ?>
                <option value="<?php echo $user['id']; ?>">
                    <?php echo $user['username']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <textarea name="message" placeholder="Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</body>
</html>
