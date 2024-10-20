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
                        // Output the modal HTML and JavaScript to show it
                        echo '
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                            <title>Success</title>
                        </head>
                        <body>
                            <!-- Modal -->
                            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Funds transferred successfully, transaction marked as Approved, and lender_id updated!
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <script>
                                // Show the modal when the page loads
                                var successModal = new bootstrap.Modal(document.getElementById("successModal"), {});
                                successModal.show();
                    
                                // Redirect after the modal is closed or after a delay (3 seconds)
                                successModal._element.addEventListener("hidden.bs.modal", function () {
                                    window.location.href = "lender.php";
                                });
                    
                                // Alternatively, redirect after 3 seconds automatically
                                setTimeout(function() {
                                    window.location.href = "lender.php";
                                }, 3000); // 3 seconds
                            </script>
                        </body>
                        </html>';
                        exit; // Stop further script execution
                    }
                    
                     else {
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
