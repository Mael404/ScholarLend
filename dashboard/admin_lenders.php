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

    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-1 fw-bold border-bottom" style="font-family: 'Times New Roman', Times, serif;">
                <i class=""></i>
                <span style="color: #caac82;">Scholar</span><span style="color: black;">Lend</span>
            </div>
                  
            <div class="user-info d-flex align-items-center my-3 text-center">
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
                <a href="admindashboard.php" class="list-group-item list-group-item-action ">
                    <i class="fas fa-home me-2"></i>Home
                </a>
                <a href="admin_applications.php" class="list-group-item ">
                    <i class="fas fa-folder-open me-2"></i>Applications
                </a>
                <a href="#" class="list-group-item active">
                    <i class="fas fa-hand-holding-usd me-2"></i>Lenders
                </a>
                <a href="#" class="list-group-item">
                    <i class="fas fa-users me-2"></i>Borrowers
                </a>
                <a href="#" class="list-group-item">
                    <i class="fas fa-file-alt me-2"></i>Loans
                </a>
                <a href="#" class="list-group-item">
                    <i class="fas fa-envelope me-2"></i>Messages
                </a>
                <a href="#" class="list-group-item">
                    <i class="fas fa-chart-line me-2"></i>Reports
                </a>
                <a href="#" class="list-group-item">
                    <i class="fas fa-cog me-2"></i>Settings
                </a>
                <a href="#" class="list-group-item list-group-item-action text-danger fw-bold">
                    <i class="fas fa-power-off me-2"></i>Logout
                </a>
            </div>
            
            
        </div>     
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
    <div class="d-flex align-items-center">
      <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
      <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif;">Lenders</h2>
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
$conn = new mysqli("localhost", "username", "password", "scholarlend_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch lenders' information
$sql = "SELECT user_id FROM users_tb WHERE account_role = 'Lender'";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card p-4 text-center" style="background-color:#f4f1ec;">
                <h5 class="fw-bold" style="text-align: left; font-family:'Times New Roman', Times, serif; font-weight:bold; font-size: 2.0rem;">Lender Overview</h5>
                <div class="d-flex justify-content-around mt-3">
                    <div>
                        <h2 class="fw-bold mb-0">20</h2>
                        <small class="text-uppercase">Total Lenders</small>
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

    <!-- Lenders Table -->
    <div class="row mt-5">
        <div class="col-12">
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
                            echo "<tr>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['user_id']) . "</td>";
                            echo "<td class='text-center'>
                                    <button type='button' class='btn btn-link text-primary' style='font-size: 0.9em;' onclick='viewProfile(\"" . htmlspecialchars($row['user_id']) . "\")'>
                                        See Profile
                                    </button>
                                  </td>";
                            echo "</tr>";
                            
                        }
                    } 
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Personal Information</h6>
                <p>First Name</p>
                <p>Middle Name</p>
                <p>Last Name</p>
                <p>Email</p>
                <p>Current Address</p>
                <p>Permanent Address</p>

                <h6>Funding Management</h6>
<div class="card my-3 p-3" style="background-color: #f7f3e9; border-radius: 8px; border: none;">
    <h5 class="fw-bold">Account Overview</h5>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="mb-1" style="font-size: 0.9em; color: #999999;">AVAILABLE CREDIT</p>
            <p class="fw-bold" style="color: #d3a569; font-size: 1.5em;">₱0</p>
        </div>
        <div>
            <p class="mb-1" style="font-size: 0.9em; color: #999999;">OUTSTANDING LOANS</p>
            <p class="fw-bold" style="color: #888888; font-size: 1.5em;">₱0</p>
        </div>
        <button class="btn" style="background-color: #d3a569; color: #ffffff; border-radius: 5px;">View Credit Transactions</button>
    </div>
</div>

<div class="card p-3" style="background-color: #f4e4c3; border-radius: 8px; border: none;">
    <h5 class="fw-bold">Lending Insights</h5>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="mb-1" style="font-size: 0.9em; color: #999999;">TOTAL AMOUNT LOANED</p>
            <p class="fw-bold" style="color: #d3a569; font-size: 1.5em;">₱0</p>
        </div>
        <div>
            <p class="mb-1" style="font-size: 0.9em; color: #999999;">LOANS MADE</p>
            <p class="fw-bold" style="color: #000000; font-size: 1.5em;">0</p>
        </div>
        <button class="btn" style="background-color: #2f2f47; color: #ffffff; border-radius: 5px;">View Loans</button>
    </div>
</div>

            </div>
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