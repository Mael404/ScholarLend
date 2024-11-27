<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "scholarlend_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$email = $_SESSION['email'];  // Retrieve the email from session
$otp_entered = '';            // Will store the OTP entered by the user

// Check if password and confirm_password are set in session
if (!isset($_SESSION['password']) || !isset($_SESSION['confirm_password'])) {
    die("Password or confirm password has not been set in the session.");
}

$stored_password = $_SESSION['password'];  // Password from session
$confirm_password = $_SESSION['confirm_password'];  // Confirm password from session

// Get form data (OTP digits entered by the user)
if (isset($_POST['otp_digit_1']) && isset($_POST['otp_digit_2']) && 
    isset($_POST['otp_digit_3']) && isset($_POST['otp_digit_4']) && 
    isset($_POST['otp_digit_5']) && isset($_POST['otp_digit_6'])) {
    
    // Combine OTP digits
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
                    // OTP is correct, check if it's expired
                    if ($current_time > $otp_expiry) {
                        echo "OTP expired. Please request a new OTP.";
                    } else {
                        // Proceed to update the password (using the confirm_password value)
                        if ($stored_password === $confirm_password) {
                            // Hash the confirm password before saving it in the database
                            $hashed_password = password_hash($confirm_password, PASSWORD_BCRYPT);

                            // Update the password in the database
                            $update_password = $conn->prepare("UPDATE users_tb SET password = ? WHERE email = ?");
                            if ($update_password) {
                                $update_password->bind_param("ss", $hashed_password, $email);
                                if ($update_password->execute()) {
                                    echo "Password updated successfully!";

                                    // Optionally, clear the session variables after successful password update
                                    unset($_SESSION['otp']);
                                    unset($_SESSION['email']);
                                    unset($_SESSION['password']);  // Clear session password
                                    unset($_SESSION['confirm_password']);  // Clear session confirm_password

                                    // Redirect to success page
                                    header("Location: forgot_password_success.php");
                                    exit(); // Ensure script stops after redirection
                                } else {
                                    echo "Failed to update password. Please try again.";
                                }
                                $update_password->close();
                            } else {
                                echo "Failed to prepare password update statement.";
                            }
                        } else {
                            echo "Passwords do not match. Please check and try again.";
                        }
                    }
                } else {
                    echo "Invalid OTP. Please try again.";
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
    echo "OTP must be provided.";
}

// Close SQL and connection
if (isset($sql)) {
    $sql->close();
}
$conn->close();
?>
