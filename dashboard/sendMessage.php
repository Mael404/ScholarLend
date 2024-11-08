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
    
    // Step 1: Retrieve the next_deadlines from borrower_info
    $sql = "SELECT next_deadlines FROM borrower_info WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $borrower_info = $result->fetch_assoc();

    if ($borrower_info) {
        $next_deadlines = $borrower_info['next_deadlines'];

        if ($next_deadlines) {
            // Split the deadlines into an array
            $dates = explode(", ", $next_deadlines);
            
            // Remove the earliest date
            array_shift($dates);

            // Rejoin the remaining dates into a string
            $updated_deadlines = implode(", ", $dates);

            // Update the next_deadlines field in the borrower_info table
            $updateDeadlines = "UPDATE borrower_info SET next_deadlines = ? WHERE transaction_id = ?";
            $stmtUpdate = $conn->prepare($updateDeadlines);
            $stmtUpdate->bind_param("ss", $updated_deadlines, $transaction_id);
            
            if (!$stmtUpdate->execute()) {
                echo json_encode(['error' => 'Failed to update next deadlines']);
                exit();
            }

            $stmtUpdate->close();
        }
    } else {
        echo json_encode(['error' => 'Transaction ID not found in borrower_info']);
        exit();
    }
    
    // Step 2: Check if the transaction_id exists in loan_deadlines
    $checkLoanDeadlines = "SELECT transaction_id FROM loan_deadlines WHERE transaction_id = ?";
    $stmtCheck = $conn->prepare($checkLoanDeadlines);
    $stmtCheck->bind_param("s", $transaction_id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // If it exists, update the status to "Fund Transferred"
        $updateLoanStatus = "UPDATE loan_deadlines SET status = 'Fund Transferred' WHERE transaction_id = ?";
        $stmtUpdateStatus = $conn->prepare($updateLoanStatus);
        $stmtUpdateStatus->bind_param("s", $transaction_id);
        
        if (!$stmtUpdateStatus->execute()) {
            echo json_encode(['error' => 'Failed to update loan status']);
            exit();
        }

        $stmtUpdateStatus->close();
    }
    
    $stmtCheck->close();
    
    // Step 3: Insert message into the messages table
    $sql = "INSERT INTO messages (borrower_id, message, status, created_at) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $lender_id, $message, $status, $created_at);
        
        if ($stmt->execute()) {
            // Redirect to the admin_borrower.php page after success
            header("Location: admin_borrowers.php?status=success");
            exit();
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
