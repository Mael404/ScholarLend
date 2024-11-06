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

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);
$transaction_id = $data['transaction_id'] ?? null;

if ($transaction_id) {
    // Prepare and execute query to find lender_id for the given transaction_id
    $stmt = $conn->prepare("SELECT lender_id FROM borrower_info WHERE transaction_id = ?");
    $stmt->bind_param("s", $transaction_id); // "s" is for string
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the transaction_id exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return lender_id as a JSON response
        echo json_encode(["success" => true, "lender_id" => $row['lender_id']]);
    } else {
        // If no results found, return an error message
        echo json_encode(["success" => false, "message" => "Transaction ID not found"]);
    }

    $stmt->close();
} else {
    // If no transaction_id is provided
    echo json_encode(["success" => false, "message" => "Invalid transaction ID"]);
}

$conn->close();
?>
