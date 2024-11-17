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
        padding: 14px 18px; /* Adjust padding for hover effect */
        transform: scale(1.05); /* Scale up */
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
    <a href="borrower_applicationform.php" class="list-group-item list-group-item-action">
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

<a href="borrower_messages.php" class="list-group-item position-relative " style="z-index: 1;">
    <i class="fas fa-envelope me-2"></i>Messages
    <?php if ($unread_count > 0): ?>
        <span class="badge bg-danger position-absolute top-2 end-0 translate-middle rounded-pill" style="z-index: 2;"><?php echo $unread_count; ?></span>
    <?php endif; ?>
</a>


   
    <a href="borrower_transactions.php" class="list-group-item active">
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

// Initialize variables
$total_loaned = 0;
$loans_made = 0;

// Query to calculate total loans made (completed status)
$sql_loans_made = "SELECT COUNT(*) AS loans_made 
                   FROM borrower_info 
                   WHERE user_id = ? AND status = 'Completed'";
$stmt = $conn->prepare($sql_loans_made);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $loans_made = $row['loans_made'];
}
$stmt->close();

// Query to calculate total loaned amount (exclude pending)
$sql_total_loaned = "SELECT SUM(loan_amount) AS total_loaned 
                     FROM borrower_info 
                     WHERE user_id = ? AND status != 'Pending'";
$stmt = $conn->prepare($sql_total_loaned);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $total_loaned = $row['total_loaned'] ?? 0; // Default to 0 if null
}
$stmt->close();

// Fetch transaction history
$sql_transactions = "SELECT transaction_id, loan_amount, created_at, status 
                     FROM borrower_info 
                     WHERE user_id = ?";
$stmt = $conn->prepare($sql_transactions);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$transactions = $stmt->get_result();
?>


<!-- HTML Code to Display Messages -->
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                    Transaction History
                </h2>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- PHP-generated card -->
        <div class="card p-4 text-left" style=" background-color: #f4e4c3; border-radius: 8px; border: none; height: 250px;">
            <h5 class="fw-bold" style="font-family:'Times New Roman', Times, serif; font-size:40px;">Lending Insights</h5>
            <div class="d-flex justify-content-between align-items-center h-100">
                <div>
                    <p class="mb-1" style="font-size: 1em; color: #999999;">TOTAL AMOUNT LOANED</p>
                    <p class="fw-bold" style="color: #d3a569; font-size: 2em;">₱<?php echo number_format($total_loaned, 2); ?></p>
                </div>
                <div style="flex: 1; text-align: center;">
                    <p class="mb-1" style="font-size: 1em; color: #999999;">LOANS MADE</p>
                    <p class="fw-bold" style="color: #000000; font-size: 2.5em;"><?php echo $loans_made; ?></p>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive mt-5">
            <table id="applicantsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Loan Amount</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($transactions->num_rows > 0): ?>
                        <?php while ($row = $transactions->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['transaction_id']); ?></td>
                                <td>₱<?php echo number_format($row['loan_amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars(date('F j, Y', strtotime($row['created_at']))); ?></td>

                                <td>
    <?php 
    echo htmlspecialchars($row['status']) === "Completed" ? "Completed" : "Ongoing"; 
    ?>
</td>

                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


            
            


    
                   
      
<!-- Script Dependencies (Correct order) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  <!-- Latest jQuery -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>  <!-- DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>  <!-- Bootstrap JS -->
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>  <!-- DataTables Bootstrap JS -->





</body>

</html>