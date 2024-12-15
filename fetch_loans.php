<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "scholarlend_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input data
$data = json_decode(file_get_contents('php://input'), true);
$period = $data['period'] ?? '';
$paymentMode = $data['paymentMode'] ?? '';
$creditScore = $data['creditScore'] ?? '';
$applicationTime = $data['applicationTime'] ?? '';

$filters = [];
if ($period !== '') {
    $filters[] = "next_deadlines <= $period";
}
if ($paymentMode !== '') {
    $filters[] = "payment_mode = '$paymentMode'";
}
if ($creditScore !== '') {
    $filters[] = "credit_score = '$creditScore'";
}
if ($applicationTime === 'week') {
    $filters[] = "created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
} elseif ($applicationTime === 'month') {
    $filters[] = "created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
} elseif ($applicationTime === '3months') {
    $filters[] = "created_at >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
}

$whereClause = $filters ? 'WHERE ' . implode(' AND ', $filters) : '';

// Query filtered results
$sql = "SELECT transaction_id, fname, loan_amount, loan_description, course 
        FROM borrower_info 
        $whereClause";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-12 col-md-4 mb-4">';
        echo '<div class="card h-100">';
        echo '<div class="card-body">';
        echo '<p>Transaction ID: ' . htmlspecialchars($row['transaction_id']) . '</p>';
        echo '<p>Php ' . number_format($row['loan_amount'], 2) . ' requested by ' . htmlspecialchars($row['fname']) . '</p>';
        echo '<p>Loan Description: ' . htmlspecialchars($row['loan_description']) . '</p>';
        echo '<p>Course: ' . htmlspecialchars($row['course']) . '</p>';
        echo '</div></div></div>';
    }
} else {
    echo '<div class="alert alert-warning">No loans found matching your criteria.</div>';
}

$conn->close();
?>
