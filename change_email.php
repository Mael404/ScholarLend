<?php
// Start the session
session_start();

// Include database connection
include 'condb.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Get the input data from the POST request
$newEmail = isset($_POST['new_email']) ? $_POST['new_email'] : '';

// Validate the new email
if (empty($newEmail)) {
    echo json_encode(['success' => false, 'message' => 'Email address is required.']);
    exit();
}

// Validate email format
if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Prepare and execute the query to update the user's email
$sql = "UPDATE users_tb SET email = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newEmail, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Email updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update email. Please try again later.']);
}
?>
