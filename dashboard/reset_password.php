<?php
session_start();
require_once 'condb.php';  // Include your DB connection file

// Debug: Check if POST data is set and not empty
if (isset($_POST['email']) && isset($_POST['new_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Debug: Output received values
    error_log("Email: $email, New Password: $new_password"); // Log values for debugging
} else {
    echo json_encode(['success' => false, 'message' => 'Missing POST data']);  // If no data is received
    exit();
}

// Validate the email and password
if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit();
}

if (empty($new_password)) {
    echo json_encode(['success' => false, 'message' => 'Please provide a new password.']);
    exit();
}

// Check if the email exists in the database
$query = "SELECT user_id FROM users_tb WHERE email = ? AND is_verified = 1";  // Ensure only verified users can reset
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// If email exists, proceed to reset the password
if ($stmt->num_rows > 0) {
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);  // Hash the new password

    // Update the password in the database
    $update_query = "UPDATE users_tb SET password = ? WHERE email = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ss", $hashed_password, $email);
    
    if ($update_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Your password has been updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'There was an error updating your password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'The email address is not registered or not verified.']);
}

// Close the database connection
$stmt->close();
$conn->close();
?>
