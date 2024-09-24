<?php
// Start the session to access session variables
session_start(); // Start the session

// Database connection
$conn = new mysqli("localhost", "root", "", "scholarlend_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$email = null;
$otp_entered = '';

// Get form data
if (isset($_POST['email']) && isset($_POST['otp_digit_1']) && isset($_POST['otp_digit_2']) && 
    isset($_POST['otp_digit_3']) && isset($_POST['otp_digit_4']) && isset($_POST['otp_digit_5']) && 
    isset($_POST['otp_digit_6'])) {
    
    $email = $_POST['email'];
    $otp_entered = $_POST['otp_digit_1'] . $_POST['otp_digit_2'] . $_POST['otp_digit_3'] . 
                   $_POST['otp_digit_4'] . $_POST['otp_digit_5'] . $_POST['otp_digit_6'];

    // Check if the email exists and fetch OTP data
    $sql = $conn->prepare("SELECT otp, otp_expiry FROM users_tb WHERE email = ?");
    if ($sql) {
        $sql->bind_param("s", $email);
        if ($sql->execute()) {
            $result = $sql->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $stored_otp = $row['otp'];
                $otp_expiry = $row['otp_expiry'];
                $current_time = date('Y-m-d H:i:s');

                // Check if the OTP matches
                if (trim($otp_entered) === trim($stored_otp)) {
                    // OTP is correct, proceed with registration
                    echo "OTP verified successfully!";
                    
                    // Optionally, clear the session variables after successful verification
                    unset($_SESSION['otp']);
                    unset($_SESSION['email']);
                    
                    // Update user status to 'verified'
                    $update_status = $conn->prepare("UPDATE users_tb SET is_verified = 1 WHERE email = ?");
                    if ($update_status) {
                        $update_status->bind_param("s", $email);
                        $update_status->execute();
                        $update_status->close();
                        
                        // Redirect to success.php
                        header("Location: success.php");
                        exit(); // Ensure script stops after redirection
                    } else {
                        echo "Failed to prepare update statement.";
                    }
                } else {
                    if ($current_time > $otp_expiry) {
                        echo "OTP expired. Please request a new OTP.";
                    } else {
                        echo "Invalid OTP. Please try again.";
                    }
                }
            } else {
                echo "Invalid email or OTP.";
            }
        } else {
            echo "SQL execution failed: " . $sql->error;
        }
    } else {
        echo "Failed to prepare SQL statement.";
    }
} else {
    echo "Email and OTP must be provided.";
}

// Close SQL and connection
if (isset($sql)) {
    $sql->close();
}
$conn->close();
?>
