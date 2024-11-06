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

// Get the raw POST data from the request
if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];
    
    // Query the borrower_info table for the lender_id based on transaction_id
    $sql = "SELECT lender_id FROM borrower_info WHERE transaction_id = ?";
    
    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $transaction_id); // Bind the transaction_id to the query
        $stmt->execute();
        $stmt->bind_result($lender_id); // Bind result to $lender_id
        
        // Fetch the result
        if ($stmt->fetch()) {
            echo json_encode(['lender_id' => $lender_id]); // Return the lender_id as JSON
        } else {
            echo json_encode(['error' => 'Transaction ID not found']); // Handle case where transaction_id is not found
        }
        
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the query']); // Handle query preparation failure
    }
} else {
    echo json_encode(['error' => 'Transaction ID is missing']); // Handle missing transaction_id
}

$conn->close();
?>
