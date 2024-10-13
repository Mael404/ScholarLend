<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get borrower ID and new status from POST request
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'scholarlend_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update query to change status to Approved
    $sql = "UPDATE borrower_info SET status = ? WHERE id = ?";

    // Prepare and bind parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('si', $status, $id); // 'si' means string, integer
        $stmt->execute();

        // Check if update was successful
        if ($stmt->affected_rows > 0) {
            echo "Status updated successfully";
        } else {
            echo "Error updating status or no changes made";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
