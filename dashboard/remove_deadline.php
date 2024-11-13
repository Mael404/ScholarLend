<?php
session_start();

// Check if the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_POST['user_id'];
$deadline_to_transfer = $_POST['deadline'];
$transaction_id = $_POST['transaction_id'];

// Ensure transaction_id is in the session
if (!isset($_SESSION['transaction_id'])) {
    die("Transaction ID not found in session.");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scholarlend_db";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 1: Fetch the borrower balance
$sql = "SELECT wallet_balance FROM users_tb WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$borrower = $result->fetch_assoc();

if (!$borrower) {
    die("Borrower not found.");
}

$borrower_balance = $borrower['wallet_balance'];

// Fetch loan amount, lender_id, share_admin, and outstanding_balance from borrower_info
$sql = "SELECT lender_id, total_amount, share_admin, outstanding_balance FROM borrower_info WHERE user_id = ? AND transaction_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $transaction_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $lender_id = $row['lender_id']; // Fetch lender_id
    $loan_amount = $row['total_amount'];
    $share_admin = $row['share_admin'];
    $current_outstanding_balance = $row['outstanding_balance'];

    if ($borrower_balance >= $loan_amount) {
        // Start transaction
        $conn->begin_transaction();

        // Step 2: Deduct from borrower's balance and add to lender's balance
        $updateBorrower = "UPDATE users_tb SET wallet_balance = wallet_balance - ? WHERE user_id = ?";
        $stmtBorrower = $conn->prepare($updateBorrower);
        $stmtBorrower->bind_param('di', $loan_amount, $user_id);
        if (!$stmtBorrower->execute()) {
            $conn->rollback();
            die("Error updating borrower balance: " . $stmtBorrower->error);
        }

        // Calculate the precise outstanding balance
        $new_outstanding_balance = bcadd(bcsub((string)$current_outstanding_balance, (string)$loan_amount, 2), (string)$share_admin, 2);

        // Update lender balance (minus the admin's share)
        $amount_for_lender = bcsub((string)$loan_amount, (string)$share_admin, 2);
        $updateLender = "UPDATE users_tb SET wallet_balance = wallet_balance + ? WHERE user_id = ?";
        $stmtLender = $conn->prepare($updateLender);
        $stmtLender->bind_param('di', $amount_for_lender, $lender_id);
        if (!$stmtLender->execute()) {
            $conn->rollback();
            die("Error updating lender balance: " . $stmtLender->error);
        }

        // Step 3: Deduct admin share from lender's wallet and add to admin
        $updateLenderForAdmin = "UPDATE users_tb SET wallet_balance = wallet_balance - ? WHERE user_id = ?";
        $stmtLenderForAdmin = $conn->prepare($updateLenderForAdmin);
        $stmtLenderForAdmin->bind_param('di', $share_admin, $lender_id);
        if (!$stmtLenderForAdmin->execute()) {
            $conn->rollback();
            die("Error deducting admin share from lender: " . $stmtLenderForAdmin->error);
        }

        // Step 4: Transfer admin share to the admin
        $adminQuery = "UPDATE users_tb SET wallet_balance = wallet_balance + ? WHERE account_role = 'Admin'";
        $stmtAdmin = $conn->prepare($adminQuery);
        $stmtAdmin->bind_param('d', $share_admin);
        if (!$stmtAdmin->execute()) {
            $conn->rollback();
            die("Error updating admin balance: " . $stmtAdmin->error);
        }

        // Step 5: Update outstanding balance in borrower_info
        $updateOutstandingBalance = "UPDATE borrower_info SET outstanding_balance = ? WHERE user_id = ? AND transaction_id = ?";
        $stmtOutstanding = $conn->prepare($updateOutstandingBalance);
        $stmtOutstanding->bind_param('dis', $new_outstanding_balance, $user_id, $transaction_id);
        if (!$stmtOutstanding->execute()) {
            $conn->rollback();
            die("Error updating outstanding balance: " . $stmtOutstanding->error);
        }

        // Step 6: Insert deadline into loan_deadlines table
        $insertDeadline = "INSERT INTO loan_deadlines (transaction_id, amount, deadline, created_at, user_id, lender_id) VALUES (?, ?, ?, NOW(), ?, ?)";
        $stmtDeadline = $conn->prepare($insertDeadline);
        $stmtDeadline->bind_param("sisis", $transaction_id, $loan_amount, $deadline_to_transfer, $user_id, $lender_id);
        if (!$stmtDeadline->execute()) {
            $conn->rollback();
            die("Error inserting deadline: " . $stmtDeadline->error);
        }

        // Commit transaction
        $conn->commit();

        // Close statements and connection
        $stmt->close();
        $conn->close();

        // Redirect back to borrower_applicationform.php
        header("Location: borrower_paymentsuccess.php");
        exit();
    } else {
        // Set session variable for insufficient balance
        $_SESSION['insufficient_balance'] = true;
        header("Location: borrower_applicationform.php");
        exit();
    }
} else {
    echo "No loan found for the given user ID and transaction ID.";
}
?>
