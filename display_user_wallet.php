<?php


// Database connection details
$servername = "localhost"; // Change this if your DB server is different
$username = "root"; // DB username
$password = ""; // DB password
$dbname = "scholarlend_db"; // Database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have the user ID stored in the session after login
$user_id = $_SESSION['user_id'];

// Query to fetch wallet balance
$sql = "SELECT wallet_balance FROM users_tb WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch wallet balance from the query result
$wallet_balance = 0; // Default value
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $wallet_balance = $row['wallet_balance'];
}

$stmt->close();
$conn->close();
?>
