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

if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];
    
    $sql = "SELECT lender_id FROM borrower_info WHERE transaction_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $transaction_id);
        $stmt->execute();
        $stmt->bind_result($lender_id);
        
        if ($stmt->fetch()) {
            echo json_encode(['lender_id' => $lender_id]);
        } else {
            echo json_encode(['error' => 'Transaction ID not found']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the query']);
    }
} else {
    echo json_encode(['error' => 'Transaction ID is missing']);
}

$conn->close();
exit();
?>
