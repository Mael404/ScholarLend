<?php
session_start(); // Start session to access session variables

include 'display_user_wallet.php';
if (isset($_SESSION['insufficient_balance'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('insufficientBalanceModal'));
                myModal.show();
            });
          </script>";
    unset($_SESSION['insufficient_balance']); // Clear the session variable after displaying the modal
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <title>ScholarLend - Admin</title>

    <style>
    
    .list-group-item {
    width: 300px; /* Set the desired width */
    border-radius: 8px; /* Add border radius */
    transition: background-color 0.3s ease, transform 0.3s ease, padding 0.3s ease; /* Add transitions */
    margin-left: 60px; /* Adjust left margin for the entire item */
    margin-bottom: 4px; /* Add spacing between items */
    display: flex; /* Use flexbox */
    align-items: center; /* Center text vertically */
    height: 50px; /* Set a fixed height */
    font-size: larger; /* Increase font size */
    text-align: left; /* Align text to the left */
    padding-left: 85px; /* Add padding to move the text leftwards */
}


/* Active sidebar item */
.list-group-item.active {
    background-color: #dbbf94; /* Set the background color for active item */
    color: rgb(255, 255, 255); /* Set the text color for active item */
    font-weight: bold; /* Make the text bold for active item */
    border-radius: 8px; /* Keep the rounded corners */
    border: none; /* Remove any border if necessary */
}

    .list-group-item:hover {
        background-color: #dbbf94; /* Set background color on hover */
        color: white; /* Set text color on hover */
       
    }

    .user-info {
    display: flex; /* Use flexbox */
    align-items: center; /* Center items vertically */
    justify-content: center; /* Center items horizontally */
 
}

.user-info img {
    margin-right: 80px; /* Space between image and text */
}

.user-details {
    text-align: left; /* Align text to the left */
}

.username {
    font-weight: bold; /* Make username bold */
    font-size: large;
}

.email {
    font-size: 0.9em; /* Slightly smaller font for email */
    color: black; /* Change email color if desired */
}
.border-bottom {
    border-bottom: 3.5px solid #f0f0f0 !important;
}


    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-1 fw-bold border-bottom" style="font-family: 'Times New Roman', Times, serif;">
                <i class=""></i>
                <span style="color: #dbbf94;">Scholar</span><span style="color: black;">Lend</span>
            </div>
            
          
            <div class="user-info d-flex align-items-center my-3 text-center">
            <i class="fas fa-user-circle" style="font-size: 50px; margin-right: 10px;"></i>
                <div class="user-details">
    <div class="username">
        <?php 
        echo isset($_SESSION['first_name']) && isset($_SESSION['last_name']) 
            ? $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] 
            : 'Guest'; 
        ?>
    </div>
    <div class="email">
        <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'user@example.com'; ?>
    </div>
</div>

          
           
               
            </div>
            <br>
        
            <div class="list-group list-group-flush my-3">
    <a href="borrower_applicationform.php" class="list-group-item list-group-item-action active">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </a>
    <?php
include 'condb.php';

// Get the logged-in user's ID from session
$user_id = $_SESSION['user_id']; // assuming user_id is stored in session

// SQL query to count unread messages for the current user
$sql = "SELECT COUNT(*) AS unread_count FROM messages WHERE borrower_id = ? AND status = 'unread'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
$unread_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];
}

$stmt->close();
$conn->close();
?>

<a href="borrower_messages.php" class="list-group-item position-relative">
    <i class="fas fa-envelope me-2"></i>Messages
    <?php if ($unread_count > 0): ?>
        <span class="badge bg-danger position-absolute top-2 end-0 translate-middle rounded-pill" style="z-index: 2;"><?php echo $unread_count; ?></span>
    <?php endif; ?>
</a>


   
    <a href="borrower_transactions.php" class="list-group-item">
        <i class="fas fa-exchange-alt me-2"></i>Transactions
    </a>
    <a href="borrower_settings.php" class="list-group-item">
        <i class="fas fa-cog me-2"></i>Settings
    </a>
    <a href="borrower_contactus.php" class="list-group-item">
        <i class="fas fa-address-book me-2"></i>Contact Us
    </a>
    <a href="/butterfly/index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="fas fa-power-off me-2"></i>Logout
    </a>
</div>


            
            
        </div>
        
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
            <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                ONLINE APPLICATION FORM
            </h2>
        </div>

   

        <!-- Wallet Section (Positioned Where User Dropdown Was) -->
        

    </div>
</nav>

<!-- Optional CSS for wallet styling -->
<style>
    .wallet-link {
        color: black;
        font-size: 1.1rem;
        background-color: #dbbf94;
        border-radius: 9px;
    }
    .wallet-balance {
        font-weight: bold;
    }
    #refreshButton {
  cursor: pointer;
  transition: transform 0.4s ease-in-out;
}

#refreshButton.refreshing {
  transform: rotate(360deg);
}

</style>


            <div class="container-fluid px-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-9 text-center p-0 mt-3 mb-2">
                        <div class="card px-0 pt-0 pb-0 mt-3 mb-3">
                        <i class="fas fa-sync-alt fa-2x" onclick="window.location.reload();" id="refreshButton"></i>

                        <?php

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Database connection
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

// Query to check if the user has a pending application
$sql_pending = "SELECT * FROM borrower_info WHERE user_id = ? AND status = 'pending'";
$stmt_pending = $conn->prepare($sql_pending);
$stmt_pending->bind_param("i", $user_id);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();
$has_pending_application = $result_pending->num_rows > 0;

// Query to check if the user has an approved application
$sql_approved = "SELECT * FROM borrower_info WHERE user_id = ? AND status = 'Approved'";
$stmt_approved = $conn->prepare($sql_approved); 
$stmt_approved->bind_param("i", $user_id);
$stmt_approved->execute();
$result_approved = $stmt_approved->get_result();

// Query to check if the application status is "Posted"
$sql_posted = "SELECT * FROM borrower_info WHERE user_id = ? AND status = 'posted'";
$stmt_posted = $conn->prepare($sql_posted);
$stmt_posted->bind_param("i", $user_id);
$stmt_posted->execute();
$result_posted = $stmt_posted->get_result();
$has_posted_application = $result_posted->num_rows > 0;

// Query to check if the application status is "Invested"
$sql_invested = "SELECT * FROM borrower_info WHERE user_id = ? AND status = 'invested'";
$stmt_invested = $conn->prepare($sql_invested);
$stmt_invested->bind_param("i", $user_id);
$stmt_invested->execute();
$result_invested = $stmt_invested->get_result();
$has_invested_application = $result_invested->num_rows > 0;

// Fetch approved, posted, or invested application details if they exist
$posted_or_approved_application = $result_posted->fetch_assoc() ?: $result_approved->fetch_assoc() ?: $result_invested->fetch_assoc();

if ($posted_or_approved_application) {
    $_SESSION['transaction_id'] = $posted_or_approved_application['transaction_id'];
    $next_deadlines = $posted_or_approved_application['next_deadlines'];

    if (empty(trim($next_deadlines))) {
        $sql_update_status = "UPDATE borrower_info SET status = 'Completed' WHERE user_id = ? AND transaction_id = ? AND (status = 'approved' OR status = 'posted' OR status = 'invested')";
        $stmt_update_status = $conn->prepare($sql_update_status);
        $stmt_update_status->bind_param("is", $user_id, $_SESSION['transaction_id']);
        $stmt_update_status->execute();
        $stmt_update_status->close();
    }
}

// Additional check for loan_deadlines table to display pending payment message
$sql_deadlines = "SELECT * FROM loan_deadlines WHERE user_id = ? AND status = 'Pending'";
$stmt_deadlines = $conn->prepare($sql_deadlines);
$stmt_deadlines->bind_param("i", $user_id);
$stmt_deadlines->execute();
$result_deadlines = $stmt_deadlines->get_result();
$has_pending_payment = $result_deadlines->num_rows > 0;

// Close statements
$stmt_pending->close();
$stmt_approved->close();
$stmt_posted->close();
$stmt_invested->close();
$stmt_deadlines->close();

// If the user has a pending payment, show the message
if ($has_pending_payment) {
    echo "</br>";
echo "</br>";
echo "</br>";
echo "</br>";
echo "</br>";
echo "</br>";
echo "</br>";
echo "<p style='font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: bold; color: #4CAF50; text-align: center;'>
        <i class='fas fa-check-circle' style='margin-right: 10px;'></i> 
        Your payment is being processed
      </p>";


}
elseif ($has_pending_application) {
    $pending_application = $result_pending->fetch_assoc();
    $total_amount = $pending_application['total_amount'];
    $next_deadlines = $pending_application['next_deadlines'];
    $next_deadlines_array = array_map('trim', explode(',', $next_deadlines));
    $first_deadline = !empty($next_deadlines_array) ? $next_deadlines_array[0] : 'No deadlines available';
    
  
echo '<p style="background: linear-gradient(135deg, #dbbf94, #ccac82); padding: 15px; border-radius: 4px; color: #333333; font-size: 20px; text-align: left; width: 100%; margin: 10px auto; border: 1px solid #b29c84;"><strong>PENDING:</strong> Your application is now being processed.</p>';

// Display the application summary
echo '<div style="background-color: #f4f1ec; border-radius: 9px; padding: 20px; margin: 10px auto; color: #333; font-family: Arial, sans-serif; width: 100%;">';

echo '<h2 style="font-family: Georgia, serif; font-weight: bold; color: #131e3d; font-size: 28px; margin-bottom: 15px; text-align:left;">Your Loans</h2>';

echo '<div style="display: flex; justify-content: space-between; align-items: center; padding: 25px 0;">';
// Amount section
echo '<div style="text-align: left;">';
echo '<p style="font-size: 18px; color: #131e3d; font-weight: 200; margin: 0;">AMOUNT</p>';
echo '<p style="font-size: 40px; color: #cdad7d; font-weight: bold; margin: 5px 0;">₱' . number_format($total_amount, 2) . '</p>';
echo '</div>';

// First payment section
echo '<div style="text-align: center;">';
echo '<p style="font-size: 18px; color: #131e3d; font-weight: 200; margin: 0;">FIRST PAYMENT IS DUE ON</p>';
echo '<p style="font-size: 28px; color: #a6a6a6; font-weight: bold; margin: 5px 0;">' . date('M. j, Y', strtotime($first_deadline)) . '</p>';
echo '</div>';

// Pay Now button (disabled for pending applications)
echo '<div style="text-align: right;">';
echo '<button type="button" disabled style="background-color: #ccc; color: white; padding: 12px 25px; border: none; border-radius: 5px; margin-top: 10px; font-size: 18px; cursor: not-allowed;">Pay Now</button>';
echo '</div>';

echo '</div>';
echo '<div style="text-align: center; margin-top: 0px;">';
        echo '<button style="background-color: #dbbf94; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold;">VIEW DETAILED REPAYMENT SCHEDULE</button>';
        echo '</div>';
echo '</div>';


    
} elseif ($has_invested_application) {
    $invested_application = $result_invested->fetch_assoc();
    $total_amount = $posted_or_approved_application['total_amount']; // Retrieve or default to 0 if not set
    $next_deadlines = $posted_or_approved_application['next_deadlines'] ?? '';
    if (!empty($next_deadlines)) {
        // Split the string into individual dates
        $next_deadlines_array = array_map('trim', explode(',', $next_deadlines));
    
        // Convert each date to the format 'Y-m-d'
        $formatted_deadlines = [];
        foreach ($next_deadlines_array as $deadline) {
            // Convert from mm/dd/yyyy to yyyy-mm-dd
            $date = DateTime::createFromFormat('m/d/Y', $deadline);
            if ($date) {
                $formatted_deadlines[] = $date->format('Y-m-d');
            }
        }
    
        // If there's a valid date, display the first one, else show a default message
        $first_deadline = !empty($formatted_deadlines) ? date('M. j, Y', strtotime($formatted_deadlines[0])) : 'No deadlines available';
    } else {
        $first_deadline = 'No deadlines available';
    }
    

    echo '<p style="background: linear-gradient(135deg, #dbbf94, #ccac82); padding: 15px; border-radius: 4px; color: #333333; font-size: 20px; text-align: left; width: 100%; margin: 10px auto; border: 1px solid #b29c84;"><strong>PENDING:</strong> Your application has been fully funded and is awaiting the final transfer of funds by the administrator</p>';

// Display the application summary
echo '<div style="background-color: #f4f1ec; border-radius: 9px; padding: 20px; margin: 10px auto; color: #333; font-family: Arial, sans-serif; width: 100%;">';

echo '<h2 style="font-family: Georgia, serif; font-weight: bold; color: #131e3d; font-size: 28px; margin-bottom: 15px; text-align:left;">Your Loans</h2>';

echo '<div style="display: flex; justify-content: space-between; align-items: center; padding: 25px 0;">';
// Amount section
echo '<div style="text-align: left;">';
echo '<p style="font-size: 18px; color: #131e3d; font-weight: 200; margin: 0;">AMOUNT</p>';
echo '<p style="font-size: 40px; color: #cdad7d; font-weight: bold; margin: 5px 0;">₱' . number_format($total_amount, 2) . '</p>';
echo '</div>';

// First payment section
echo '<div style="text-align: center;">';
echo '<p style="font-size: 18px; color: #131e3d; font-weight: 200; margin: 0;">FIRST PAYMENT IS DUE ON</p>';
echo '<p style="font-size: 28px; color: #a6a6a6; font-weight: bold; margin: 5px 0;">' . date('M. j, Y', strtotime($first_deadline)) . '</p>';
echo '</div>';

// Pay Now button (disabled for pending applications)
echo '<div style="text-align: right;">';
echo '<button type="button" disabled style="background-color: #ccc; color: white; padding: 12px 25px; border: none; border-radius: 5px; margin-top: 10px; font-size: 18px; cursor: not-allowed;">Pay Now</button>';
echo '</div>';

echo '</div>';
echo '<div style="text-align: center; margin-top: 0px;">';
        echo '<button style="background-color: #dbbf94; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold;">VIEW DETAILED REPAYMENT SCHEDULE</button>';
        echo '</div>';
echo '</div>';
} elseif ($posted_or_approved_application) {
    $due_date = $posted_or_approved_application['due_date'];
    $next_deadlines = $posted_or_approved_application['next_deadlines'];
    $total_amount = $posted_or_approved_application['total_amount'];
    $next_deadlines_array = array_map('trim', explode(',', $next_deadlines));
    $first_deadline = !empty($next_deadlines_array) ? $next_deadlines_array[0] : 'No deadlines available';

    if ($has_posted_application) {
      

        echo '<p style="background: linear-gradient(135deg, #dbbf94, #ccac82); padding: 15px; border-radius: 4px; color: #333333; font-size: 20px; text-align: left; width: 100%; margin: 10px auto; border: 1px solid #b29c84;"><strong>PENDING:</strong> Your application has been successfully posted. Please wait for a lender to review and fund your request.</p>';

        // Display the application summary
        echo '<div style="background-color: #f4f1ec; border-radius: 9px; padding: 20px; margin: 10px auto; color: #333; font-family: Arial, sans-serif; width: 100%;">';
        
        echo '<h2 style="font-family: Georgia, serif; font-weight: bold; color: #131e3d; font-size: 28px; margin-bottom: 15px; text-align:left;">Your Loans</h2>';
        
        echo '<div style="display: flex; justify-content: space-between; align-items: center; padding: 25px 0;">';
        // Amount section
        echo '<div style="text-align: left;">';
        echo '<p style="font-size: 18px; color: #131e3d; font-weight: 200; margin: 0;">AMOUNT</p>';
        echo '<p style="font-size: 40px; color: #cdad7d; font-weight: bold; margin: 5px 0;">₱' . number_format($total_amount, 2) . '</p>';
        echo '</div>';
        
        // First payment section
        echo '<div style="text-align: center;">';
        echo '<p style="font-size: 18px; color: #131e3d; font-weight: 200; margin: 0;">FIRST PAYMENT IS DUE ON</p>';
        echo '<p style="font-size: 28px; color: #a6a6a6; font-weight: bold; margin: 5px 0;">' . date('M. j, Y', strtotime($first_deadline)) . '</p>';
        echo '</div>';
        
        // Pay Now button (disabled for pending applications)
        echo '<div style="text-align: right;">';
        echo '<button type="button" disabled style="background-color: #ccc; color: white; padding: 12px 25px; border: none; border-radius: 5px; margin-top: 10px; font-size: 18px; cursor: not-allowed;">Pay Now</button>';
        echo '</div>';
        
        echo '</div>';
        echo '<div style="text-align: center; margin-top: 0px;">';
                echo '<button style="background-color: #dbbf94; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold;">VIEW DETAILED REPAYMENT SCHEDULE</button>';
                echo '</div>';
        echo '</div>';
        
    } else {
       
        echo '<div style="background-color: #f4f1ec; border-radius: 9px; padding: 30px; margin: 20px auto; color: #333; font-family: Arial, sans-serif; width: 100%;">';
echo '<h2 style="font-family: Georgia, serif; font-weight: bold; color: #131e3d; margin-bottom: 20px; text-align:left; font-size: 32px;">Your Loans</h2>';
// Flex container with three columns
echo '<div style="display: flex; justify-content: space-between; align-items: center; padding: 30px 0;">';

// First column (Amount)
echo '<div style="text-align: left;">';
echo '<p style="font-size: 20px; color: #131e3d; font-weight: 200; margin: 0;">AMOUNT</p>';
echo '<p style="font-size: 48px; color: #cdad7d; font-weight: bold; margin: 10px 0;">₱' . number_format($total_amount, 2) . '</p>';
echo '</div>';

// Second column (Due Date)
echo '<div style="text-align: center;">';
echo '<p style="font-size: 20px; color: #131e3d; font-weight: 200; margin: 0;">FIRST PAYMENT IS DUE ON</p>';
echo '<p style="font-size: 30px; color: #a6a6a6; font-weight: bold; margin: 10px 0;">' . date('M. j, Y', strtotime($first_deadline)) . '</p>';
echo '</div>';

// Third column (Button and Form)
echo '<div style="text-align: right;">';
echo '<form id="payForm" action="remove_deadline.php" method="POST" style="display: inline;">';
echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
echo '<input type="hidden" name="deadline" value="' . htmlspecialchars($first_deadline) . '">';
echo '<input type="hidden" name="transaction_id" value="' . $_SESSION['transaction_id'] . '">';
echo '<button type="button" onclick="showConfirmationBox()" style="background-color: #131e3d; color: white; padding: 15px 30px; font-size: 20px; border: none; border-radius: 8px; margin-top: 15px; cursor: pointer;">Pay Now</button>';
echo '</form>';
echo '</div>';

echo '</div>'; 
echo '</div>';

        
        // Custom Confirmation Dialog with Larger Size
        echo '
        <div id="confirmationBox" style="display: none; background-color: rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; align-items: center; justify-content: center; z-index: 9999;">
            <div style="background-color: white; padding: 40px; border-radius: 10px; width: 500px; text-align: center;">
                <h5 style="font-size: 24px; font-weight: bold; color: #131e3d;">Confirm Payment</h5>
                <p style="font-size: 18px; color: #333; margin: 10px 0;">Are you sure you want to proceed with the payment?</p>
                <!-- GCash QR Code Image -->
                <img src="https://businessmaker-academy.com/cms/wp-content/uploads/2022/04/Gcash-BMA-QRcode.jpg" alt="GCash QR Code" class="gcash-qr mb-3" style="max-width: 100%; height: auto; border-radius: 10px; max-height: 300px;">
                <div>
                    <button id="confirmBtn" style="background-color: #131e3d; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; margin: 10px;">Confirm</button>
                    <button onclick="hideConfirmationBox()" style="background-color: #cdad7d; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; margin: 10px;">Cancel</button>
                </div>
            </div>
        </div>';
        
        // JavaScript to handle the custom confirmation box
        echo '
        <script>
            function showConfirmationBox() {
                document.getElementById("confirmationBox").style.display = "flex";
            }
        
            function hideConfirmationBox() {
                document.getElementById("confirmationBox").style.display = "none";
            }
        
            // Fix for form submission
            document.getElementById("confirmBtn").addEventListener("click", function() {
                document.getElementById("payForm").submit(); // Submit the form when "Confirm" is clicked
            });
        </script>';
        
    }
} else {



$conn->close();
?>

                            <form id="msform" action="borrower_apform_data.php" method="post" enctype="multipart/form-data">
                                                     
                                <ul id="progressbar">
                                    <li id="account" data-step="1" class="active">Personal Information</li>
                                    <li id="personal" data-step="2">Financial and Other Info</li>
                                    <li id="payment" data-step="3">Payment</li>
                                    <li id="confirm" data-step="4">Confirm</li>
                                </ul>
                                
                               
                            <p>Fill all form field to go to next step</p>
                                <br>
                                <!-- fieldsets -->
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Complete Personal Information</h2>
                                            </div>
                                            <div class="col-5"></div>
                                        </div>
                                
                                        <!-- Name Fields in 4-4-4 Layout -->
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-sm" id="fname" name="fname" placeholder="First Name" style="font-size: 0.9rem;" required>
                                                    <label for="fname">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-sm" id="mname" name="mname" placeholder="Middle Name" style="font-size: 0.9rem;" required>
                                                    <label for="mname">Middle Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-sm" id="lname" name="lname" placeholder="Last Name" style="font-size: 0.9rem;" required>
                                                    <label for="lname">Last Name</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Birthdate and Gender in 8-4 Layout -->
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control form-control-sm" id="birthdate" name="birthdate" placeholder="Birthdate" style="font-size: 0.9rem;" required>
                                                    <label for="birthdate">Birthdate</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <select class="form-select form-control-sm" id="gender" name="gender" required>
                                                        <option value="" disabled selected>Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    <label for="gender">Gender</label>
                                                </div>
                                            </div>
                                            
                                        </div>
                                
                                        <!-- Cellphone Number in 12 -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="tel" class="form-control form-control-sm" id="cellphonenumber" name="cellphonenumber" placeholder="Cellphone Number" style="font-size: 0.9rem;" required>
                                                    <label for="cellphonenumber">Cellphone Number</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Email in 12 -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email address" style="font-size: 0.9rem;" required>
                                                    <label for="email">Email address</label>
                                                </div>
                                            </div>
                                        </div>

                                       <!-- Current Address in 12 -->
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <input type="text" class="form-control form-control-sm" id="current_address" name="current_address" placeholder="Current Address" style="font-size: 0.9rem;" required>
            <label for="current_address">Current Address</label>
        </div>
    </div>
</div>

<!-- Permanent Address in 12 -->
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <input type="text" class="form-control form-control-sm" id="permanent_address" name="permanent_address" placeholder="Permanent Address" style="font-size: 0.9rem;" required>
            <label for="permanent_address">Permanent Address</label>
        </div>
    </div>
</div>
                                
                                        <!-- Educational Background -->
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Educational Background</h2>
                                            </div>
                                        </div>
                                
                                        <!-- School or University -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-sm" id="school" name="school" placeholder="School or University" style="font-size: 0.9rem;" required>
                                                    <label for="school">School or University</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- College -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-sm" id="college" name="college" placeholder="College" style="font-size: 0.9rem;" required>
                                                    <label for="college">College</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Program or Course -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-sm" id="course" name="course" placeholder="Program or Course" style="font-size: 0.9rem;" required>
                                                    <label for="course">Program or Course</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Year of Study -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                <select class="form-select form-control-sm" id="yearofstudy" name="yearofstudy" required>

                                                            <option value="" disabled selected>Select Year of Study</option>
                                                            <option value="4th year">4th year</option>
                                                            <option value="3rd year">3rd year</option>
                                                            <option value="2nd year">2nd year</option>
                                                            <option value="1st year">1st year</option>
                                                            </select>
                                                   
                                                    <label for="yearofstudy">Year of Study</label>
                                                </div>
                                            </div>
                                        </div>

                                      
                                
                                        <!-- Expected Graduation Date -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control form-control-sm" id="graduationdate" name="graduationdate" placeholder="Expected Graduation Date" style="font-size: 0.9rem;" required>
                                                    <label for="graduationdate">Expected Graduation Date</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- General Weighted Average -->
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-floating">
                                                    <select class="form-select form-control-sm" id="gwa" name="gwa" required>

                                                        <option value="" disabled selected>Select General Weighted Average</option>
                                                        <option value="1.4 - 1.0 (95-100)">1.4 - 1.0 (95-100)</option>
                                                        <option value="1.7 - 1.5 (92-94)">1.7 - 1.5 (92-94)</option>
                                                        <option value="2.5 - 1.8 (84-91)">2.5 - 1.8 (84-91)</option>
                                                        <option value="2.8 - 2.6 (78-83)">2.8 - 2.6 (78-83)</option>
                                                        <option value="3.0 - 2.9 (75-77)">3.0 - 2.9 (75-77)</option>
                                                        <option value="5.0 (Failure)">5.0 (Failure)</option>
                                                        </select>
                                                        <label for="gwa">Enter General Weighted Average</label>
                                                    </div>
                                                </div>
                                            </div>

                                          
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="Next" />
                                </fieldset>
                                
                                
                              
                                <fieldset>
                                    <!-- Financial Information -->
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Financial Information</h2>
                                            </div>
                                        </div>
                                
                                        <!-- Monthly Allowance -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                 
                                                    <select class="form-select" id="monthly-allowance" name="monthly-allowance" required>

                                                        <option value="" disabled selected>Select Monthly Allowance</option>
                                                        <option value="above 11,000">above 11,000</option>
                                                        <option value="9,001 - 11,000">9,001 - 11,000</option>
                                                        <option value="7,001 - 9,000">7,001 - 9,000</option>
                                                        <option value="5,001 - 7,000">5,001 - 7,000</option>
                                                        <option value="3,001 - 5,000">3,001 - 5,000</option>
                                                        <option value="1,001 - 3,000">1,001 - 3,000</option>
                                                        <option value="below 1,000">below 1,000</option>
                                                    </select>
                                                    <label for="monthly-allowance">Monthly Allowance</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Source of Allowance -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="source-of-allowance" name="source-of-allowance" required>
                                                        <option value="None" disabled selected>Select Source of Allowance</option>
                                                        <option value="Own Business">Own Business</option>
                                                        <option value="Parental Support">Parental Support</option>
                                                        <option value="Scholarships">Scholarships</option>
                                                        <option value="Part-time Job">Part-time Job</option>
                                                        
                                                      
                                                    </select>
                                                    <label for="source-of-allowance">Source of Allowance</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Monthly Expenses -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="monthly-expenses" name="monthly-expenses" required>
                                                        <option value="" disabled selected>Select Monthly Expenses</option>
                                                        <option value="Below 1,000">Below 1,000</option>
                                                        <option value="1,001 - 3,000">1,001 - 3,000</option>
                                                        <option value="3,001 - 5,000">3,001 - 5,000</option>
                                                        <option value="5,001 - 7,000">5,001 - 7,000</option>
                                                        <option value="7,001 - 9,000">7,001 - 9,000</option>
                                                        <option value="9,001 - 11,000">9,001 - 11,000</option>
                                                        <option value="Above 11,000">Above 11,000</option>
                                                    </select>
                                                    <label for="monthly-expenses">Monthly Expenses</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Other Information -->
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Other Information</h2>
                                            </div>
                                        </div>
                                
                                      <!-- School Community/Organization Membership -->
                                      <div class="row mb-3">
    <div class="col-md-12">
        <div class="form-floating">
            <select class="form-select" id="school_community" name="school_community" required onchange="toggleInputField()">
                <option value="" disabled selected>Select Affiliated Organization</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <label for="school_community">Affiliated Organization</label>
        </div>
    </div>
</div>

<!-- Hidden input field for additional information -->
<div class="row mb-3" id="affiliationDetails" style="display: none;">
    <div class="col-md-12">
        <div class="form-floating">
            <input type="text" class="form-control" id="school_community" name="school_community" placeholder="Enter Organization Name">
            <label for="affiliation_name">Organization Name</label>
        </div>
    </div>
</div>

<script>
    function toggleInputField() {
        const select = document.getElementById("school_community");
        const affiliationDetails = document.getElementById("affiliationDetails");
        
        if (select.value === "yes") {
            affiliationDetails.style.display = "block";
        } else {
            affiliationDetails.style.display = "none";
        }
    }
</script>


                                
                                        <!-- Select Spending Pattern -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="spending-pattern" name="spending-pattern" required>
                                                        <option value="" disabled selected>Select Spending Pattern</option>
                                                        <option value="Regular Expenses">Regular Expenses</option>
                                                        <option value="Discretionary Spending">Discretionary Spending</option>
                                                       
                                                    </select>
                                                    <label for="spending-pattern">Select Spending Pattern</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                    
                                
                                        <!-- Career Goals and Plans -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control" id="career-goals" name="career-goals" style="height: 150px; padding-top: 20px;" placeholder="Career Goals and Plans" required></textarea>
                                                    <label for="career-goals">Career Goals and Plans</label>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="Submit" /> 
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                </fieldset>
                                


                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <h2 class="fs-title">Loan Information</h2>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <select class="form-control form-control-sm" id="loanAmount" name="loan_amount" required>
                                                        <option value="" disabled selected>Select Loan Amount</option>
                                                        <option value="500"><?= '₱' ?>500</option>
                                                        <option value="1000"><?= '₱' ?>1000</option>
                                                        <option value="2000"><?= '₱' ?>2000</option>
                                                        <option value="3000"><?= '₱' ?>3000</option>
                                                        <option value="4000"><?= '₱' ?>4000</option>
                                                        <option value="5000"><?= '₱' ?>5000</option>
                                                    </select>
                                                    <label for="loanAmount">Loan Amount</label>
                                                </div>
                                            </div>
                                        </div>

                            
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                <select class="form-control form-control-sm" id="loanPurpose" name="loan_purpose" required>
                                                <option value="" disabled selected>Select Loan Purpose</option>
                                                        <option value="Directly Attributable to Studying">Directly Attributable to Studying</option>
                                                        <option value="Overhead to Studying">Overhead to Studying</option>  
                                                        <option value="General">General</option>                                               
                                                    </select>
                                                    <label for="loanPurpose">Loan Purpose</label>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <textarea class="form-control form-control-sm" id="loanDescription" name="loan_description" placeholder="Loan Description" required></textarea>
                                                    <label for="loanDescription">Loan Description</label>
                                                </div>
                                            </div>
                                        </div>
                            
                                      
                            
                                        <h3>Upload Documents</h3>
                            
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="file" class="form-control form-control-sm" id="cor1" name="cor1" accept="application/pdf,image/*" required style="padding: 25px;">
                                                    <label for="cor1">Certificate of Registration (COR)</label>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="file" class="form-control form-control-sm" id="cor2" name="cor2" accept="application/pdf,image/*" required style="padding: 25px;">
                                                    <label for="cor2">COG or Proof of Grades</label>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="file" class="form-control form-control-sm" id="cor3" name="cor3" accept="application/pdf,image/*" required style="padding: 25px;">
                                                    <label for="cor3">Proof of Allowance</label>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="file" class="form-control form-control-sm" id="cor4" name="cor4" accept="application/pdf,image/*" required style="padding: 25px;">
                                                    <label for="cor4">Proof of Expenses</label>
                                                </div>
                                            </div>

                                          


                                        </div>
                                        

                                    </div> 
                                    
                                    <input type="button" name="next" class="next action-button" value="Submit" /> 
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                </fieldset>
       

                                <fieldset>
    <div class="form-card">
        <div class="row">
            <div class="col-7">
                <h2 class="fs-title">Payment Details:</h2>
            </div>
        </div>

        <!-- Mode of Payment -->
        <div class="form-floating mb-3">
            <select class="form-select" name="payment_mode" id="paymentMode" aria-label="Floating label select example">
                <option selected>Select Mode of Payment</option>
                <option value="Lump Sum">Lump Sum</option>
                <option value="Installment">Installment</option>
            </select>
            <label for="paymentMode">Mode of Payment</label>
        </div>

        <!-- Frequency of Payment (only shown when Installment is selected) -->
        <div class="form-floating mb-3" id="frequencyContainer" style="display: none;">
            <select class="form-select" name="payment_frequency" id="paymentFrequency" aria-label="Floating label select example">
                <option selected>Select Payment Frequency</option>
                <option value="Daily">Daily</option>
                <option value="Weekly">Weekly</option>
                <option value="Monthly">Monthly</option>
            </select>
            <label for="paymentFrequency">Payment Frequency</label>
        </div>

        <!-- Due Date -->
        <div class="form-floating mb-3">
            <input type="date" class="form-control" name="due_date" id="dueDate" placeholder="Select Date of Payment" required>
            <label for="dueDate">Due Date</label>
        </div>

        <!-- Duration Selection (shown based on frequency) -->
        <div class="form-floating mb-3" id="durationContainer" style="display: none;">
            <label for="dueDateOptions">Choose Duration:</label>
            <select class="form-select" id="dueDateOptions">
                <option value="">Select</option>
                <!-- Options will be populated dynamically -->
            </select>
        </div>

        <!-- Account Details -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="account_details" id="accountDetails" placeholder="Enter Bank Account Details" required>
            <label for="accountDetails">Gcash Account Details</label>
        </div>

        <!-- Submit Button -->
        <input type="button" name="summary" class="next action-button" value="Submit" onclick="showSummaryModal()" />

        <!-- Previous Button -->
        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
    </div>
</fieldset>

<!-- Hidden inputs for modal values -->
<input type="hidden" id="hiddenPaymentMode" name="payment_mode">
  <input type="hidden" id="hiddenFrequency" name="frequency">
  <input type="hidden" id="hiddenDueDate" name="due_date">
  <input type="hidden" id="hiddenAccountDetails" name="account_details">
  <input type="hidden" id="hiddenTotalAmount" name="total_amount">
  <input type="hidden" id="hiddenNextDeadlines" name="next_deadlines">
  



                                
                            </form>

                            <?php
}
?>


                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="insufficientBalanceModal" tabindex="-1" role="dialog" aria-labelledby="insufficientBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insufficientBalanceModalLabel">Insufficient Balance</h5>
             
                </button>
            </div>
            <div class="modal-body">
                Insufficient balance to make the payment. Please top up your wallet and try again.
            </div>
            <div class="modal-footer">
             
            </div>
        </div>
    </div>
</div>
            
  <!-- Bootstrap Modal -->
<div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header text-white py-3 rounded-top" style="background-color: #131e3d;">
                <h5 class="modal-title fw-bold" id="summaryModalLabel">Payment Summary</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="fw-semibold text-secondary">Payment Mode:</span>
                    <span id="modalPaymentMode" class="text-dark"></span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="fw-semibold text-secondary">Frequency:</span>
                    <span id="modalFrequency" class="text-dark"></span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="fw-semibold text-secondary">Selected Due Date:</span>
                    <span id="modalDueDate" class="text-dark"></span>
                </div>
                <div class="d-flex flex-column align-items-start border-bottom py-2">
    <span class="fw-semibold text-secondary">Next Deadlines:</span>
    <br>
    <div id="modalNextDeadlines" class="w-100"></div>
</div>

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="fw-semibold text-secondary">Account Details:</span>
                    <span id="modalAccountDetails" class="text-dark"></span>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-3 d-none">
    <span class="fw-semibold text-secondary">Total Amount to be Paid:</span>
    <span id="modalTotalAmount" class="text-primary fw-bold"></span>
</div>

            </div>
            <div class="modal-footer py-3">
                <button type="button" class="btn btn-success btn-sm px-4" onclick="submitForm()" style="background-color: #dbbf94; border-color:#dbbf94;">Confirm</button>
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="termsandcon" tabindex="-1" role="dialog" aria-labelledby="termsandconLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsandconLabel">Loan Agreement</h5>
            </div>
            <div class="modal-body">
                <p><b>THE PARTIES</b></p>
                <p>This peer-to-peer lending agreement made as of <span id="effective-date"></span>, (the “Effective Date”) by and between:</p>

<script>
  // Get the current date
  const today = new Date();

  // Format the date (e.g., December 15, 2024)
  const formattedDate = today.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });

  // Set the formatted date in the span element
  document.getElementById('effective-date').textContent = formattedDate;
</script>

                <p><b>Lender:</b></p>
                <p>[Name of Lender]<br>
                [Address]<br>
                [City, State, Zip Code]<br>
                [Phone Number]<br>
                [Email Address]</p>

                <p><b>Borrower:</b></p>
<p>
    <span id="borrowerName">[Name of Borrower]</span><br>
    <span id="borrowerAddress">[Address]</span><br>
   
    <span id="borrowerPhone">[Phone Number]</span><br>
    <span id="borrowerEmail">[Email Address]</span>
</p>


                <p><b>Intermediary:</b></p>
                <p>ScholarLend, Inc.<br>
                [Address]<br>
                [City, State, Zip Code]<br>
                [Phone Number]<br>
                [Email Address]</p>

                <p>The parties agree as follows:</p>
                <p><b>Loan Amount:</b> Lender agrees to loan Borrower the principal sum of <span id="loanAmountText"></span>, together with interest on the outstanding principal amount of the Loan, and in accordance with the terms set forth below.</p>
     
       


<p><b>Repayment of Loan:</b> (Check one.)</p>
<p>
    <input type="checkbox" id="singlePayment" /> Single Payment. The Loan together with accrued and unpaid interest is due and payable on 
    <span id="dueDateText">________</span>.
</p>
<p>
<p>
    Installment Payments. The Loan together with accrued and unpaid interest shall be payable in installments equal to ₱<span id="installmentAmount"></span>.
    The first payment is due on <span id="firstPaymentDate"></span> and due thereafter in <span id="numberOfPayments"></span> equal consecutive payments: (Check one)
</p>


</p>
<p>
 <input type="checkbox" id="dailyInstallments" /> Daily installments. Each successive payment is due every day until the entire loan is paid.
</p>
<p>
    <input type="checkbox" id="weeklyInstallments" /> Weekly installments. Each successive payment is due every <span id="dayOftheWeek"></span> of the week.
</p>
<p>
    <input type="checkbox" id="monthlyInstallments" /> Monthly installments. Each successive payment is due on the <span id="dayOftheMonth"></span> of the month.
</p>
<p><b>Interest:</b> The Borrower shall pay interest on the Loan at the rate of 5.5% per week on the Principal amount, or equivalent to ₱<span id="interestValue"></span>. 70% of the interest paid by the Borrower shall be received by the Lender, while the remaining 30% shall go to ScholarLend Inc.</p>


                <p><b>Transaction Fee:</b> Upon perfection of the loan agreement, the Borrower shall pay a one-time transaction fee of P15 to be deducted from the principal amount borrowed. This transaction fee shall go to ScholarLend Inc.</p>

                <p><b>Security:</b> The loan is secured by collateral. Borrower agrees that until the Loan together with interest is paid in full. The Loan is secured by ________.</p>

                <p><b>Intermediary:</b> ScholarLend shall serve as the intermediary between the Lender and Buyer. The receipt, approval, withholding and disbursement process shall be the responsibility of the said Corporation.</p>

                <p><b>Default:</b> Failure to pay on the agreed date/s of payment shall subject the unpaid amount to a penalty rate of eleven percent (11%) per week, until fully paid.</p>

                <p><b>Modification:</b> This agreement may be modified, superseded, or voided only upon the written and signed agreement of the Parties. Further, the physical destruction or loss of this document shall not be construed as a modification or termination of the agreement contained herein.</p>

                <p><b>Good faith:</b> The Parties hereby declare and undertake to perform all obligations arising from this Loan Agreement in good faith and shall comply with all applicable laws and rules.</p>

                <p><b>IN WITNESS WHEREOF, we hereunto affix our signatures this ___ day of _______, 20__.</b></p>

                <p>
               

                <table class="signatories-table">
    <tr>
        <td>
            <div class="underline" style="margin-top:75%"></div>
        </td>
        <td>
            <div class="underline" style="margin-top:75%"></div>
        </td>
        <td>
    <img src="admin.png" alt="Admin" style="width: 100%; max-width: 200px; margin-bottom: 0px;">
    
    <div style="font-size: 14px; margin-top: 5px; text-align: center;">ROCHIEL GRACE S. YANSON</div>
    <div class="underline"></div>
</td>

    </tr>
    <tr>
        <td class="signatories-label">Signature over Printed Name<br>Lender</td>
        <td class="signatories-label">Signature over Printed Name<br>Borrower</td>
        <td class="signatories-label">Signature over Printed Name<br>General Manager, ScholarLend</td>
    </tr>
</table>

<style>
    .signatories-table {
        width: 100%;
        text-align: center;
        margin-top: 20px;
    }

    .signatories-table td {
        padding: 10px;
    }

    .signatories-label {
        font-size: 14px;
    }

    .underline {
        border-bottom: 2px solid black;
        width: 80%;  /* Adjust width of underline */
        margin: 5px auto; /* Center align and space below the image */
    }
</style>

</p>

                <!-- Upload Signature for Borrower -->
                <div class="form-group mt-3">
                    <label for="borrowerSignature">Upload Borrower's Signature:</label>
                    <input type="file" class="form-control" id="borrowerSignature" accept="image/*">
                </div>

                <!-- Placeholder for Signature -->
                <div id="borrowerSignaturePreview" class="mt-3" style="display:none;">
                    <h6>Borrower's Signature:</h6>
                    <img id="signaturePreview" src="" alt="Borrower's Signature" class="img-fluid" style="max-width: 200px;">
                </div>

                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" id="termsCheckbox" onchange="toggleAcceptButton()">
                    <label class="form-check-label" for="termsCheckbox">
                        I agree to the Terms and Conditions
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="acceptBtn" onclick="confirmSubmission()" disabled>I Accept</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("loanAmount").addEventListener("change", function() {
        // Get the selected loan amount
        var selectedAmount = this.value;
        // Update the span in the paragraph with the selected amount
        document.getElementById("loanAmountText").textContent = selectedAmount ? "₱" + selectedAmount : "________";
 
    });

    
</script>
<script>
    // Function to update borrower details
    function updateBorrowerDetails() {
        // Get the values from the input fields
        const fname = document.getElementById("fname").value;
        const mname = document.getElementById("mname").value;
        const lname = document.getElementById("lname").value;
        const address = document.getElementById("current_address").value;
        const phoneNumber = document.getElementById("cellphonenumber").value;
        const email = document.getElementById("email").value;

        // Concatenate the full name
        const fullName = `${fname} ${mname} ${lname}`;

        // Update the corresponding paragraph with the values
        document.getElementById("borrowerName").textContent = fullName;
        document.getElementById("borrowerAddress").textContent = address;
        document.getElementById("borrowerPhone").textContent = phoneNumber;
        document.getElementById("borrowerEmail").textContent = email;
    }

    // Add event listeners to input fields to trigger the update function
    document.getElementById("fname").addEventListener("input", updateBorrowerDetails);
    document.getElementById("mname").addEventListener("input", updateBorrowerDetails);
    document.getElementById("lname").addEventListener("input", updateBorrowerDetails);
    document.getElementById("current_address").addEventListener("input", updateBorrowerDetails);
    document.getElementById("cellphonenumber").addEventListener("input", updateBorrowerDetails);
    document.getElementById("email").addEventListener("input", updateBorrowerDetails);
</script>




<script>
// Function to preview the uploaded signature
document.getElementById('borrowerSignature').addEventListener('change', function(event) {
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('signaturePreview').src = e.target.result;
        document.getElementById('borrowerSignaturePreview').style.display = 'block';
    };
    reader.readAsDataURL(this.files[0]);
});

// Function to enable the 'I Accept' button when the checkbox is checked
function toggleAcceptButton() {
    var acceptBtn = document.getElementById('acceptBtn');
    var checkbox = document.getElementById('termsCheckbox');
    acceptBtn.disabled = !checkbox.checked;
}
</script>


<script>
    function toggleAcceptButton() {
        const termsCheckbox = document.getElementById('termsCheckbox');
        const acceptBtn = document.getElementById('acceptBtn');
        
        // Enable or disable the button based on checkbox state
        acceptBtn.disabled = !termsCheckbox.checked;
    }

    function confirmSubmission() {
        alert('Thank you for accepting the Terms and Conditions.');
        // Proceed with your submission logic here
        $('#termsandcon').modal('hide'); // Closes the modal if using Bootstrap
    }
</script>

<script>

function calculateDueDates() {
    const paymentMode = document.getElementById('modalPaymentMode').innerText; // Get payment mode
    const frequency = document.getElementById('modalFrequency').innerText; // Get frequency
    const dueDateString = document.getElementById('modalDueDate').innerText; // Get due date
    
    const totalAmount = parseFloat(document.getElementById('modalTotalAmount').innerText).toFixed(2); // Total amount

    const options = { year: 'numeric', month: 'short', day: 'numeric' }; // Date format
    const dueDate = new Date(dueDateString);


    let tableHTML = `
        <table class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Amount Due</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
    `;

    if (paymentMode === 'Lump Sum') {
        // For Lump Sum, only show the total amount and due date
        console.log('Parsed Due Date:', dueDate); // Log the parsed date
const formattedDate = dueDate.toLocaleDateString('en-US', {
  year: 'numeric',
  month: 'long',
  day: 'numeric',
});

// Set the value of the span
document.getElementById('dueDateText').textContent = formattedDate;
        tableHTML += `
            <tr>
                <td>${totalAmount}</td>
                <td>${dueDate.toLocaleDateString('en-US', options)}</td>
            </tr>
        `;
    } else {
       // For Installments, calculate next deadlines
       let nextDeadlines = [];

let today = new Date(); // Get today's date

if (frequency === 'Daily') {
    let minStartDate = new Date(today); // Start from today
    let lastDay = new Date(dueDate); // Ensure dueDate is a Date object
    lastDay.setDate(lastDay.getDate() + 1); // Add 1 extra day to the end date

    // Start the loop from today's date until the updated due date
    while (minStartDate <= lastDay) {
        nextDeadlines.push(new Date(minStartDate)); // Add the current date to the deadlines
        minStartDate.setDate(minStartDate.getDate() + 1); // Move to the next day
    }

    // Display the first date in the span with id="firstPaymentDate"
    if (nextDeadlines.length > 0) {
        document.getElementById('firstPaymentDate').textContent = nextDeadlines[1].toDateString(); // First deadline is the first date in the array
    }

    // Store the total count of dates in the span with id="numberOfPayments"
    document.getElementById('numberOfPayments').textContent = nextDeadlines.length - 1;

}



 else if (frequency === 'Weekly') {
    let today = new Date(); // Start from the current date
    while (today <= dueDate) {
        nextDeadlines.push(new Date(today));
        today.setDate(today.getDate() + 7); // Move to the next week
    }

    // Advance the final date by 1 additional week
    if (nextDeadlines.length > 0) {
        let lastDate = new Date(nextDeadlines[nextDeadlines.length - 1]);
        lastDate.setDate(lastDate.getDate() + 7);
        nextDeadlines.push(lastDate);
    }

    // Get the day of the week for the first payment date
    if (nextDeadlines.length > 0) {
        let firstPaymentDate = nextDeadlines[0];
        let dayOfWeek = firstPaymentDate.toLocaleString('en-US', { weekday: 'long' }); // Get the full weekday name (e.g., "Monday")
        
        // Set the day of the week in the span with id="dayOftheWeek"
        document.getElementById('dayOftheWeek').textContent = dayOfWeek;
    }

    if (nextDeadlines.length > 0) {
        document.getElementById('firstPaymentDate').textContent = nextDeadlines[1].toDateString(); // First deadline is the first date in the array
    }

    document.getElementById('numberOfPayments').textContent = nextDeadlines.length - 1;
}
else if (frequency === 'Monthly') {
    let today = new Date(); // Start from the current date
    while (today <= dueDate) {
        nextDeadlines.push(new Date(today));
        today.setMonth(today.getMonth() + 1); // Move to the next month
    }

    // Advance the final date by 1 additional month
    if (nextDeadlines.length > 0) {
        let lastDate = new Date(nextDeadlines[nextDeadlines.length - 1]);
        lastDate.setMonth(lastDate.getMonth() + 1);
        nextDeadlines.push(lastDate);
    }

    // Get the day of the month for the first payment date
    if (nextDeadlines.length > 0) {
        let firstPaymentDate = nextDeadlines[0];
        let dayOfMonth = firstPaymentDate.getDate(); // Get the day of the month (e.g., 15)

        // Set the day of the month in the span with id="dayOftheMonth"
        document.getElementById('dayOftheMonth').textContent = dayOfMonth;
    }

    if (nextDeadlines.length > 0) {
        document.getElementById('firstPaymentDate').textContent = nextDeadlines[1].toDateString(); // First deadline is the first date in the array
    }

    document.getElementById('numberOfPayments').textContent = nextDeadlines.length - 1;
}



if (nextDeadlines.length > 0) {
    nextDeadlines.shift();
}

        // Add rows for installments
        const installmentAmount = (totalAmount / nextDeadlines.length).toFixed(2); // Divide total into installments

        const totalInstallmentAmount = (installmentAmount * nextDeadlines.length).toFixed(2); // Multiply by the number of deadlines

// Insert the totalInstallmentAmount value into the HTML
    document.getElementById("installmentAmount").textContent = totalInstallmentAmount;
        nextDeadlines.forEach(date => {
            tableHTML += `
                <tr>
                    <td>${totalAmount}</td>
                    <td>${date.toLocaleDateString('en-US', options)}</td>
                </tr>
            `;
        });
    }

    tableHTML += `</tbody></table>`;
    document.getElementById('modalNextDeadlines').innerHTML = tableHTML;
}

// Call the function when the modal is shown
document.getElementById('summaryModal').addEventListener('show.bs.modal', calculateDueDates);
</script>






        </div>
            
            
            


                

                   
      
 
  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $(document).ready(function() {
    var current_fs, next_fs, previous_fs; // Fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function() {
        current_fs = $(this).closest('fieldset');  // Get the closest parent fieldset
        next_fs = current_fs.next('fieldset');  // Find the next fieldset

        if (next_fs.length > 0) {
            // Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            // Show the next fieldset
            next_fs.show();

            // Hide the current fieldset with animation
            current_fs.animate({ opacity: 0 }, {
                step: function(now) {
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({ 'opacity': opacity });
                },
                duration: 500
            });
            setProgressBar(++current);
        }
    });

    $(".previous").click(function() {
        current_fs = $(this).closest('fieldset');  // Get the closest parent fieldset
        previous_fs = current_fs.prev('fieldset');  // Find the previous fieldset

        if (previous_fs.length > 0) {
            // Remove Class Active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            // Show the previous fieldset
            previous_fs.show();

            // Hide the current fieldset with animation
            current_fs.animate({ opacity: 0 }, {
                step: function(now) {
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({ 'opacity': opacity });
                },
                duration: 500
            });
            setProgressBar(--current);
        }
    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width", percent + "%");
    }

    $(".submit").click(function() {
        return false;  // Prevent form submission for testing purposes
    });
});

    </script>

<script>
 document.addEventListener('DOMContentLoaded', function () {
    
    const paymentMode = document.getElementById('paymentMode');
    const frequencyContainer = document.getElementById('frequencyContainer');
    const paymentFrequency = document.getElementById('paymentFrequency');
    const dueDateInput = document.getElementById('dueDate');
    const dueDateOptions = document.getElementById('dueDateOptions');
    const durationContainer = document.getElementById('durationContainer');
    const principalInput = document.getElementById('loanAmount'); // Assuming this is where the loan amount is entered

    let totalAmountToBePaid = 0;

    paymentMode.addEventListener('change', function () {
        const mode = this.value;

        if (mode === 'Lump Sum') {
            setAllowedDates();
            frequencyContainer.style.display = 'none';
            durationContainer.style.display = 'none';
            dueDateInput.disabled = false;
        } else if (mode === 'Installment') {
            frequencyContainer.style.display = 'block';
            dueDateInput.disabled = true;
            durationContainer.style.display = 'none';
        }
    });

    setAllowedDates();

    paymentFrequency.addEventListener('change', function () {
        const frequency = this.value;

        if (frequency === 'Weekly' || frequency === 'Monthly') {
            durationContainer.style.display = 'block';
            dueDateInput.disabled = true;
            dueDateOptions.innerHTML = '';

            if (frequency === 'Weekly') {
                for (let i = 2; i <= 12; i++) {
                    dueDateOptions.innerHTML += `<option value="${i}">${i} Week${i > 1 ? 's' : ''}</option>`;
                }
            } else if (frequency === 'Monthly') {
                for (let i = 2; i <= 3; i++) {
                    dueDateOptions.innerHTML += `<option value="${i}">${i} Month${i > 1 ? 's' : ''}</option>`;
                }
            }
        } else {
            durationContainer.style.display = 'none';
            dueDateInput.disabled = false;
        }
    });

    function showSummaryModal() {
        const paymentModeValue = paymentMode.value;
        const frequencyValue = paymentFrequency.value;
        const dueDate = dueDateInput.value;
        const accountDetails = document.getElementById('accountDetails').value;
        const principal = parseFloat(principalInput.value);

        if (isNaN(principal) || principal <= 0) {
            alert("Please enter a valid loan amount.");
            return;
        }

        if (paymentModeValue === 'Installment') {
            if (!frequencyValue || (frequencyValue !== 'Daily' && dueDateOptions.value === '')) {
                alert("Please fill out all fields before submitting.");
                return;
            }
        } else if (!dueDate || !accountDetails) {
            alert("Please fill out all required fields before submitting.");
            return;
        }

        const currentDate = new Date();
        let selectedDueDate;

        if (frequencyValue === 'Weekly' || frequencyValue === 'Monthly') {
            const duration = parseInt(dueDateOptions.value);
            selectedDueDate = new Date(currentDate);

            if (frequencyValue === 'Weekly') {
                selectedDueDate.setDate(currentDate.getDate() + (duration * 7));
            } else if (frequencyValue === 'Monthly') {
                selectedDueDate.setMonth(currentDate.getMonth() + duration);
            }
        } else {
            selectedDueDate = new Date(dueDate);
        }

        const timeDifference = selectedDueDate.getTime() - currentDate.getTime();
        const noOfDays = Math.ceil(timeDifference / (1000 * 3600 * 24));

        if (noOfDays <= 0) {
            alert("Please select a future date for the due date.");
            return;
        }

        let interest = 0;

        if (paymentModeValue === 'Lump Sum') {
            const interestRatePerDay = 0.055 / 7;
            interest = interestRatePerDay * principal * noOfDays;
            totalAmountToBePaid = principal + interest;
        } else if (paymentModeValue === 'Installment') {
            if (frequencyValue === 'Daily') {
                const dailyInterestRate = 0.055 / 7;
                interest = dailyInterestRate * principal * noOfDays;
                totalAmountToBePaid = (interest + principal) / noOfDays;
            } else if (frequencyValue === 'Weekly') {
                const weeks = parseInt(dueDateOptions.value, 10);
                interest = 0.055 * principal * weeks;
                totalAmountToBePaid = (interest + principal) / weeks;
            } else if (frequencyValue === 'Monthly') {
                const months = parseInt(dueDateOptions.value, 10);
                interest = 0.055 * principal * 4 * months;
                totalAmountToBePaid = (interest + principal) / months;
            }
        }

        document.getElementById('modalPaymentMode').textContent = paymentModeValue;
        document.getElementById('modalFrequency').textContent = frequencyValue;
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('modalDueDate').textContent = selectedDueDate.toLocaleDateString('en-US', options);
        document.getElementById('modalAccountDetails').textContent = accountDetails;
        document.getElementById('modalTotalAmount').textContent = totalAmountToBePaid.toFixed(2);

        // Store interest in the blank within the paragraph
        document.getElementById('interestValue').textContent = interest.toFixed(2);

        const summaryModal = new bootstrap.Modal(document.getElementById('summaryModal'));
        summaryModal.show();
    }






    // Function to reset form fields
    function resetFields() {
        paymentMode.selectedIndex = 0; // Reset payment mode
        paymentFrequency.selectedIndex = 0; // Reset payment frequency
        dueDateInput.value = ""; // Clear due date
        accountDetails.value = ""; // Clear account details
        frequencyContainer.style.display = 'none'; // Hide payment frequency container
        durationContainer.style.display = 'none'; // Hide duration container
    }

    // Add event listener to the submit button
    document.querySelector('input[name="summary"]').addEventListener('click', showSummaryModal);

    // Add event listener to modal close buttons
    const modalElement = document.getElementById('summaryModal');
    modalElement.addEventListener('hidden.bs.modal', resetFields);

    // Function to set allowed dates
    function setAllowedDates() {
        const currentDate = new Date();
        const minDate = new Date(currentDate);
        const maxDate = new Date(currentDate);
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
     //ANDITO UNG CODE!!
        // Set minimum date to tomorrow
        minDate.setDate(minDate.getDate() + 5);

        // Set maximum date to 3 months from today
        maxDate.setMonth(maxDate.getMonth() + 3);

        dueDateInput.setAttribute('min', minDate.toISOString().split('T')[0]); // Set min attribute
        dueDateInput.setAttribute('max', maxDate.toISOString().split('T')[0]); // Set max attribute
    }
});


</script>

<script>
    
    document.addEventListener("DOMContentLoaded", function () {
        // Dropdown elements
        const paymentModeDropdown = document.getElementById("paymentMode");
        const paymentFrequencyDropdown = document.getElementById("paymentFrequency");
        const frequencyContainerDiv = document.getElementById("frequencyContainer");

        // Checkbox elements
        const singlePaymentCheckbox = document.getElementById("singlePayment");
        const dailyInstallmentsCheckbox = document.getElementById("dailyInstallments");
        const weeklyInstallmentsCheckbox = document.getElementById("weeklyInstallments");
        const monthlyInstallmentsCheckbox = document.getElementById("monthlyInstallments");

        // Handle payment mode selection
        paymentModeDropdown.addEventListener("change", function () {
            const selectedPaymentMode = paymentModeDropdown.value;

            if (selectedPaymentMode === "Lump Sum") {
                // Check "Single Payment" and reset others
                singlePaymentCheckbox.checked = true;
                dailyInstallmentsCheckbox.checked = false;
                weeklyInstallmentsCheckbox.checked = false;
                monthlyInstallmentsCheckbox.checked = false;

                // Hide the frequency container
                frequencyContainerDiv.style.display = "none";
            } else if (selectedPaymentMode === "Installment") {
                // Uncheck "Single Payment" and show frequency options
                singlePaymentCheckbox.checked = false;
                frequencyContainerDiv.style.display = "block";
            } else {
                // Reset all checkboxes and hide frequency container
                singlePaymentCheckbox.checked = false;
                dailyInstallmentsCheckbox.checked = false;
                weeklyInstallmentsCheckbox.checked = false;
                monthlyInstallmentsCheckbox.checked = false;

                frequencyContainerDiv.style.display = "none";
            }
        });

        // Handle payment frequency selection
        paymentFrequencyDropdown.addEventListener("change", function () {
            const selectedPaymentFrequency = paymentFrequencyDropdown.value;

            // Reset all frequency-related checkboxes
            dailyInstallmentsCheckbox.checked = false;
            weeklyInstallmentsCheckbox.checked = false;
            monthlyInstallmentsCheckbox.checked = false;

            if (selectedPaymentFrequency === "Daily") {
                dailyInstallmentsCheckbox.checked = true;
            } else if (selectedPaymentFrequency === "Weekly") {
                weeklyInstallmentsCheckbox.checked = true;
            } else if (selectedPaymentFrequency === "Monthly") {
                monthlyInstallmentsCheckbox.checked = true;
            }
        });
    });


</script>

    
<script>

    document.addEventListener("DOMContentLoaded", function() {
    // Get modal and fieldset elements
    const modalElement = document.getElementById('summaryModal');
    const paymentMode = document.getElementById('paymentMode');
    const paymentFrequency = document.getElementById('paymentFrequency');
    const dueDate = document.getElementById('dueDate');
    const accountDetails = document.getElementById('accountDetails');
    const frequencyContainer = document.getElementById('frequencyContainer');
    const durationContainer = document.getElementById('durationContainer');

    // Reset function to clear input fields
    function resetFields() {
        paymentMode.selectedIndex = 0; // Reset payment mode
        paymentFrequency.selectedIndex = 0; // Reset payment frequency
        dueDate.value = ""; // Clear due date
        accountDetails.value = ""; // Clear account details
        frequencyContainer.style.display = 'none'; // Hide payment frequency container
        durationContainer.style.display = 'none'; // Hide duration container
    }

    // Add event listener to modal close buttons
    modalElement.addEventListener('hidden.bs.modal', function () {
        resetFields();
    });
});

</script>

<script>
    function updateHiddenInputs() {
        // Get the values from the modal and assign them to the hidden fields
        document.getElementById('hiddenPaymentMode').value = document.getElementById('modalPaymentMode').innerText;
        document.getElementById('hiddenFrequency').value = document.getElementById('modalFrequency').innerText;
        document.getElementById('hiddenDueDate').value = document.getElementById('modalDueDate').innerText;
        document.getElementById('hiddenAccountDetails').value = document.getElementById('modalAccountDetails').innerText;
        document.getElementById('hiddenTotalAmount').value = document.getElementById('modalTotalAmount').innerText;
        document.getElementById('hiddenNextDeadlines').value = document.getElementById('modalNextDeadlines').innerText; // Add next deadlines
       
    }

    function submitForm() {
        // Update the hidden inputs before form submission
        updateHiddenInputs();

        // Show the terms and conditions modal
        $('#termsandcon').modal('show');
    }

    function updateNextDeadline() {
        var dueDate = document.getElementById("modalDueDate").innerText;
        var nextDeadline = document.getElementById("modalNextDeadlines").innerText;

        // If next_deadline is empty, copy the value of dueDate
        if (!nextDeadline.trim()) {
            document.getElementById("modalNextDeadlines").innerText = dueDate;
        }
    }

    // Add event listener to the modal for when it's shown
    document.getElementById('summaryModal').addEventListener('shown.bs.modal', function () {
        updateHiddenInputs();
        updateNextDeadline();
    });
</script>

<script>
    function confirmSubmission() {
        document.getElementById('msform').submit();
    }
    document.getElementById('refreshButton').addEventListener('click', function() {
  this.classList.add('refreshing');
  setTimeout(function() {
    // Reload the page after the animation completes
    window.location.reload();
  }, 400);  // Match the duration of the CSS animation
});

</script>


</body>

</html>