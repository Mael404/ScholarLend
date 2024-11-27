<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

session_start();
$conn = new mysqli("localhost", "root", "", "scholarlend_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if email is in the database
    $query = "SELECT * FROM users_tb WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the user exists, check if the password and confirm password match
        if ($password === $confirm_password) {
            // Save both password and confirm_password in session for later use
            $_SESSION['password'] = $password;
            $_SESSION['confirm_password'] = $confirm_password;

            // Generate OTP and save it in the session (you can skip this step if it's already handled elsewhere)
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            // Update OTP in the database
            $update_otp_query = "UPDATE users_tb SET otp = ?, otp_expiry = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = ?";
            $stmt = $conn->prepare($update_otp_query);
            $stmt->bind_param("is", $otp, $email);

            if ($stmt->execute()) {
                // Send OTP to user's email
                $subject = "Your OTP for Password Reset";
                $message = "<p>Your OTP is <strong>$otp</strong>. Please use it within the next 10 minutes.</p>";

                // Call a function to send the email (assumes you have a send_mail function like in previous examples)
                if (send_mail($email, $subject, $message)) {
                    header("Location: forgot_password_otp.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Failed to send OTP. Please try again.";
                    header("Location: forgot_password.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Failed to update OTP in the database. Please try again.";
                header("Location: forgot_password.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Passwords do not match.";
            header("Location: forgot_password.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Email address not registered.";
        header("Location: forgot_password.php");
        exit();
    }
}

$conn->close();

function send_mail($recipient, $subject, $message) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "maelaquino141@gmail.com";
    $mail->Password = "aytbbzlqaordegbl";

    $mail->IsHTML(true);
    $mail->AddAddress($recipient, "Esteemed Customer");
    $mail->SetFrom("ScholarLend@gmail.com", "ScholarLend");
    $mail->Subject = $subject;
    $mail->MsgHTML($message);

    return $mail->Send();
}
?>
