<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "scholarlend_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit; // Ensure no further output
}

// Check if the transaction_id is provided
if (isset($_GET['transaction_id'])) {
    $transactionId = $_GET['transaction_id'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT yearofstudy, gwa, school_community, spending_pattern, 
                                   monthly_savings, loan_purpose, loan_amount, 
                                   month_allowance, source_of_allowance 
                            FROM borrower_info 
                            WHERE transaction_id = ?");
    $stmt->bind_param("s", $transactionId);

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Check if any row is returned
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    } else {
        echo json_encode(['error' => 'SQL execution error']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Transaction ID not provided']);
}

$conn->close();
?>
