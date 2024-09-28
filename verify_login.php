<?php
// Start session to store user data
session_start();

// Database connection
$servername = "localhost"; // Replace with your server details
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "scholarlend_db"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $email = $conn->real_escape_string($email);

    // Query to check if user exists
    $sql = "SELECT * FROM users_tb WHERE email = '$email' AND is_verified = 1 LIMIT 1";
    $result = $conn->query($sql);

    // If user found
    if ($result->num_rows == 1) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify the password using password_verify()
        if (password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['account_role'] = $user['account_role'];

            // Redirect based on role
            if ($user['account_role'] == 'lender') {
                header("Location: lenderdashboard.html");
            } elseif ($user['account_role'] == 'borrower') {
                header("Location: borrowerdashboard.html");
            } else {
                header("Location: dashboard.html"); // Default dashboard
            }
            exit();
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }
}

$conn->close();
?>
