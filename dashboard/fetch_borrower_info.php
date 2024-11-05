<?php
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "scholarlend_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT yearsofstudy, gwa, school_community, spending_pattern, monthly_savings, loan_purpose, loan_amount, month_allowance, source_of_allowance FROM borrower_info WHERE transaction_id = ?");
    $stmt->bind_param("s", $transaction_id);

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Fetch the data
        $stmt->bind_result($yearsofstudy, $gwa, $school_community, $spending_pattern, $monthly_savings, $loan_purpose, $loan_amount, $month_allowance, $source_of_allowance);
        $stmt->fetch();

        // Return the data as JSON
        echo json_encode([
            'yearsofstudy' => $yearsofstudy,
            'gwa' => $gwa,
            'school_community' => $school_community,
            'spending_pattern' => $spending_pattern,
            'monthly_savings' => $monthly_savings,
            'loan_purpose' => $loan_purpose,
            'loan_amount' => $loan_amount,
            'month_allowance' => $month_allowance,
            'source_of_allowance' => $source_of_allowance,
        ]);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
}

$conn->close();
?>
