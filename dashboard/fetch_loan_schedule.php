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

// Get transaction_id from the request
$transaction_id = $_GET['transaction_id'] ?? null;

if (!$transaction_id) {
    echo json_encode(["error" => "Transaction ID is required."]);
    exit;
}

// Fetch repayment schedule data from loan_deadlines
$sql_deadlines = "SELECT deadline, amount, created_at AS payment_date, status 
                  FROM loan_deadlines
                  WHERE transaction_id = ? AND status = 'Fund Transferred'";
$stmt_deadlines = $conn->prepare($sql_deadlines);
$stmt_deadlines->bind_param("s", $transaction_id);
$stmt_deadlines->execute();
$result_deadlines = $stmt_deadlines->get_result();

$schedule = [];
while ($row = $result_deadlines->fetch_assoc()) {
    $schedule[] = $row;
}

// Fetch loan details from borrower_info
$sql_borrower = "SELECT next_deadlines, total_amount 
                 FROM borrower_info 
                 WHERE transaction_id = ? AND status ='Approved'";
$stmt_borrower = $conn->prepare($sql_borrower);
$stmt_borrower->bind_param("s", $transaction_id);
$stmt_borrower->execute();
$result_borrower = $stmt_borrower->get_result();

if ($row_borrower = $result_borrower->fetch_assoc()) {
    // Extract next deadlines and loan amount
    $next_deadlines = explode(",", $row_borrower['next_deadlines']); // Assuming multiple dates separated by commas
    $loan_amount = $row_borrower['total_amount'];

    // Merge with repayment schedule
    foreach ($next_deadlines as $deadline) {
        $schedule[] = [
            "deadline" => date("F j, Y", strtotime($deadline)), // Format deadline
            "amount" => $loan_amount,
            "payment_date" => "N/A", // Default value for now
          "status" => "<a href='borrower_applicationform.php' class='btn btn-primary btn-sm pay-now'>PAY NOW</a>"

        ];
    }
    
}

// Close connections
$stmt_deadlines->close();
$stmt_borrower->close();
$conn->close();

// Return as JSON
echo json_encode($schedule);
?>
