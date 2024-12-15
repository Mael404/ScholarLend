<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get transaction ID and new status from POST request
    $transaction_id = $_POST['id'];
    $status = $_POST['status'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'scholarlend_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verify if the transaction ID exists in the borrower_info table and get user_id
    $checkSql = "SELECT user_id FROM borrower_info WHERE transaction_id = ?";
    if ($checkStmt = $conn->prepare($checkSql)) {
        $checkStmt->bind_param('i', $transaction_id); // 'i' means integer
        $checkStmt->execute();
        $checkStmt->store_result();

        // Check if a matching record was found
        if ($checkStmt->num_rows > 0) {
            $checkStmt->bind_result($user_id);
            $checkStmt->fetch();

            // Update the status in the borrower_info table
            $updateSql = "UPDATE borrower_info SET status = ? WHERE transaction_id = ?";
            if ($updateStmt = $conn->prepare($updateSql)) {
                $updateStmt->bind_param('si', $status, $transaction_id);
                $updateStmt->execute();

                if ($updateStmt->affected_rows > 0) {
                    echo "Status updated successfully";

                    $message = ($status === 'Rejected') 
                    ? "Your loan application has been rejected." 
                    : "Your loan application is approved.";
                
                $subject = ($status === 'Rejected') 
                    ? "Application Rejected" 
                    : "Application Approved";
                
                $messageStatus = "unread";
                $created_at = null; // Leave as NULL if the database can handle it automatically
                
                // Insert a new message into the messages table
                $msgSql = "INSERT INTO messages (borrower_id, message, status, created_at, subject) VALUES (?, ?, ?, ?, ?)";
                if ($msgStmt = $conn->prepare($msgSql)) {
                    // Bind all five parameters
                    $msgStmt->bind_param('issss', $user_id, $message, $messageStatus, $created_at, $subject);
                    $msgStmt->execute();

                        if ($msgStmt->affected_rows > 0) {
                            echo " and message inserted successfully.";
                        } else {
                            echo " but error inserting message.";
                        }

                        $msgStmt->close();
                    } else {
                        echo " but error preparing message statement: " . $conn->error;
                    }

                } else {
                    echo "Error updating status or no changes made.";
                }

                $updateStmt->close();
            } else {
                echo "Error preparing update statement: " . $conn->error;
            }
        } else {
            echo "Transaction ID not found in borrower_info table.";
        }

        $checkStmt->close();
    } else {
        echo "Error preparing check statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
