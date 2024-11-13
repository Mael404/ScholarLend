<?php
require 'condb.php'; // Include database connection

if (isset($_POST['inquiry_id'])) {
    $inquiry_id = $_POST['inquiry_id'];

    // Prepare and execute the update query to set status to 'read' for the specific inquiry_id
    $sql = "UPDATE contactus SET status = 'read' WHERE inquiry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inquiry_id);
    
    echo ($stmt->execute()) ? "success" : "error";
    
    $stmt->close();
}
$conn->close();
?>
