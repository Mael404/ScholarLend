<?php
// Start the session
session_start();
include 'condb.php';

$transaction_id = $_GET['transaction_id']; // Assuming transaction_id is passed via GET request

// Fetch the required data from the database
$query = "SELECT fname, lname, course, career_goals, yearofstudy, gwa, school_community, spending_pattern, 
          loan_purpose, loan_amount, monthly_allowance, source_of_allowance, monthly_expenses 
          FROM borrower_info WHERE transaction_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $transaction_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Initialize variables
$credit_score = 0;
$yearsofstudy_score = 0;
$gwa_score = 0;
$school_community_score = 0;
$spending_pattern_score = 0;
$loan_purpose_score = 0;
$loan_amount_score = 0;
$monthly_allowance_score = 0;
$source_of_allowance_score = 0;
$expense_score = 0;

// Year of Study score
switch ($row['yearofstudy']) {
    case '4th year': $yearsofstudy_score = 7; break;
    case '3rd year': $yearsofstudy_score = 6; break;
    case '2nd year': $yearsofstudy_score = 5; break;
    case '1st year': $yearsofstudy_score = 4; break;
}
$credit_score += $yearsofstudy_score;

// GWA score
$gwa = (float)$row['gwa'];
if ($gwa >= 1.0 && $gwa <= 1.4) {
    $gwa_score = 8;
} elseif ($gwa >= 1.5 && $gwa <= 1.7) {
    $gwa_score = 7;
} elseif ($gwa >= 1.8 && $gwa <= 2.5) {
    $gwa_score = 6;
} elseif ($gwa >= 2.6 && $gwa <= 2.8) {
    $gwa_score = 5;
} elseif ($gwa >= 2.9 && $gwa <= 3.0) {
    $gwa_score = 4;
} elseif ($gwa >= 3.1 && $gwa <= 4.0) {
    $gwa_score = 3;
} else {
    $gwa_score = 2;
}
$credit_score += $gwa_score;

// School Community score
$school_community_score = (strtolower($row['school_community']) === 'no') ? 4 : 5;
$credit_score += $school_community_score;

// Spending Pattern score
$spending_pattern_score = (strtolower($row['spending_pattern']) === 'regular expenses') ? 10 : 8;
$credit_score += $spending_pattern_score;

// Loan Purpose score
$loan_purpose = strtolower($row['loan_purpose']);
if ($loan_purpose === 'educational' || $loan_purpose === 'personal') {
    $loan_purpose_score = 10;
} elseif ($loan_purpose === 'general') {
    $loan_purpose_score = 8;
}
$credit_score += $loan_purpose_score;

// Monthly Expenses score
switch ($row['monthly_expenses']) {
    case 'Below 1,000': $expense_score = 20; break;
    case '1,001 - 3,000': $expense_score = 19; break;
    case '3,001 - 5,000': $expense_score = 18; break;
    case '5,001 - 7,000': $expense_score = 17; break;
    case '7,001 - 9,000': $expense_score = 16; break;
    case '9,001 - 11,000': $expense_score = 15; break;
    case 'Above 11,000': $expense_score = 14; break;
}
$credit_score += $expense_score;

// Loan Amount score
$loan_amount = (int)$row['loan_amount'];
if ($loan_amount == 500 || $loan_amount == 1000) {
    $loan_amount_score = 10;
} elseif ($loan_amount == 2000) {
    $loan_amount_score = 9;
} elseif ($loan_amount == 3000) {
    $loan_amount_score = 8;
} elseif ($loan_amount == 4000) {
    $loan_amount_score = 7;
} else {
    $loan_amount_score = 6;
}
$credit_score += $loan_amount_score;

// Monthly Allowance score
switch ($row['monthly_allowance']) {
    case 'Above 11,000': $monthly_allowance_score = 20; break;
    case '9,001 - 11,000': $monthly_allowance_score = 19; break;
    case '7,001 - 9,000': $monthly_allowance_score = 18; break;
    case '5,001 - 7,000': $monthly_allowance_score = 17; break;
    case '3,001 - 5,000': $monthly_allowance_score = 16; break;
    case '1,001 - 3,000': $monthly_allowance_score = 15; break;
    case 'Below 1,000': $monthly_allowance_score = 14; break;
}
$credit_score += $monthly_allowance_score;

// Source of Allowance score
$source_of_allowance = strtolower($row['source_of_allowance']);
if ($source_of_allowance === 'own business' || $source_of_allowance === 'parental support') {
    $source_of_allowance_score = 10;
} elseif ($source_of_allowance === 'scholarships') {
    $source_of_allowance_score = 9;
} elseif ($source_of_allowance === 'part-time job') {
    $source_of_allowance_score = 8;
}
$credit_score += $source_of_allowance_score;

// Determine credit score category
if ($credit_score >= 90) {
    $credit_category = 'Excellent';
} elseif ($credit_score >= 80) {
    $credit_category = 'Very Good';
} elseif ($credit_score >= 70) {
    $credit_category = 'Good';
} elseif ($credit_score >= 51) {
    $credit_category = 'Fair';
} else {
    $credit_category = 'Poor';
}

// Prepare the response
$response = [
    'credit_score' => $credit_score,
    'credit_category' => $credit_category,
    'yearsofstudy_score' => $yearsofstudy_score,
    'gwa_score' => $gwa_score,
    'school_community_score' => $school_community_score,
    'spending_pattern_score' => $spending_pattern_score,
    'loan_purpose_score' => $loan_purpose_score,
    'loan_amount_score' => $loan_amount_score,
    'monthly_allowance_score' => $monthly_allowance_score,
    'source_of_allowance_score' => $source_of_allowance_score,
    'expense_score' => $expense_score
];

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
