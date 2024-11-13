<?php
// Include database connection
$host = 'localhost'; // Your database host
$db = 'scholarlend_db'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the request
$user_id = $_GET['transaction_id'];

// Query to get the detailed information of the selected user, including the file paths
$query = "SELECT `fname`, `mname`, `lname`, `birthdate`, `gender`, `cellphonenumber`, `email`, `school`, 
          `college`, `course`, `yearofstudy`, `graduationdate`, `monthly_allowance`, `source_of_allowance`, 
          `monthly_expenses`, `school_community`, `spending_pattern`, `career_goals`, 
          `loan_amount`, `loan_purpose`, `loan_description`, `payment_mode`, `payment_frequency`, `due_date`, 
          `account_details`, `total_amount`,`interest_earned`, `next_deadlines`,`days_to_next_deadline`, `cor1_path`, `cor2_path`, `cor3_path`, `cor4_path`, `current_address`, `permanent_address`, `gwa`
          FROM borrower_info WHERE transaction_id = $user_id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Fetch the borrower details
    $row = $result->fetch_assoc();
    
    // Decode the next_deadlines JSON string into an array
    $next_deadlines_array = json_decode($row['next_deadlines'], true);
    
    // Count the number of next deadlines
    $count_deadlines = is_array($next_deadlines_array) ? count($next_deadlines_array) : 0;

    // Add the count to the response
    $row['next_deadlines_count'] = $count_deadlines;

    // Initialize credit score and scores for each category
    $credit_score = 0;
    $yearsofstudy_score = 0;
    $gwa_score = 0;
    $school_community_score = 0;
    $spending_pattern_score = 0;
    $loan_purpose_score = 0;
    $loan_amount_score = 0;
    $monthly_allowance_score = 0;
    $source_of_allowance_score = 0;

    // Calculate the credit score based on year of study
    $yearsofstudy = $row['yearofstudy'];
    switch ($yearsofstudy) {
        case '4th year': $yearsofstudy_score = 7; break;
        case '3rd year': $yearsofstudy_score = 6; break;
        case '2nd year': $yearsofstudy_score = 5; break;
        case '1st year': $yearsofstudy_score = 4; break;
    }
    $credit_score += $yearsofstudy_score;

    // Calculate the score based on gwa
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

    // Calculate the score based on school community
    $school_community = strtolower($row['school_community']);
    $school_community_score = ($school_community === 'no') ? 4 : 5;
    $credit_score += $school_community_score;

    // Calculate the score based on spending pattern
    $spending_pattern = strtolower($row['spending_pattern']);
    $spending_pattern_score = ($spending_pattern === 'regular expenses') ? 10 : 8;
    $credit_score += $spending_pattern_score;

    

    // Calculate the score based on loan purpose
    $loan_purpose = strtolower($row['loan_purpose']);
    if ($loan_purpose === 'directly attributable to studying' || $loan_purpose === 'overhead to studying') {
        $loan_purpose_score = 10;
    } elseif ($loan_purpose === 'general') {
        $loan_purpose_score = 8;
    } else {
        $loan_purpose_score = 0; // Default in case of an unexpected value
    }
    $credit_score += $loan_purpose_score;
    



    $monthly_expenses = strtolower($row['monthly_expenses']); // Example value, replace with actual value from the database

    // Breakdown of the expenses based on text values
    if ($monthly_expenses === 'Below 1,000') {
        $expense_score = 20;
    } elseif ($monthly_expenses === '1,001 - 3,000') {
        $expense_score = 19;
    } elseif ($monthly_expenses === '3,001 - 5,000') {
        $expense_score = 18;
    } elseif ($monthly_expenses === '5,001 - 7,000') {
        $expense_score = 17;
    } elseif ($monthly_expenses === '7,001 - 9,000') {
        $expense_score = 16;
    } elseif ($monthly_expenses === '9,001 - 11,000') {
        $expense_score = 15;
    } elseif ($monthly_expenses === 'above 11,000') {
        $expense_score = 14;
    } else {
        $expense_score = 0; // Default in case of an unexpected value
    }
    
    // Add the score to the credit score
    $credit_score += $expense_score;



    // Calculate the score based on loan amount
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

    $monthly_allowance = $row['monthly_allowance']; // Assuming this retrieves the text value from the dropdown

    if ($monthly_allowance === "above 11,000") {
        $monthly_allowance_score = 20;
    } elseif ($monthly_allowance === "9,001 - 11,000") {
        $monthly_allowance_score = 19;
    } elseif ($monthly_allowance === "7,001 - 9,000") {
        $monthly_allowance_score = 18;
    } elseif ($monthly_allowance === "5,001 - 7,000") {
        $monthly_allowance_score = 17;
    } elseif ($monthly_allowance === "3,001 - 5,000") {
        $monthly_allowance_score = 16;
    } elseif ($monthly_allowance === "1,001 - 3,000") {
        $monthly_allowance_score = 15;
    } elseif ($monthly_allowance === "below 1,000") {
        $monthly_allowance_score = 14;
    } else {
        $monthly_allowance_score = 0; // Default in case of an unexpected value
    }
    
    $credit_score += $monthly_allowance_score;
    

    // Calculate the score based on source of allowance
    $source_of_allowance = strtolower($row['source_of_allowance']); // Convert to lowercase for consistent comparison
    if ($source_of_allowance === 'own business' || $source_of_allowance === 'parental support') {
        $source_of_allowance_score = 10;
    } elseif ($source_of_allowance === 'scholarships') {
        $source_of_allowance_score = 9;
    } elseif ($source_of_allowance === 'part-time job') {
        $source_of_allowance_score = 8;
    } else {
        $source_of_allowance_score = 0; // Default in case of an unexpected value
    }
    $credit_score += $source_of_allowance_score;
    

    // Determine credit score category
    $credit_category = '';
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

    // Add the scores and credit score category to the response
    
    $row['credit_score'] = $credit_score;
    $row['credit_category'] = $credit_category;
    $row['yearsofstudy_score'] = $yearsofstudy_score;
    $row['gwa_score'] = $gwa_score;
    $row['school_community_score'] = $school_community_score;
    $row['spending_pattern_score'] = $spending_pattern_score;
    $row['loan_purpose_score'] = $loan_purpose_score;
    $row['loan_amount_score'] = $loan_amount_score;
    $row['monthly_allowance_score'] = $monthly_allowance_score;
    $row['source_of_allowance_score'] = $source_of_allowance_score;
    $row['expense_score'] = $expense_score;

    echo json_encode($row); // Return the row as a JSON object
    
} else {
    echo json_encode(['error' => 'No borrower found with the given ID.']);
}

$conn->close();
?>
