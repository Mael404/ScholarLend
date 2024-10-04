<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scholarlend_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fname = $_POST['fname'] ?? null;
    $mname = $_POST['mname'] ?? null;
    $lname = $_POST['lname'] ?? null;
    $birthdate = $_POST['birthdate'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $cellphonenumber = $_POST['cellphonenumber'] ?? null;
    $email = $_POST['email'] ?? null;
    $school = $_POST['school'] ?? null;
    $college = $_POST['college'] ?? null;
    $course = $_POST['course'] ?? null;
    $yearofstudy = $_POST['yearofstudy'] ?? null;
    $graduationdate = $_POST['graduationdate'] ?? null;
    $monthly_allowance = $_POST['monthly-allowance'] ?? null;

    $source_of_allowance = $_POST['source-of-allowance'] ?? null;
    $monthly_expenses = $_POST['monthly_expenses'] ?? null;
    $payment_mode = $_POST['payment_mode'] ?? null;
    $due_date = $_POST['due_date'] ?? null;
    $account_details = $_POST['account_details'] ?? null;
    $school_community = $_POST['school_community'] ?? null;
    $spending_pattern = $_POST['spending-pattern'] ?? null;
    $monthly_savings = $_POST['monthly-savings'] ?? null;
    $career_goals = $_POST['career-goals'] ?? null;

    // Loan Information Fields
    $loan_amount = $_POST['loan_amount'] ?? null;
    $loan_purpose = $_POST['loan_purpose'] ?? null;
    $loan_description = $_POST['loan_description'] ?? null;

    // File Upload Handling
    $uploadDir = "uploads/";
    $files = ['cor1', 'cor2', 'cor3', 'cor4'];
    $uploadedFiles = [];

    foreach ($files as $fileInput) {
        if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] == 0) {
            $fileTmpPath = $_FILES[$fileInput]['tmp_name'];
            $fileName = basename($_FILES[$fileInput]['name']);
            $destPath = $uploadDir . $fileName;

            // Move the uploaded file to the destination directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $uploadedFiles[$fileInput] = $destPath;
            } else {
                echo "Error uploading $fileInput.";
                exit();
            }
        } else {
            echo "Error with $fileInput upload.";
            exit();
        }
    }

    // Prepare and bind SQL
    $stmt = $conn->prepare("
    INSERT INTO borrower_information (
        fname, mname, lname, birthdate, gender, cellphonenumber, email, 
        school, college, course, yearofstudy, graduationdate, 
        monthly_allowance, source_of_allowance, monthly_expenses, payment_mode, 
        due_date, account_details, school_community, spending_pattern, 
        monthly_savings, career_goals, loan_amount, loan_purpose, loan_description, 
        cor1, cor2, cor3, cor4
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $bindParams = [
        $fname, $mname, $lname, $birthdate, $gender, $cellphonenumber, $email, 
        $school, $college, $course, $yearofstudy, $graduationdate, 
        $monthly_allowance, $source_of_allowance, $monthly_expenses, $payment_mode, 
        $due_date, $account_details, $school_community, $spending_pattern, 
        $monthly_savings, $career_goals, $loan_amount, $loan_purpose, $loan_description, 
        $uploadedFiles['cor1'] ?? null, 
        $uploadedFiles['cor2'] ?? null, 
        $uploadedFiles['cor3'] ?? null, 
        $uploadedFiles['cor4'] ?? null
    ];

    // Adjust bind_param format based on the number of uploaded files
    $typeString = str_repeat('s', count($bindParams));
    if (!$stmt->bind_param($typeString, ...$bindParams)) {
        die("Bind failed: " . $stmt->error);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
