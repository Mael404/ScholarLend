<?php
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

                // Debugging output (comment out in production)
                // echo "Stored OTP: $stored_otp<br>";
                // echo "OTP Expiry: $otp_expiry<br>";
                // echo "Current Time: $current_time<br>";
                // echo "Email: $email<br>";
                // echo "Entered OTP: $otp_entered<br>";

                // Check if OTP matches and is not expired
                if (trim($otp_entered) === trim($stored_otp) && $current_time <= $otp_expiry) {
                    echo "OTP verified successfully. You are now registered.";
                    // Update user status to 'verified'
                    $update_status = $conn->prepare("UPDATE users_tb SET is_verified = 1 WHERE email = ?");
                    if ($update_status) {
                        $update_status->bind_param("s", $email);
                        $update_status->execute();
                        $update_status->close();
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
