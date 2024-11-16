<?php
// Start the session to access the logged-in user's information
session_start();

// Database connection
$servername = "localhost"; // Replace with your server details
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "scholarlend_db"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and if form is submitted
if (isset($_SESSION['user_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user_id of the currently logged-in user
    $borrower_id = $_SESSION['user_id'];
    
    // Get form data
    $subject = $_POST['subject']; // Subject selected from dropdown
    $message = $_POST['message']; // Message entered in textarea

    // Prepare SQL statement to insert data into messages table
    $stmt = $conn->prepare("INSERT INTO contactus (borrower_id, subject, message, created_at, status) VALUES (?, ?, ?, NOW(), 'unread')");
    $stmt->bind_param("iss", $borrower_id, $subject, $message);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        header("Location: lender_messagesuccess.php");
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
} else {
    echo "Please log in to send a message.";
}

$conn->close();
?>
