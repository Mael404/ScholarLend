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

.modal-content {
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 2px solid #f0f0f0;
}

.table thead th {
    font-size: 14px;
    text-transform: uppercase;
    color: #6c757d;
}

.table tbody td {
    vertical-align: middle;
}

.table-borderless tbody tr td {
    border-top: none;
}

#repayment_schedule .btn {
    background-color: #0056b3;
    color: #fff;
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 4px;
}

#repayment_schedule .btn:hover {
    background-color: #004a99;
}
.loan-info {
    display: inline-block; /* Centers the list horizontally */
    margin: 0 auto; /* Ensures horizontal centering */
}

.loan-info li {
    display: flex; /* Creates a flexible row layout for each item */
    justify-content: space-between; /* Aligns label and value on opposite sides */
    margin-bottom: 10px; /* Adds space between items */
    width: 400px; /* Keeps the width consistent */
}

.loan-info li strong {
    flex-basis: 50%; /* Ensures all labels occupy the same width */
    text-align: left; /* Aligns labels to the left */
}

.loan-info li span {
    flex-basis: 50%; /* Ensures all values occupy the same width */
    text-align: right; /* Aligns values to the right */
}
.loan-info li strong {
    text-decoration: underline; /* Adds underline to the label text */
    margin-right: 10px; /* Adds spacing between the label and the value */
}

.loan-info span {
    display: inline-block; /* Ensures proper alignment */
    margin-left: 20px; /* Adds left margin to align the values */
}
.loan-info {
    display: inline-block; /* Make the <ul> element inline-block for centering */
    text-align: left; /* Ensure the content inside aligns properly */
    margin: 0 auto; /* Center the <ul> horizontally */
    list-style: none; /* Remove bullets if not already done */
}

.loan-info li {
    text-align: left; /* Align the labels and values inside each list item */
}

.loan-info li strong {
    text-decoration: underline; /* Adds underline to the label text */
    margin-right: 10px; /* Adds spacing between the label and the value */
}

.loan-info span {
    display: inline-block; /* Ensures proper alignment */
    margin-left: 20px; /* Adds left margin to align the values */
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

<!-- Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="transactionModalLabel">Loan Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loan Information Section -->
                <div class="mb-4">
                    <h5 class="fw-bold">Loan-<span id="loan_id"></span> Information</h5>
                    <div class="text-center"> <!-- Wrap the <ul> inside a text-center container -->
    <ul class="list-unstyled loan-info">
        <li><strong>LOAN AMOUNT:</strong> <span id="loan_amount"></span></li>
        <li><strong>TERMS:</strong> <span id="loan_terms"></span></li>
        <li><strong>DATE RELEASED:</strong> <span id="date_released"></span></li>
        <li><strong>DATE APPLIED:</strong> <span id="date_applied"></span></li>
        <li><strong>STATUS:</strong> <span id="loan_status"></span></li>
    </ul>
</div>
                </div>
                <hr>
                <!-- Repayment Schedule Section -->
                <div>
                    <h5 class="fw-bold mb-3">Loan-<span id="loan_id_2"></span> Repayment Schedule</h5>
                    <p class="text-muted">Repayments begin in <strong><span id="repayment_start"></span></strong></p>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="repayment_schedule">
                                <!-- JavaScript will populate this dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>


            
            


    
                   
      
<!-- Script Dependencies (Correct order) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  <!-- Latest jQuery -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>  <!-- DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>  <!-- Bootstrap JS -->
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>  <!-- DataTables Bootstrap JS -->



<script>
document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll("#applicantsTable tbody tr");

    rows.forEach(function (row) {
        row.addEventListener("click", function () {
            const transactionId = row.cells[0].innerText; // Assuming transaction ID is in the first column

            // Fetch loan data (already existing logic)
            fetch(`fetch_loan_data.php?transaction_id=${transactionId}`)
                .then((response) => response.json())
                .then((data) => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Populate loan information (existing logic)
                    document.getElementById("loan_id").innerText = transactionId;
                    document.getElementById("loan_amount").innerText = `₱${parseFloat(data.loan_amount).toFixed(2)}`;
                    document.getElementById("loan_terms").innerText = data.terms;
                    document.getElementById("date_released").innerText = new Date(data.date_released).toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
});

document.getElementById("date_applied").innerText = new Date(data.date_applied).toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
});

                    document.getElementById("loan_status").innerText = data.status;

                    // Populate repayment schedule
                    fetch(`fetch_loan_schedule.php?transaction_id=${transactionId}`)
                        .then((response) => response.json())
                        .then((scheduleData) => {
                            if (scheduleData.error) {
                                alert(scheduleData.error);
                                return;
                            }

                            const scheduleTable = document.getElementById("repayment_schedule");
                            scheduleTable.innerHTML = ""; // Clear existing rows

                            // Populate rows
                            scheduleData.forEach((item) => {
    // Function to format a date or return "N/A" if invalid
    const formatDate = (date) => {
        const parsedDate = new Date(date);
        return isNaN(parsedDate) ? "N/A" : parsedDate.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric',
        });
    };

    const deadline = formatDate(item.deadline); // Format or default to "N/A"
    const paymentDate = item.payment_date ? formatDate(item.payment_date) : "Not Yet Paid";

    const row = `
        <tr>
            <td>${deadline}</td>
            <td>₱${parseFloat(item.amount).toFixed(2)}</td>
            <td>${paymentDate}</td>
            <td>${item.status}</td>
        </tr>
    `;
    scheduleTable.innerHTML += row;
});

                        })
                        .catch((error) => {
                            console.error("Error fetching repayment schedule:", error);
                            alert("An error occurred while fetching repayment schedule.");
                        });

                    // Show the modal
                    new bootstrap.Modal(document.getElementById("transactionModal")).show();
                })
                .catch((error) => {
                    console.error("Error fetching loan data:", error);
                    alert("An error occurred while fetching loan data.");
                });
        });
    });
});



</script>


</body>

</html>