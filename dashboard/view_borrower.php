<?php
// Include database connection
$host = 'localhost'; // Your database host
$db = 'scholarlend_db'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the request
$user_id = $_GET['id'];

// Query to get the detailed information of the selected user, including the file paths
$query = "SELECT `fname`, `mname`, `lname`, `birthdate`, `gender`, `cellphonenumber`, `email`, `school`, 
          `college`, `course`, `yearofstudy`, `graduationdate`, `monthly_allowance`, `source_of_allowance`, 
          `monthly_expenses`, `school_community`, `spending_pattern`, `monthly_savings`, `career_goals`, 
          `loan_amount`, `loan_purpose`, `loan_description`, `payment_mode`, `payment_frequency`, `due_date`, 
          `account_details`, `total_amount`, `cor1_path`, `cor2_path`, `cor3_path`, `cor4_path`
          FROM borrower_info WHERE user_id = $user_id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Fetch the borrower details
    $row = $result->fetch_assoc();
    echo json_encode($row); // Return the row as a JSON object
} else {
    echo json_encode(['error' => 'No borrower found with the given ID.']);
}

$conn->close();
?>
