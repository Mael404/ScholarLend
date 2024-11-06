<?php
session_start();
// Database connection
include 'display_user_wallet.php';
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "scholarlend_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data where status is 'Pending'
$sql = "SELECT fname, mname, lname, transaction_id, status, created_at FROM borrower_info";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
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
    background-color: #caac82; /* Set the background color for active item */
    color: rgb(255, 255, 255); /* Set the text color for active item */
    font-weight: bold; /* Make the text bold for active item */
    border-radius: 8px; /* Keep the rounded corners */
    border: none; /* Remove any border if necessary */
}

    .list-group-item:hover {
        background-color: #caac82; /* Set background color on hover */
        color: white; 
     
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
    border-radius: 15px;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
   
}

.modal-header {
    border-bottom: none;
    background-color: #f8f9fa;
    padding: 20px;
}

.modal-title {
    font-weight: bold;
    color: #333;
}

.section-title {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #555;
}

.info-item {
    margin-bottom: 8px;
    line-height: 1.5;
    font-size: 0.9em;
}

.image-uploads img {
    max-width: 100%;
    height: auto;
    border: 2px solid #007bff;
    border-radius: 8px;
}

.btn-secondary {
    background-color: #007bff;
    border: none;
    color: white;
}

.btn-secondary:hover {
    background-color: #0056b3;
}

.section-title {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #fff; /* White text for better contrast */
    background-color: #ccac82; /* Background color */
    border-radius: 9px; /* Rounded corners */
    padding: 8px 12px; /* Padding for better spacing */
    display: inline-block; /* To make the background wrap around the text */
}
/* card tab */
.card {
      background-color: #f8f9fa;
      border-radius: 10px;
    }

    .nav-tabs .nav-link.active {
      background-color: #f8f9fa;
      border-color: #f8f9fa;
      font-weight: bold;
    }

    h5 {
      font-weight: bold;
    }

    p {
      margin-bottom: 0.5rem;
    }

    .tab-content {
      border: 1px solid #e9ecef;
      border-top: none;
      background-color: #fff;
      padding: 1rem;
      border-radius: 0 0 10px 10px;
    }
    .navbar {
            background-color: #f9f7f3;
            height: 8vh;
            padding: 0.5rem 1rem;
        }
        .navbar-brand span {
            font-weight: bold;
            color: #c29c6d; /* Scholar color */
        }
        .navbar-brand .logo-text {
            color: #2c2e45; /* Lend color */
        }
        .navbar-text {
            color: #2c2e45;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex primary-text fs-1 fw-bold" href="#" style="font-family: 'Times New Roman', Times, serif; margin-left:60px;">
            <span>Scholar</span><span class="logo-text">Lend</span>
        </a>
        <div class="d-none d-lg-block">
            <span class="navbar-text" style="font-family: 'Times New Roman', Times, serif; font-weight:bolder; font-size:larger;">Administrator</span>
        </div>
    </div>
</nav>

    <div class="d-flex" id="wrapper">
        
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            
                  
            <div class="user-info d-flex align-items-center my-4 text-center">
        

                <img src="red.jpg" alt="User Profile Picture" class="img-fluid rounded-circle" style="width: 50px; height: 50px; margin-right: 10px;">
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

                            <div class="list-group list-group-flush my-3">
    <a href="admindashboard.php" class="list-group-item list-group-item-action">
        <i class="lnr lnr-home me-2"></i> Home
    </a>
    <a href="admin_applications.php" class="list-group-item ">
        <i class="lnr lnr-file-empty me-2"></i>Applications
    </a>
    <a href="admin_lenders.php" class="list-group-item">
        <i class="lnr lnr-briefcase me-2"></i>Lenders
    </a>
    <a href="admin_borrowers.php" class="list-group-item active">
        <i class="lnr lnr-users me-2"></i>Borrowers
    </a>
    <a href="admin_loans.php" class="list-group-item">
        <i class="lnr lnr-book me-2"></i>Loans
    </a>
    <a href="admin_messages.php" class="list-group-item">
        <i class="lnr lnr-envelope me-2"></i>Messages
    </a>
    <a href="admin_reports.php" class="list-group-item">
        <i class="lnr lnr-chart-bars me-2"></i>Reports
    </a>
    <a href="admin_settings.php" class="list-group-item">
        <i class="lnr lnr-cog me-2"></i>Settings
    </a>
    <a href="/butterfly/index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="lnr lnr-power-switch me-2"></i>Logout
    </a>
</div>

            
            
        </div>     
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
    <div class="d-flex align-items-center">
      <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
      <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif;">Borrowers</h2>
    </div>

    
    <a class="nav-link wallet-link second-text fw-bold ms-auto" href="#">
    <i class="fas fa-wallet me-2"></i>Balance: 
    <span class="wallet-balance">PHP <?php echo number_format($wallet_balance, 2); ?></span>
</a>
    
  </nav>
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
</style>
<?php
// Database connection
include 'condb.php';


$sql = "
SELECT 
    u.user_id,
    u.first_name,
    u.middle_name,
    u.last_name,
    u.email,
    u.wallet_balance,
    COALESCE(SUM(CASE WHEN b.status != 'pending' THEN b.outstanding_balance ELSE 0 END), 0) AS total_outstanding_balance,
    COALESCE(SUM(CASE WHEN b.status != 'pending' THEN b.loan_amount ELSE 0 END), 0) AS total_amount_lent,
    COALESCE(COUNT(CASE WHEN b.status != 'pending' THEN b.user_id END), 0) AS loans_made
FROM 
    users_tb u
LEFT JOIN 
    borrower_info b ON u.user_id = b.user_id
WHERE 
    u.account_role = 'Borrower'
GROUP BY 
    u.user_id
";

$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . htmlspecialchars($conn->error));
}
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card p-4 text-center" style="background-color:#f4f1ec;">
                <h5 class="fw-bold" style="text-align: left; font-family:'Times New Roman', Times, serif; font-weight:bold; font-size: 2.0rem;">Lender Overview</h5>
                <div class="d-flex justify-content-around mt-3">
                    <div>
                        <h2 class="fw-bold mb-0">20</h2>
                        <small class="text-uppercase">Total Borrowers</small>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">23</h2>
                        <small class="text-uppercase">Total Number of Loans Funded</small>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">₱13000</h2>
                        <small class="text-uppercase">Total Amount of Funded Loans</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row mt-5">

<div class="table-responsive">
    <table id="lendersTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">User ID</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $user_id = htmlspecialchars($row['user_id']);
                    $fname = htmlspecialchars($row['first_name']);
                    $lname = htmlspecialchars($row['last_name']);
                    $email = htmlspecialchars($row['email']);
                    $total_loaned = number_format((float)$row['total_amount_lent'], 2);
                    $loans_made = intval($row['loans_made']);

                    // Query the loan_deadlines table to check if user_id exists with Pending status
                    $sql = "SELECT * FROM loan_deadlines WHERE user_id = '$user_id' AND status = 'Pending' LIMIT 1";
                    $result_deadline = $conn->query($sql);

                    if ($result_deadline->num_rows > 0) {
                        $deadline_row = $result_deadline->fetch_assoc();
                        $deadline_date = $deadline_row['deadline']; // Date from loan_deadlines
                        $status = $deadline_row['status']; // Status from loan_deadlines
                        $transaction_amount = number_format((float)$deadline_row['amount'], 2); // Correct column: 'amount'

                        // Prepare the transaction details for Pending status
                        $transaction_date = $deadline_date; // Use the deadline date as transaction date
                        $transaction_type = 'Payment'; // Default transaction type
                        $transaction_status = $status; // Status from loan_deadlines table
                    } else {
                        // If no Pending loan deadlines, set default values or skip
                        $transaction_date = null;
                        $transaction_type = null;
                        $transaction_amount = null;
                        $transaction_status = null;
                    }

                    echo "<tr>";
                    echo "<td class='text-center'>{$user_id}</td>";
                    echo "<td class='text-center'>
                            <button type='button' class='btn btn-link text-primary' data-bs-toggle='modal' data-bs-target='#profileModal{$user_id}' style='font-size: 0.9em;'>See Profile</button>
                          </td>";
                    echo "</tr>";

                    // Profile Modal for each user
                    echo "
                    <div class='modal fade' id='profileModal{$user_id}' tabindex='-1' aria-labelledby='profileModalLabel{$user_id}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='profileModalLabel{$user_id}'>User Profile: {$fname} {$lname}</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    <h6>Personal Information</h6>
                                    <p>First Name: {$fname}</p>
                                    <p>Last Name: {$lname}</p>
                                    <p>Email: {$email}</p>

                                    <h6>Funding Management</h6>
                                    <div class='card p-3' style='background-color: #f4e4c3; border-radius: 8px; border: none;'>
                                        <h5 class='fw-bold'>Lending Insights</h5>
                                        <div class='d-flex justify-content-between align-items-center'>
                                            <div>
                                                <p class='mb-1' style='font-size: 0.9em; color: #999999;'>TOTAL AMOUNT LOANED</p>
                                                <p class='fw-bold' style='color: #d3a569; font-size: 1.5em;'>₱{$total_loaned}</p>
                                            </div>
                                            <div>
                                                <p class='mb-1' style='font-size: 0.9em; color: #999999;'>LOANS MADE</p>
                                                <p class='fw-bold' style='color: #000000; font-size: 1.5em;'>{$loans_made}</p>
                                            </div>
                                            <button class='btn' style='background-color: #1b1b1b; color: #ffffff; border-radius: 5px;' data-bs-toggle='modal' data-bs-target='#loansModal' data-userid='{$user_id}'>View Loans</button>
                                        </div>
                                    </div>

                                    <div class='card p-3 mt-3' style='background-color: #eeead6; border-radius: 8px; border: none;'>
                                        <h5 class='fw-bold'>Credit Transactions</h5>";

                                        // If there is a pending loan deadline, populate the transaction card
                                        if ($transaction_date && $transaction_type && $transaction_amount && $transaction_status) {
                                            echo "
                                            <div class='p-3 mb-3 d-flex justify-content-between align-items-center' style='background-color: #eeead6; border-radius: 8px;'>
                                                <div>
                                                    <p class='mb-1' style='font-size: 0.9em; color: #999999;'>DATE</p>
                                                    <p class='fw-bold'>{$transaction_date}</p>
                                                </div>
                                                <div>
                                                    <p class='mb-1' style='font-size: 0.9em; color: #999999;'>TRANSACTION</p>
                                                    <p class='fw-bold'>{$transaction_type}</p>
                                                </div>
                                                <div>
                                                    <p class='mb-1' style='font-size: 0.9em; color: #999999;'>AMOUNT</p>
                                                    <p class='fw-bold' style='color: #d3a569;'>₱{$transaction_amount}</p>
                                                </div>
                                                <div>
                                                    <p class='mb-1' style='font-size: 0.9em; color: #999999;'>STATUS</p>
                                                    <p class='fw-bold' style='color: #28a745;'>{$transaction_status}</p>
                                                </div>
                                                <div>
                                                    <button class='btn btn-link text-primary' style='font-size: 0.9em;'>Transfer to Lender</button>
                                                </div>
                                            </div>";
                                        }
                                        
                                    echo "</div>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>




</div>


<!-- Loans Modal -->
<div class="modal fade" id="loansModal" tabindex="-1" aria-labelledby="loansModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loansModalLabel">Loans Made</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead style="background-color: #f4f1ec; text-align:center;">
                        <tr>
                            <th>Date</th>
                            <th>Loan ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="loanTableBody">
                        <!-- Loan data will be populated here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap JS 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    
   




</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    // Attach event listener to all buttons that open the loans modal
    const loanButtons = document.querySelectorAll('[data-bs-target="#loansModal"]');
    
    loanButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-userid');
            
            // Load loans specific to this user when the button is clicked
            loadLoans(userId);
        });
    });
});

// Function to load loans data via AJAX
function loadLoans(userId) {
    console.log("Loading loans for user ID: " + userId);

    $.ajax({
        url: 'viewloanborrower.php', // Your server-side script to fetch loans
        type: 'GET',
        data: { user_id: userId },
        success: function(response) {
            // Populate the loans table in the modal with response data
            document.getElementById('loanTableBody').innerHTML = response;
        },
        error: function() {
            alert('Error loading loans');
        }
    });
}
</script>



    <script>  

        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $(document).ready(function() {
        $('#lendersTable').DataTable({
            "paging": false,
            "searching": true,
            "info": false,
            "ordering": false
        });
    });

    function viewProfile(userId) {
    document.getElementById('profileModalLabel').innerText = 'Lender ' + userId;
    var profileModal = new bootstrap.Modal(document.getElementById('profileModal'));
    profileModal.show();
}

    </script>


</body>

</html>