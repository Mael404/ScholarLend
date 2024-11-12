<?php
// Start the session and connect to the database
session_start();
require 'condb.php'; // include your database connection file

// Check if the message ID was sent
if (isset($_POST['id'])) {
    $message_id = $_POST['id'];

    // Update the message status to "read"
    $sql = "UPDATE messages SET status = 'read' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
