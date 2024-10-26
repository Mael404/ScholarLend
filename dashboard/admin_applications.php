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
                <a href="admin_applications.php" class="list-group-item active">
                    <i class="fas fa-folder-open me-2"></i>Applications
                </a>
                <a href="#" class="list-group-item">
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
      <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif;">Applications</h2>
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
  <div class="container mt-4">
    <div class="row">
    <?php

// Database connection
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

// Count total applicants
$sql_total = "SELECT COUNT(*) AS total_count FROM borrower_info";
$result_total = $conn->query($sql_total);
$total_applicants = $result_total->fetch_assoc()['total_count'];

// Count pending applicants
$sql_pending = "SELECT COUNT(*) AS pending_count FROM borrower_info WHERE status = 'Pending'";
$result_pending = $conn->query($sql_pending);
$pending_applicants = $result_pending->fetch_assoc()['pending_count'];

// Count approved applicants
$sql_approved = "SELECT COUNT(*) AS approved_count FROM borrower_info WHERE status = 'Posted'";
$result_approved = $conn->query($sql_approved);
$approved_applicants = $result_approved->fetch_assoc()['approved_count'];


?>

<!-- Total Applicants Card -->
<div class="col-md-4">
  <div class="card text-center rounded">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-center">
        <i class="fas fa-users fa-2x me-3"></i>
        <h5 class="card-title">Total Applicants</h5>
      </div>
      <p class="card-text fs-4"><?php echo $total_applicants; ?></p>
    </div>
  </div>
</div>

<!-- Pending Applicants Card -->
<div class="col-md-4">
  <div class="card text-center rounded">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-center">
        <i class="fas fa-hourglass-half fa-2x me-3"></i>
        <h5 class="card-title">Pending</h5>
      </div>
      <p class="card-text fs-4"><?php echo $pending_applicants; ?></p>
    </div>
  </div>
</div>

<!-- Approved Applicants Card -->
<div class="col-md-4">
  <div class="card text-center rounded">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-center">
        <i class="fas fa-check fa-2x me-3"></i>
        <h5 class="card-title">Approved</h5>
      </div>
      <p class="card-text fs-4"><?php echo $approved_applicants; ?></p>
    </div>
  </div>
</div>

</div>
   
     <!-- Data Table Section -->
     <div class="mt-4">
     <div class="table-responsive">
   
     <table id="applicantsTable" class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th scope="col" class="text-center">Created On</th>
            <th scope="col" class="text-center">Application ID</th>
            <th scope="col" class="text-center">Customer Name</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";

                // Created On (Application Date) column
                echo "<td class='text-center'>" . (isset($row['created_at']) ? date("F j, Y", strtotime($row['created_at'])) : '') . "</td>";


                // Application ID (Transaction ID) column
                echo "<td class='text-center'>" . htmlspecialchars($row['transaction_id']) . "</td>";

                // Customer Name (Full Name) column
                $fullName = trim(
                    (isset($row['fname']) ? $row['fname'] : '') . ' ' . 
                    (isset($row['mname']) ? $row['mname'] : '') . ' ' . 
                    (isset($row['lname']) ? $row['lname'] : '')
                );
                $fullName = ucwords(strtolower($fullName));
                echo "<td class='text-center'>" . htmlspecialchars($fullName) . "</td>";

                // Status column
                echo "<td class='text-center'>" . (isset($row['status']) ? htmlspecialchars($row['status']) : '') . "</td>";

                // Action column
                echo "<td class='text-center'>
                    <button type='button' class='btn btn-link text-primary' style='font-size: 0.9em;' data-bs-toggle='modal' data-bs-target='#borrowerModal' data-id='" . htmlspecialchars($row['transaction_id']) . "'>
                        <i class='fas fa-eye'></i>
                    </button>
                    <button type='button' class='btn btn-outline-success mx-1' style='font-size: 0.9em; padding: 0.2rem 0.4rem;' onclick='checkApplicant(" . htmlspecialchars($row['transaction_id']) . ")'>
                        <i class='fas fa-check'></i>
                    </button>
                    <button type='button' class='btn btn-outline-danger' style='font-size: 0.9em; padding: 0.2rem 0.4rem;' onclick='deleteApplicant(" . htmlspecialchars($row['transaction_id']) . ")'>
                        <i class='fas fa-trash'></i>
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

  
  <div class="modal fade" id="borrowerModal" tabindex="-1" aria-labelledby="borrowerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3">
                    <h5 class="modal-title fw-bold">Application <span id="modal-application-id">082202</span></h5>
                    <div class="alert alert-success py-2 px-3 mt-2 d-flex justify-content-between" style="background-color: #4CAF50; color: white;">
    <span>Credit Scoring: Green zone</span>
    <a href="#" class="text-white" style="text-decoration: none;">
        View Credit Scoring <i class="fas fa-angle-right"></i>
    </a>
</div>




                </div>
                <div class="card p-3 mb-3" style="background-color: #f4f1ec;">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">Borrower</p>
                            <h5 class="font-weight-bold" id="modal-borrower-name">[Name]</h5>
                            <p id="modal-borrower-phone">[Phone]</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0">Requested</p>
                            <h5 class="font-weight-bold" id="modal-loan-amount">₱[Loan Amount]</h5>
                            <p id="modal-loan-duration">[Duration]</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0">Total Interest</p>
                            <h5 class="font-weight-bold" id="modal-total-interest">₱[Interest]</h5>
                            <p id="modal-interest-duration">[Duration]</p>
                        </div>
                    </div>
                </div>

                <!-- Tabs for different sections -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personal-info">Personal Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#educational-info">Educational Background</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#financial-info">Financial & Other Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#attachments">Attachments</a>
                    </li>
                </ul>

                <div class="tab-content p-3">
                    <div id="personal-info" class="tab-pane fade show active">
                        <h5>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>First Name:</strong> <span id="modal-fname">[First Name]</span></p>
                                <p><strong>Middle Name:</strong> <span id="modal-mname">[Middle Name]</span></p>
                                <p><strong>Last Name:</strong> <span id="modal-lname">[Last Name]</span></p>
                                <p><strong>Birth Date:</strong> <span id="modal-birthdate">[Birth Date]</span></p>
                                <p><strong>Gender:</strong> <span id="modal-gender">[Gender]</span></p>
                                <p><strong>Phone/Cellphone Number:</strong> <span id="modal-cellphonenumber">[Phone]</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> <span id="modal-email">[Email]</span></p>
                                <p><strong>Current Address:</strong> <span id="modal-current-address">[Current Address]</span></p>
                                <p><strong>Permanent Address:</strong> <span id="modal-permanent-address">[Permanent Address]</span></p>
                            </div>
                        </div>
                    </div>
                    <div id="educational-info" class="tab-pane fade">
    <h5>Educational Background</h5>
    <div class="row">
        <div class="col-md-6">
            <p><strong>School/University:</strong> <span id="modal-school">Bicol University</span></p>
            <p><strong>College:</strong> <span id="modal-college">CBEM</span></p>
            <p><strong>Program:</strong> <span id="modal-course">Accountancy</span></p>
        </div>
        <div class="col-md-6">
            <p><strong>Year of Study:</strong> <span id="modal-yearofstudy">Senior</span></p>
            <p><strong>Expected Graduation Date:</strong> <span id="modal-graduationdate">2025</span></p>
            <p><strong>GWA:</strong> <span id="modal-gwa">2.40</span></p>
        </div>
    </div>
</div>


<div id="financial-info" class="tab-pane fade">
    <h5>Financial & Other Information</h5>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Monthly Allowance:</strong> <span id="modal-monthly-allowance">₱[Monthly Allowance]</span></p>
            <p><strong>Source of Allowance:</strong> <span id="modal-source-of-allowance">[Source]</span></p>
            <p><strong>Monthly Expenses:</strong> <span id="modal-monthly-expenses">₱[Expenses]</span></p>
            <p><strong>Affiliated Organization:</strong> <span id="modal-affiliated-organization">[Organization]</span></p>
            <p><strong>Spending Pattern:</strong> <span id="modal-spending-pattern">[Pattern]</span></p>
            <p><strong>Savings Behavior:</strong> <span id="modal-savings-behavior">[Behavior]</span></p>
        </div>
        <div class="col-md-6">
            <p><strong>Career Goals and Plans:</strong></p>
            <p id="modal-career-goals">[Career Goals]</p>
        </div>
    </div>
</div>



<div id="attachments" class="tab-pane fade">
    <h5>Attachments</h5>
    <div class="row">
        <div class="col-md-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('modal-cor1')">
                <img id="modal-cor1" src="path/to/image1.jpg" alt="Attachment 1" class="img-fluid mb-2" />
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('modal-cor2')">
                <img id="modal-cor2" src="path/to/image2.jpg" alt="Attachment 2" class="img-fluid mb-2" />
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('modal-cor3')">
                <img id="modal-cor3" src="path/to/image3.jpg" alt="Attachment 3" class="img-fluid mb-2" />
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('modal-cor4')">
                <img id="modal-cor4" src="path/to/image4.jpg" alt="Attachment 4" class="img-fluid mb-2" />
            </a>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="imageModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="#" alt="Attachment Preview" class="img-fluid" />
            </div>
        </div>
    </div>
</div>

<script>
    function showImage(imageId) {
        const imageElement = document.getElementById(imageId);
        const modalImage = document.getElementById("modalImage");
        
        // Set the modal image src to the clicked image src
        modalImage.src = imageElement.src;

        // Load the image and adjust modal size based on natural dimensions
        modalImage.onload = function() {
            const naturalWidth = modalImage.naturalWidth;
            const naturalHeight = modalImage.naturalHeight;
            const maxWidth = window.innerWidth * 0.9; // Limit modal width to 90% of viewport width
            const maxHeight = window.innerHeight * 0.9; // Limit modal height to 90% of viewport height
            
            const width = Math.min(naturalWidth, maxWidth);
            const height = Math.min(naturalHeight, maxHeight);

            const modalDialog = document.getElementById("imageModalDialog");
            modalDialog.style.width = width + "px";
            modalDialog.style.height = height + "px";
        };
    }
</script>


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
    
   
<script>
    function checkApplicant(borrowerId) {
    if (confirm('Are you sure you want to approve this borrower?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Status updated successfully!');
                location.reload(); // Refresh the page to reflect changes
            }
        };
        xhr.send('id=' + borrowerId + '&status=Posted');
    }
}

</script>


<<script>
document.addEventListener('DOMContentLoaded', function () {
    var borrowerModal = document.getElementById('borrowerModal');

    borrowerModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-id');

        // Use AJAX to fetch the data
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'view_borrower.php?transaction_id=' + userId, true);
        xhr.onload = function () {
            if (this.status == 200) {
                var data = JSON.parse(this.responseText);

                // Populate the modal fields with fetched data
                document.getElementById('modal-borrower-name').textContent = data.fname + ' ' + data.lname;
                document.getElementById('modal-borrower-phone').textContent = data.cellphonenumber;
                document.getElementById('modal-loan-amount').textContent = '₱' + data.loan_amount;
                document.getElementById('modal-total-interest').textContent = '₱' + data.interest_earned;

                // Determine the correct duration labels based on payment frequency
                var paymentFrequency = data.payment_frequency;
                var loanDurationLabel = '';
                var interestDurationLabel = '';

                if (paymentFrequency === 'Daily') {
                    loanDurationLabel = data.days_to_next_deadline + ' Days';
                    interestDurationLabel = data.days_to_next_deadline + ' Days';
                } else if (paymentFrequency === 'Weekly') {
                    loanDurationLabel = data.days_to_next_deadline + ' Weeks';
                    interestDurationLabel = data.days_to_next_deadline + ' Weeks';
                } else if (paymentFrequency === 'Monthly') {
                    loanDurationLabel = data.days_to_next_deadline + ' Months';
                    interestDurationLabel = data.days_to_next_deadline + ' Months';
                } else {
                    loanDurationLabel = data.days_to_next_deadline + ' Lump Sum'; // Fallback for unexpected values
                }

                // Populate loan and interest duration
                document.getElementById('modal-loan-duration').textContent = loanDurationLabel;
                document.getElementById('modal-interest-duration').textContent = interestDurationLabel;

                // Personal Information
                document.getElementById('modal-fname').textContent = data.fname;
                document.getElementById('modal-mname').textContent = data.mname;
                document.getElementById('modal-lname').textContent = data.lname;
                document.getElementById('modal-birthdate').textContent = data.birthdate;
                document.getElementById('modal-gender').textContent = data.gender;
                document.getElementById('modal-cellphonenumber').textContent = data.cellphonenumber;
                document.getElementById('modal-email').textContent = data.email;
                document.getElementById('modal-current-address').textContent = data.current_address;
                document.getElementById('modal-permanent-address').textContent = data.permanent_address;

                // Populate educational information
                document.getElementById('modal-school').textContent = data.school;
                document.getElementById('modal-college').textContent = data.college;
                document.getElementById('modal-course').textContent = data.course;
                document.getElementById('modal-yearofstudy').textContent = data.yearofstudy;
                document.getElementById('modal-graduationdate').textContent = data.graduationdate;
                document.getElementById('modal-gwa').textContent = data.gwa;

                // Financial & Other Information
                document.getElementById('modal-monthly-allowance').textContent = '₱' + data.monthly_allowance;
                document.getElementById('modal-source-of-allowance').textContent = data.source_of_allowance;
                document.getElementById('modal-monthly-expenses').textContent = '₱' + data.monthly_expenses;
                document.getElementById('modal-affiliated-organization').textContent = data.school_community;
                document.getElementById('modal-spending-pattern').textContent = data.spending_pattern;
                document.getElementById('modal-savings-behavior').textContent = data.monthly_savings;
                document.getElementById('modal-career-goals').textContent = data.career_goals;

                // Set the image sources
                document.getElementById('modal-cor1').src = data.cor1_path || '#';
                document.getElementById('modal-cor2').src = data.cor2_path || '#';
                document.getElementById('modal-cor3').src = data.cor3_path || '#';
                document.getElementById('modal-cor4').src = data.cor4_path || '#';
            }
        };
        xhr.send();
    });
});
</script>




</script>

<script>
    // Event listener for when the modal is shown
    var borrowerModal = document.getElementById('borrowerModal');
    borrowerModal.addEventListener('show.bs.modal', function (event) {
        // Get the button that triggered the modal
        var button = event.relatedTarget; // Button that triggered the modal

        // Extract info from data-* attributes
        var transactionId = button.getAttribute('data-id');

        // Update the modal's content
        var modalTitle = borrowerModal.querySelector('.modal-title #modal-application-id');
        modalTitle.textContent = transactionId;

        // Optional: Fetch more data based on transactionId here if needed
        // For example, you could make an AJAX request to get additional details
    });
</script>




    <script>  

        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $(document).ready(function() {
        $('#applicantsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,
            

        });
    });
    </script>


</body>

</html>