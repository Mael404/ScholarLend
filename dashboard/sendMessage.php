<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scholarlend_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

if (isset($_POST['lender_id']) && isset($_POST['transaction_id'])) {
    $lender_id = $_POST['lender_id'];
    $transaction_id = $_POST['transaction_id'];
    $message = "Funds transferred successfully";
    $status = "unread";
    $created_at = date("Y-m-d H:i:s");
    
    $sql = "SELECT next_deadlines FROM borrower_info WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $borrower_info = $result->fetch_assoc();

    if ($borrower_info) {
        $next_deadlines = $borrower_info['next_deadlines'];

        if ($next_deadlines) {
            $dates = explode(", ", $next_deadlines);
            array_shift($dates);
            $updated_deadlines = implode(", ", $dates);

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
    
    $checkLoanDeadlines = "SELECT transaction_id FROM loan_deadlines WHERE transaction_id = ?";
    $stmtCheck = $conn->prepare($checkLoanDeadlines);
    $stmtCheck->bind_param("s", $transaction_id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
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
exit();
?>
