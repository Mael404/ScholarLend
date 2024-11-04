<?php
session_start();

// Check if the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_POST['user_id'];
$deadline_to_transfer = $_POST['deadline']; // Renamed for clarity
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
    $lender_id = $row['lender_id'];
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
        $stmtBorrower->execute();

        // Calculate the precise outstanding balance (subtract total_amount and add share_admin)
        $new_outstanding_balance = bcadd(bcsub((string) $current_outstanding_balance, (string) $loan_amount, 2), (string) $share_admin, 2);

        // Update lender balance (minus the admin's share)
        $amount_for_lender = bcsub((string) $loan_amount, (string) $share_admin, 2);
        $updateLender = "UPDATE users_tb SET wallet_balance = wallet_balance + ? WHERE user_id = ?";
        $stmtLender = $conn->prepare($updateLender);
        $stmtLender->bind_param('di', $amount_for_lender, $lender_id);
        $stmtLender->execute();

        // Step 3: Deduct admin share from lender's wallet and add to admin
        $updateLenderForAdmin = "UPDATE users_tb SET wallet_balance = wallet_balance - ? WHERE user_id = ?";
        $stmtLenderForAdmin = $conn->prepare($updateLenderForAdmin);
        $stmtLenderForAdmin->bind_param('di', $share_admin, $lender_id);
        $stmtLenderForAdmin->execute();

        // Step 4: Transfer admin share to the admin
        $adminQuery = "UPDATE users_tb SET wallet_balance = wallet_balance + ? WHERE account_role = 'Admin'";
        $stmtAdmin = $conn->prepare($adminQuery);
        $stmtAdmin->bind_param('d', $share_admin);
        $stmtAdmin->execute();

        // Step 5: Update outstanding balance in borrower_info
        $updateOutstandingBalance = "UPDATE borrower_info SET outstanding_balance = ? WHERE user_id = ? AND transaction_id = ?";
        $stmtOutstanding = $conn->prepare($updateOutstandingBalance);
        $stmtOutstanding->bind_param('dis', $new_outstanding_balance, $user_id, $transaction_id);
        $stmtOutstanding->execute();

        // Step 6: Transfer the deadline to payed_dates instead of deleting
        $sql = "UPDATE borrower_info SET payed_dates = CONCAT_WS(',', payed_dates, ?) WHERE user_id = ? AND transaction_id = ?";
        $stmtTransferDate = $conn->prepare($sql);
        $stmtTransferDate->bind_param("sis", $deadline_to_transfer, $user_id, $transaction_id);
        $stmtTransferDate->execute();

        // Remove deadline logic as before
        $sql = "SELECT next_deadlines FROM borrower_info WHERE user_id = ? AND transaction_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $_SESSION['transaction_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $next_deadlines = $row['next_deadlines'];
            $next_deadlines_array = array_map('trim', explode(',', $next_deadlines));

            // Remove the specified deadline
            if (($key = array_search(trim($deadline_to_transfer), $next_deadlines_array)) !== false) {
                unset($next_deadlines_array[$key]);
            }

            $new_deadlines = implode(', ', array_values($next_deadlines_array));
            $update_sql = "UPDATE borrower_info SET next_deadlines = ? WHERE user_id = ? AND transaction_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sis", $new_deadlines, $user_id, $_SESSION['transaction_id']);
            $update_stmt->execute();
        }

        $conn->commit(); // Commit transaction

        // Close statements and connection
        $stmt->close();
        $update_stmt->close();
        $conn->close();

        // Redirect back to borrower_applicationform.php
        header("Location: borrower_applicationform.php");
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
