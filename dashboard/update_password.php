<?php
// Start the session
session_start();

// Include database connection (adjust the file path as necessary)
include 'condb.php';

// Check if the user is logged in (assuming user is identified by their session)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Get the input data from the POST request
$currentPassword = isset($_POST['currentPassword']) ? $_POST['currentPassword'] : '';
$newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

// Check if any field is empty
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

// Validate the current password
$userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session

// Prepare and execute the query to fetch the user's current password from the database
$sql = "SELECT password FROM users_tb WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($storedPassword);
$stmt->fetch();

// Check if the current password matches
if (!password_verify($currentPassword, $storedPassword)) {
    echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
    exit();
}

// Validate the new password (you can add more checks like length, complexity, etc.)
if (strlen($newPassword) < 6) {
    echo json_encode(['success' => false, 'message' => 'New password must be at least 6 characters long.']);
    exit();
}

// Check if new password and confirm password match
if ($newPassword !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'New password and confirm password do not match.']);
    exit();
}

// Hash the new password
$hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update the password in the database
$updateSql = "UPDATE users_tb SET password = ? WHERE user_id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("si", $hashedNewPassword, $userId);

if ($updateStmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update password. Please try again later.']);
}
?>
