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
// Retrieve transaction_id from GET request
if (isset($_GET['transaction_id'])) {
    $transaction_id = $conn->real_escape_string($_GET['transaction_id']);

    // Query to fetch loan details
    $query = "SELECT 
                loan_amount, 
                CONCAT(payment_frequency, ' for ', days_to_next_deadline, ' months') AS terms, 
                created_at AS date_released,
                created_at AS date_applied,
                status
              FROM borrower_info
              WHERE transaction_id = '$transaction_id'";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "No data found for transaction ID."]);
    }
} else {
    echo json_encode(["error" => "Transaction ID not provided."]);
}

$conn->close();
?>
