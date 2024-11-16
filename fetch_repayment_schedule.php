<?php
// Start session and include the database connection
session_start();
include 'condb.php';

header('Content-Type: application/json'); // Set the response type to JSON

$response = [
    'total_amount' => null,
    'next_deadlines' => null,
    'error' => null,
];

if (isset($_GET['transaction_id'])) {
    $transaction_id = intval($_GET['transaction_id']);

    // Query to fetch next_deadlines and total_amount
    $query = "SELECT next_deadlines, total_amount FROM borrower_info WHERE transaction_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $transaction_id);
    $stmt->execute();
    $stmt->bind_result($next_deadlines, $total_amount);
    $stmt->fetch();

    // Populate the response
    $response['next_deadlines'] = $next_deadlines ? htmlspecialchars($next_deadlines) : null;
    $response['total_amount'] = $total_amount ? number_format($total_amount, 2) : "0.00";

    $stmt->close();
} else {
    $response['error'] = "Transaction ID is missing.";
}

$conn->close();
echo json_encode($response);
?>
