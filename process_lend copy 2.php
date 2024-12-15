<?php
include 'condb.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Enable detailed error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
                    // Handle signature upload
                    if (isset($_FILES['signature']) && $_FILES['signature']['error'] == 0) {
                        // Retrieve the signature file details
                        $signature_image = $_FILES['signature']['name'];
                        $target_directory = "dashboard/uploads/"; // Ensure this directory exists
                        $target_file = $target_directory . basename($signature_image);

                        // Move the uploaded file to the target directory
                        if (move_uploaded_file($_FILES['signature']['tmp_name'], $target_file)) {
                            // Save the file path into the database
                            $saveSignatureQuery = "UPDATE borrower_info SET lender_signature = ? WHERE transaction_id = ?";
                            $saveSignatureStmt = $conn->prepare($saveSignatureQuery);
                            $saveSignatureStmt->bind_param('si', $target_file, $transaction_id);
                            $saveSignatureStmt->execute();
                        } else {
                            echo "Error uploading signature image.";
                        }
                    }

                    // Step 6: Update the transaction status to "Invested" and set the lender_id
                    $statusQuery = "UPDATE borrower_info SET status = 'Invested', lender_id = ? WHERE transaction_id = ?";
                    $statusStmt = $conn->prepare($statusQuery);
                    $statusStmt->bind_param('ii', $lender_user_id, $transaction_id);

                    if ($statusStmt->execute()) {
                        // Step 7: Update the lender's total amount lent and loans made
                        $updateLenderStatsQuery = "UPDATE users_tb SET 
                            total_amount_lent = total_amount_lent + ?, 
                            loans_made = loans_made + 1 
                            WHERE user_id = ?";
                        $updateLenderStatsStmt = $conn->prepare($updateLenderStatsQuery);
                        $updateLenderStatsStmt->bind_param('di', $loan_amount, $lender_user_id);

                        // Execute the lender stats update
                        if ($updateLenderStatsStmt->execute()) {
                            // Output the modal HTML and JavaScript to show it
                            header("Location: lender_paymentsuccess.php");
                            exit; // Stop further script execution
                        } else {
                            echo "Failed to update lender stats.";
                        }
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
            // Code for handling insufficient balance (error modal)
            echo '<script>alert("Insufficient balance.");</script>';
        }
    } else {
        echo "Borrower not found.";
    }
}
?>
