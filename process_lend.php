<?php
include 'condb.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if (isset($_POST['lendNow'])) {
    // Retrieve loan amount and transaction_id from the POST request
    $loan_amount = $_POST['loan_amount'];
    $transaction_id = $_POST['transaction_id'];

    // Step 1: Find the user_id of the borrower based on the transaction_id
    $query = "SELECT user_id FROM borrower_info WHERE transaction_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user_id of the borrower
        $row = $result->fetch_assoc();
        $borrower_user_id = $row['user_id'];

        // Step 2: Get the lender's user_id from the session (assuming the lender is logged in)
        $lender_user_id = $_SESSION['user_id']; // Assuming the lender's user_id is stored in the session
        
        // Step 3: Check if the lender has enough balance
        $lenderQuery = "SELECT wallet_balance FROM users_tb WHERE user_id = ?";
        $lenderStmt = $conn->prepare($lenderQuery);
        $lenderStmt->bind_param('i', $lender_user_id);
        $lenderStmt->execute();
        $lenderResult = $lenderStmt->get_result();
        $lender = $lenderResult->fetch_assoc();
        
        if ($lender['wallet_balance'] >= $loan_amount) {
            // Step 4: Deduct the loan amount from the lender's wallet
            $deductQuery = "UPDATE users_tb SET wallet_balance = wallet_balance - ? WHERE user_id = ?";
            $deductStmt = $conn->prepare($deductQuery);
            $deductStmt->bind_param('di', $loan_amount, $lender_user_id);

            if ($deductStmt->execute()) {
                // Step 5: Transfer the funds to the borrower's wallet
                $updateQuery = "UPDATE users_tb SET wallet_balance = wallet_balance + ? WHERE user_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param('di', $loan_amount, $borrower_user_id);

                if ($updateStmt->execute()) {
                    // Step 6: Update the transaction status to "Approved" and set the lender_id
                    $statusQuery = "UPDATE borrower_info SET status = 'Approved', lender_id = ? WHERE transaction_id = ?";
                    $statusStmt = $conn->prepare($statusQuery);
                    $statusStmt->bind_param('ii', $lender_user_id, $transaction_id);

                    if ($statusStmt->execute()) {
                        echo "Funds transferred successfully, transaction marked as Approved, and lender_id updated!";
                    } else {
                        echo "Failed to update transaction status and lender_id.";
                    }
                } else {
                    echo "Failed to transfer funds to borrower.";
                }
            } else {
                echo "Failed to deduct funds from lender.";
            }
        } else {
            echo "Lender does not have enough balance.";
        }
    } else {
        echo "Borrower not found.";
    }
}
?>
