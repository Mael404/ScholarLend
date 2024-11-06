<?php
session_start(); 

$host = 'localhost'; 
$db = 'scholarlend_db'; 
$user = 'root'; 
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


do {
    $transaction_id = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $checkQuery = "SELECT transaction_id FROM borrower_info WHERE transaction_id = '$transaction_id'";
    $result = $conn->query($checkQuery);
} while ($result->num_rows > 0); 


$fname = $conn->real_escape_string($_POST['fname']);
$mname = $conn->real_escape_string($_POST['mname']);
$lname = $conn->real_escape_string($_POST['lname']);
$birthdate = $conn->real_escape_string($_POST['birthdate']);
$gender = $conn->real_escape_string($_POST['gender']);
$cellphonenumber = $conn->real_escape_string($_POST['cellphonenumber']);
$email = $conn->real_escape_string($_POST['email']);
$school = $conn->real_escape_string($_POST['school']);
$college = $conn->real_escape_string($_POST['college']);
$course = $conn->real_escape_string($_POST['course']);
$yearofstudy = $conn->real_escape_string($_POST['yearofstudy']);
$graduationdate = $conn->real_escape_string($_POST['graduationdate']);
$monthly_allowance = $conn->real_escape_string($_POST['monthly-allowance']);
$source_of_allowance = $conn->real_escape_string($_POST['source-of-allowance']);
$monthly_expenses = $conn->real_escape_string($_POST['monthly-expenses']);
$school_community = $conn->real_escape_string($_POST['school_community']);
$spending_pattern = $conn->real_escape_string($_POST['spending-pattern']);
$monthly_savings = $conn->real_escape_string($_POST['monthly-savings']);
$career_goals = $conn->real_escape_string($_POST['career-goals']);
$loan_amount = (float) $conn->real_escape_string($_POST['loan_amount']);
$loan_purpose = $conn->real_escape_string($_POST['loan_purpose']);
$loan_description = $conn->real_escape_string($_POST['loan_description']);
$payment_mode = $conn->real_escape_string($_POST['payment_mode']);
$payment_frequency = $conn->real_escape_string($_POST['frequency']);
$due_date = $conn->real_escape_string($_POST['due_date']);
$account_details = $conn->real_escape_string($_POST['account_details']);
$total_amount = (float) $conn->real_escape_string($_POST['total_amount']);
$next_deadlines = $conn->real_escape_string($_POST['next_deadlines']);
$current_address = $conn->real_escape_string($_POST['current_address']);
$permanent_address = $conn->real_escape_string($_POST['permanent_address']);
$gwa = $conn->real_escape_string($_POST['gwa']);
$statuss = "Pending";

if (!empty($next_deadlines)) {
    $deadlinesArray = explode(', ', $next_deadlines);
    $days_to_next_deadline = count($deadlinesArray);
} else {
    $days_to_next_deadline = 0;
}


$interest_earned = ($total_amount * $days_to_next_deadline) - $loan_amount;

if ($days_to_next_deadline > 0) {
    $admin_share_base = ($total_amount * $days_to_next_deadline) - $loan_amount;
    $share_admin = ($admin_share_base * 0.3) / $days_to_next_deadline; 
} else {
    $share_admin = 0; 
}


$share_admin = floor($share_admin * 100) / 100; 


$share_admin_formatted = number_format($share_admin, 2, '.', ''); 

//pag handle files. pag may error wag mag proceed
$uploadDir = "uploads/";
$files = ['cor1', 'cor2', 'cor3', 'cor4'];
$uploadedFiles = [];
$errorOccurred = false;

foreach ($files as $fileInput) {
    if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] == 0) {
        $fileTmpPath = $_FILES[$fileInput]['tmp_name'];
        $fileName = basename($_FILES[$fileInput]['name']);
        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $uploadedFiles[$fileInput] = $destPath;
        } else {
            echo json_encode(['status' => 'error', 'message' => "Error uploading $fileInput."]);
            $errorOccurred = true;
            break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => "Error with $fileInput upload."]);
        $errorOccurred = true;
        break;
    }
}

$outstanding_balance = $loan_amount + ($interest_earned - floatval($share_admin*$days_to_next_deadline));


if (!$errorOccurred) {
    $file1 = isset($uploadedFiles['cor1']) ? $conn->real_escape_string($uploadedFiles['cor1']) : null;
    $file2 = isset($uploadedFiles['cor2']) ? $conn->real_escape_string($uploadedFiles['cor2']) : null;
    $file3 = isset($uploadedFiles['cor3']) ? $conn->real_escape_string($uploadedFiles['cor3']) : null;
    $file4 = isset($uploadedFiles['cor4']) ? $conn->real_escape_string($uploadedFiles['cor4']) : null;

    $sql = "INSERT INTO borrower_info (
        transaction_id, user_id, fname, mname, lname, birthdate, gender, cellphonenumber, email, school, 
        college, course, yearofstudy, graduationdate, monthly_allowance, source_of_allowance, 
        monthly_expenses, school_community, spending_pattern, monthly_savings, career_goals, 
        loan_amount, loan_purpose, loan_description, payment_mode, payment_frequency, due_date, 
        next_deadlines, days_to_next_deadline, account_details, total_amount, interest_earned, 
        share_admin, status, cor1_path, cor2_path, cor3_path, cor4_path, current_address, 
        permanent_address, outstanding_balance, gwa
    ) VALUES (
        '$transaction_id', '$user_id', '$fname', '$mname', '$lname', '$birthdate', '$gender', 
        '$cellphonenumber', '$email', '$school', '$college', '$course', '$yearofstudy', 
        '$graduationdate', '$monthly_allowance', '$source_of_allowance', '$monthly_expenses', 
        '$school_community', '$spending_pattern', '$monthly_savings', '$career_goals', 
        '$loan_amount', '$loan_purpose', '$loan_description', '$payment_mode', 
        '$payment_frequency', '$due_date', '$next_deadlines', '$days_to_next_deadline', 
        '$account_details', '$total_amount', '$interest_earned', '$share_admin', '$statuss', 
        '$file1', '$file2', '$file3', '$file4', '$current_address', '$permanent_address', 
        '$outstanding_balance', '$gwa'
    )";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully with Transaction ID: $transaction_id";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
