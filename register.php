<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Start the session
session_start(); // Start the session at the beginning

// Database connection
$conn = new mysqli("localhost", "root", "", "scholarlend_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$accountRole = 'Borrower';
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$birthdate = $_POST['birthdate'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Check if the email is already registered
$email_check_sql = "SELECT * FROM users_tb WHERE email = '$email' AND is_verified = 1";
$email_check_result = $conn->query($email_check_sql);

if ($email_check_result->num_rows > 0) {
    // If an entry is found with the specified email and it's verified
    header("Location: email_failed.php"); // Redirect if the email is already verified
    exit(); // Ensure no further code is executed after the redirect
} else {
    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP valid for 10 minutes

    // Insert user data along with OTP into the database, including accountRole
    $sql = "INSERT INTO users_tb (first_name, middle_name, last_name, birthdate, phone_number, email, password, otp, otp_expiry, account_role) 
            VALUES ('$firstName', '$middleName', '$lastName', '$birthdate', '$phoneNumber', '$email', '$password', '$otp', '$otp_expiry', '$accountRole')";

    if ($conn->query($sql) === TRUE) {
        // After inserting, store OTP and email in the session
        $_SESSION['otp'] = $otp; // Store OTP in session
        $_SESSION['email'] = $email; // Store email in session

        // Send OTP via email using PHPMailer
        $subject = "Your OTP for Account Registration";

        $message = "
        <html>
        <head>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #0056b3;
                    font-size: 24px;
                }
                .otp {
                    font-size: 20px;
                    font-weight: bold;
                    color: #007bff;
                    padding: 10px;
                    border: 2px solid #e7f0ff;
                    display: inline-block;
                    margin-top: 20px;
                    border-radius: 5px;
                    background-color: #ffffff;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <h1>Welcome to the ScholarLend!</h1>
            <p>Your One-Time Password (OTP) for secure registration is ready:</p>
            <div class='otp'>Your OTP is: <strong>$otp</strong></div>
            <p>Please enter this OTP to complete your registration process. If you did not request this, please contact your IT support.</p>
            <div class='footer'>Thank you for being a valuable part of our team!</div>
        </body>
        </html>
        ";
        
        

        // After sending the OTP successfully
        if (send_mail($email, $subject, $message)) {
            // Redirect to user_otp.php without the OTP in the URL
            header("Location: user_otp.php");
            exit(); // Ensure no further code is executed
        } else {
            // Redirect anyway even if email fails
            header("Location: user_otp.php");
            exit(); // Ensure no further code is executed
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

// Function to send email using PHPMailer
function send_mail($recipient, $subject, $message)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "maelaquino141@gmail.com";  // Your Gmail username
    $mail->Password   = "aytbbzlqaordegbl";          // Your Gmail app-specific password

    $mail->IsHTML(true);
    $mail->AddAddress($recipient, "Esteemed Customer");
    $mail->SetFrom("ScholarLend@gmail.com", "ScholarLend");
    $mail->Subject = $subject;
    $mail->MsgHTML($message);  // The message content

    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}
?>
