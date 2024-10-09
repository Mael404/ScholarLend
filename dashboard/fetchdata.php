
<?php

header('Content-Type: application/json'); // Ensure response is JSON
echo json_encode($data); // Output the fetched data as JSON
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

// Query to fetch all required data
$sql = "SELECT fname, mname, lname, birthdate, gender, cellphonenumber, email, school, college, course, yearofstudy, graduationdate, monthly_allowance, source_of_allowance, monthly_expenses, school_community, spending_pattern, monthly_savings, career_goals, loan_amount, loan_purpose, loan_description, payment_mode, payment_frequency, due_date, account_details, total_amount, cor1_path, cor2_path, cor3_path, cor4_path, created_at, user_id FROM borrower_info";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>
