<?php

$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "scholarlend_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['lender_id']) && isset($_POST['transaction_id'])) {
    $lender_id = $_POST['lender_id'];
    $transaction_id = $_POST['transaction_id'];
    $message = "Funds transferred successfully";
    $status = "unread";
    $created_at = date("Y-m-d H:i:s"); // Get the current timestamp
    
    // Insert message into the database
    $sql = "INSERT INTO messages (borrower_id, message, status, created_at) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $lender_id, $message, $status, $created_at);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Message sent successfully']);
        } else {
            echo json_encode(['error' => 'Failed to send message']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the query']);
    }

} else {
    echo json_encode(['error' => 'Lender ID or Transaction ID is missing']);
}

$conn->close();
?>
