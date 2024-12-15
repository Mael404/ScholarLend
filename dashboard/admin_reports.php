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

        .modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #1a1a40;
}

.status-box {
    background-color: #d8b389;
    padding: 5px 10px;
    border-radius: 4px;
    display: inline-block;
    margin-left: 10px;
}

.section-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 20px;
    color: #1a1a40;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

.loan-info p, .payment-details p {
    margin-left: 20px;
    color: #333;
    font-weight: normal;
    font-size: 1rem;
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
    <a href="admindashboard.php" class="list-group-item  list-group-item-action">
        <i class="lnr lnr-home me-2"></i> Home
    </a>
    <?php
include'condb.php';

// SQL query to count 'pending' statuses in the loan-deadlines table
$sql = "SELECT COUNT(*) AS pending_count FROM borrower_info WHERE status = 'invested' OR status = 'pending'";

$result = $conn->query($sql);

// Fetch the count
$pending_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending_count = $row['pending_count'];
}

$conn->close();
?>

<a href="admin_applications.php" class="list-group-item position-relative">
    <i class="lnr lnr-file-empty me-2"></i>Applications
    <?php if ($pending_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $pending_count; ?></span>
    <?php endif; ?>
</a>
    <a href="admin_lenders.php" class="list-group-item">
        <i class="lnr lnr-briefcase me-2"></i>Lenders
    </a>
    <?php
include'condb.php';

// SQL query to count 'pending' statuses in the loan-deadlines table
$sql = "SELECT COUNT(*) AS pending_count FROM loan_deadlines WHERE status = 'pending'";
$result = $conn->query($sql);

// Fetch the count
$pending_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending_count = $row['pending_count'];
}

$conn->close();
?>

<a href="admin_borrowers.php" class="list-group-item position-relative">
    <i class="lnr lnr-users me-2"></i>Borrowers
    <?php if ($pending_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $pending_count; ?></span>
    <?php endif; ?>
</a>
    <a href="admin_loans.php" class="list-group-item ">
        <i class="lnr lnr-book me-2"></i>Loans
    </a>
    <?php
include 'condb.php';

// SQL query to count unread messages in the contactus table
$sql = "SELECT COUNT(*) AS unread_count FROM contactus WHERE status = 'unread'";

$result = $conn->query($sql);

// Fetch the count
$unread_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];
}

$conn->close();
?>

<a href="admin_messages.php" class="list-group-item position-relative">
    <i class="lnr lnr-file-empty me-2"></i>Messages
    <?php if ($unread_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $unread_count; ?></span>
    <?php endif; ?>
</a>

    <a href="admin_reports.php" class="list-group-item active">
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
      <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif;">Reports</h2>
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
include 'condb.php';

$sql = "SELECT transaction_id FROM borrower_info";
$result = $conn->query($sql);
?>
<?php
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

// Count total applicants
$sql_total = "SELECT COUNT(*) AS total_count FROM borrower_info";
$result_total = $conn->query($sql_total);
$total_applicants = $result_total->fetch_assoc()['total_count'];

// Count pending applicants
$sql_pending = "SELECT COUNT(*) AS pending_count FROM borrower_info WHERE status = 'Pending'";
$result_pending = $conn->query($sql_pending);
$pending_applicants = $result_pending->fetch_assoc()['pending_count'];

// Count approved applicants
$sql_approved = "SELECT COUNT(*) AS approved_count FROM borrower_info WHERE status = 'Approved'";
$result_approved = $conn->query($sql_approved);
$approved_applicants = $result_approved->fetch_assoc()['approved_count'];
?>
<div class="container mt-4">




<div class="row mt-5">
  <div class="col-12">
    <table id="applicantsTable" class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th scope="col" class="text-center">Transaction ID</th>
          <th scope="col" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Fetch applicants data
        $sql_applicants = "SELECT transaction_id, status FROM borrower_info";
        $result_applicants = $conn->query($sql_applicants);

        if ($result_applicants->num_rows > 0) {
          while ($row = $result_applicants->fetch_assoc()) {
            $transaction_id = htmlspecialchars($row['transaction_id']);
            $status = htmlspecialchars($row['status']);
            echo "<tr data-status='{$status}'>";
            echo "<td class='text-center'>{$transaction_id}</td>";
            echo "<td class='text-center'>
                    <button type='button' class='btn custom-btn' onclick='performAction({$transaction_id})' data-bs-toggle='modal' data-bs-target='#loanModal'>
                      View Details
                    </button>
                  </td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td class='text-center' colspan='2'>No applicants found</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>


<style>
  .active-card {
    background-color: #cdad7d !important; /* Active color */
    color: white !important;
  }
  
  table tbody tr:hover {
    background-color: #f0f8ff; /* Add hover effect for table rows */
  }
  .btn-secondary {
    background-color: brown;
    border: none;
  }
  .btn-secondary:hover {
    background-color: #964b00;
  }
  .custom-btn {
  background-color: #dbbf94; /* Button background color */
  color: #fff; /* Text color */
  border: none; /* Remove border */
}

.custom-btn:hover {
  background-color: #bda07b; /* Darker shade for hover effect */
  color: #fff; /* Maintain white text */
}


</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const totalCard = document.getElementById("totalLoansCard");
  const pendingCard = document.getElementById("pendingLoansCard");
  const completedCard = document.getElementById("completedLoansCard");
  const cards = [totalCard, pendingCard, completedCard];

  totalCard.addEventListener("click", function () {
    setActiveCard(totalCard);
    filterTable("all");
  });

  pendingCard.addEventListener("click", function () {
    setActiveCard(pendingCard);
    filterTable("Pending");
  });

  completedCard.addEventListener("click", function () {
    setActiveCard(completedCard);
    filterTable("Approved");
  });

  function setActiveCard(selectedCard) {
    // Remove active class from all cards
    cards.forEach(card => card.classList.remove("active-card"));
    // Add active class to the selected card
    selectedCard.classList.add("active-card");
  }

  function filterTable(status) {
    const rows = document.querySelectorAll("#applicantsTable tbody tr");

    rows.forEach(row => {
      const rowStatus = row.getAttribute("data-status");

      if (status === "all" || rowStatus === status) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }
});
</script>


<!-- Loan Details Modal -->
<div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="loanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loanModalLabel">Loan ID <span id="modalLoanId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>STATUS:</strong> <span id="modalStatus" class="status-box"></span></p>
                
                <h6 class="section-titles">Basic Loan Information</h6>
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Name of Borrower / ID:</th>
                            <td><span id="modalBorrowerName"></span></td>
                        </tr>
                        <tr>
                            <th>Loan Amount:</th>
                            <td><span id="modalLoanAmount"></span></td>
                        </tr>
                        <tr>
                            <th>Mode of Payment:</th>
                            <td><span id="modalPaymentMode"></span></td>
                        </tr>
                        <tr>
                            <th>Name of Lender:</th>
                            <td><span id="modalLenderName"></span></td>
                        </tr>
                        <tr>
                            <th>Date Funded:</th>
                            <td><span id="modalDateFunded"></span></td>
                        </tr>
                        <tr>
                            <th>Total Interest:</th>
                            <td><span id="modalTotalInterest"></span></td>
                        </tr>
                        <tr>
                            <th>Share of Lender:</th>
                            <td><span id="modalShareLender"></span></td>
                        </tr>
                        <tr>
                            <th>Share of Admin every payment:</th>
                            <td><span id="modalShareAdmin"></span></td>
                        </tr>
                        <tr>
                            <th>Transaction Fee:</th>
                            <td><span id="modalTransactionFee"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>
function performAction(transactionId) {
    // Make an AJAX call to fetch loan details based on transactionId
    fetch(`get_loan_details.php?transaction_id=${transactionId}`)
        .then(response => response.json())
        .then(data => {
            // Populate the modal fields with data
            document.getElementById('modalLoanId').textContent = data.transaction_id;
            document.getElementById('modalStatus').textContent = data.status;
            document.getElementById('modalBorrowerName').textContent = data.fname;
            document.getElementById('modalLoanAmount').textContent = data.loan_amount;
            document.getElementById('modalPaymentMode').textContent = data.payment_mode;
            document.getElementById('modalLenderName').textContent = data.lender_name;

            // Format the date
            const date = new Date(data.created_at);
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = date.toLocaleDateString('en-US', options);
            document.getElementById('modalDateFunded').textContent = formattedDate;

            // Populate other fields
            document.getElementById('modalTotalInterest').textContent = data.interest_earned;
            document.getElementById('modalShareLender').textContent = data.share_lender;
            document.getElementById('modalShareAdmin').textContent = data.share_admin;
            document.getElementById('modalTransactionFee').textContent = '15';
            document.getElementById('modalDeadlines').textContent = data.next_deadlines;
        })
        .catch(error => console.error('Error fetching loan details:', error));
}
</script>




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