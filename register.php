<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "scholarlend_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate OTP
$otp = rand(100000, 999999);
$otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP valid for 10 minutes

// Get form data
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$birthdate = $_POST['birthdate'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Insert user data along with OTP into the database
$sql = "INSERT INTO users_tb (first_name, middle_name, last_name, birthdate, phone_number, email, password, otp, otp_expiry) 
        VALUES ('$firstName', '$middleName', '$lastName', '$birthdate', '$phoneNumber', '$email', '$password', '$otp', '$otp_expiry')";

if ($conn->query($sql) === TRUE) {
    // Send OTP via email using PHPMailer
    $subject = "Your OTP for Registration";
    $message = "Your OTP is: " . $otp;

   // After sending the OTP successfully
if (send_mail($email, $subject, $message)) {
    // Redirect to user_otp.php with email and OTP in the query string
    header("Location: user_otp.php?email=" . urlencode($email) . "&otp=" . urlencode($otp));
    exit(); // Ensure no further code is executed
}
else {
        echo "Failed to send OTP.";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
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
    $mail->SetFrom("maelaquino141@gmail.com", "ScholarLend");
    $mail->Subject = $subject;
    $mail->MsgHTML($message);  // The message content

    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}
?>
