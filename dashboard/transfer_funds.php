<?php
// Database connection
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $borrowerId = intval($_POST['id']);
    
    // Transfer funds logic here (already implemented)

    // Step 1: Get the user_id from borrower_info based on the transaction_id (which is the same as borrowerId)
    $stmt = $conn->prepare("SELECT user_id FROM borrower_info WHERE transaction_id = ?");
    $stmt->bind_param("i", $borrowerId);
    $stmt->execute();
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();

    // Check if user_id was found
    if ($userId) {
        // Step 2: Insert message into the `messages` table
        $message = "Fund is completely transferred";
        $status = "unread";
        $createdAt = date('Y-m-d H:i:s'); // Optional, as it can be automatically set by MySQL

        $stmt = $conn->prepare("INSERT INTO messages (borrower_id, message, status, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $message, $status, $createdAt);

        if ($stmt->execute()) {
            // Step 3: Update the status in borrower_info to "Fund Transferred"
            $updateStmt = $conn->prepare("UPDATE borrower_info SET status = ? WHERE transaction_id = ?");
            $fundTransferredStatus = "Approved";
            $updateStmt->bind_param("si", $fundTransferredStatus, $borrowerId);

            if ($updateStmt->execute()) {
                echo "Message sent and funds transferred successfully! Status updated.";
            } else {
                echo "Error: Could not update status in borrower_info.";
            }

            $updateStmt->close();
        } else {
            echo "Error: Could not send message.";
        }

        $stmt->close();
    } else {
        echo "Error: No matching borrower found.";
    }

    $conn->close();
}
?>
