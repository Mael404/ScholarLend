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

        .uniform-button {
    width: 150px; /* Adjust this value to fit your layout */
    font-size: 0.9em; /* Keep the same font size for all buttons */
    padding: 0.4rem 1rem; /* Consistent padding */
}
.active-card {
    background-color: #cdad7d; /* Brown color */
    color: white;
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

          
        
            <?php include 'sidebar.php'; ?>

            
            
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
$sql_approved = "SELECT COUNT(*) AS approved_count FROM borrower_info WHERE status = 'Approved'";
$result_approved = $conn->query($sql_approved);
$approved_applicants = $result_approved->fetch_assoc()['approved_count'];


?>

<!-- Total Applicants Card -->
<div id="totalApplicantsCard" class="col-md-4">
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
<div id="pendingApplicantsCard" class="col-md-4">
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
<div id="approvedApplicantsCard" class="col-md-4">
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

                // Status column with "Approved" changed to "Invested"
                $status = isset($row['status']) ? htmlspecialchars($row['status']) : '';
                if ($status === 'Approved') {
                    $status = 'Fund Transferred';
                }
                echo "<td class='text-center'>" . $status . "</td>";

                // Action column with conditional buttons
                echo "<td class='text-center'>
                    <button type='button' class='btn btn-link text-primary' style='font-size: 0.9em;' data-bs-toggle='modal' data-bs-target='#borrowerModal' data-id='" . htmlspecialchars($row['transaction_id']) . "'>
                        <i class='fas fa-eye'></i>
                    </button>";

                // Display Confirm button if status is "Pending"
                if ($status === 'Pending') {
                    echo "
                    <button type='button' class='btn btn-outline-success mx-1 uniform-button' onclick='checkApplicant(" . htmlspecialchars($row['transaction_id']) . ")'>
                        <i class='fas fa-check'></i> Confirm
                    </button>";
                }
                
                // Display Transfer Funds button if status is "Invested"
                elseif ($status === 'Invested') {
                    echo "
                    <button type='button' class='btn btn-outline-primary mx-1 uniform-button' onclick='transferFunds(" . htmlspecialchars($row['transaction_id']) . ")'>
                        <i class='fas fa-exchange-alt'></i> Transfer Funds
                    </button>";
                }
                
                // Display disabled button if status is "Completed" or "Posted"
                elseif ($status === 'Completed') {
                    echo "
                    <button type='button' class='btn btn-secondary mx-1 uniform-button' disabled>
                        <i class='fas fa-check'></i> Loan Settled 
                    </button>";
                }  
                elseif ($status === 'Fund Transferred') {
                    echo "
                    <button type='button' class='btn btn-secondary mx-1 uniform-button' disabled>
                        <i class='fas fa-check'></i> Funded
                    </button>";
                } 
                elseif ($status === 'Posted') {
                    echo "
                    <button type='button' class='btn btn-secondary mx-1 uniform-button' disabled>
                        <i class='fas fa-check'></i> Approved
                    </button>";
                }    
                

                echo "</td>";
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
                    <h5 class="modal-title fw-bold">Application <span id="modal-application-id"></span></h5>
                   
                   <!-- Alert with link to open the modal -->
                   <div class="alert alert-success py-2 px-3 mt-2 d-flex justify-content-between" style="background-color: #4CAF50; color: white;">
    <span>Credit Scoring: Green zone</span>
    <a href="#" class="text-white" id="viewCreditScoring" style="text-decoration: none;">
    View Credit Scoring <i class="fas fa-angle-right"></i>
</a>

</div>

<div id="creditScoringTable" style="display: none; margin-top: 20px;">
<table class="table table-bordered mb-0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f3e8d6;">
            <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Category</th>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Sub-category</th>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Data Collected</th>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Weight</th>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Score</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle;">Educational Background</td>
            <td style="padding: 8px; border: 1px solid #ddd;">Year of Study</td>
            <td id="modal-yearofstudy_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">7</td>
            <td id="yearsofstudyScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">GWA</td>
            <td id="modal-gwa_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">8</td>
            <td id="gwaScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td rowspan="3" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle;">Financial Information</td>
            <td style="padding: 8px; border: 1px solid #ddd;">Monthly Allowance</td>
            <td id="modal-monthly-allowance_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">20</td>
            <td id="monthlyAllowanceScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Source of Allowance</td>
            <td id="modal-source-of-allowance_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">10</td>
            <td id="sourceOfAllowanceScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <!-- Added Expenses Sub-category under Financial Information -->
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Expenses</td>
            <td id="modal-expenses_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">20</td>
            <td id="expensesScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td rowspan="3" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle;">Alternative Data Points</td>
            <td style="padding: 8px; border: 1px solid #ddd;">Affiliated Organization</td>
            <td id="modal-affiliated-organization_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">5</td>
            <td id="affiliatedOrganizationScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Spending Pattern</td>
            <td id="modal-spending-pattern_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">10</td>
            <td id="spendingPatternScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Saving Behavior</td>
            <td id="modal-savings-behavior_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">10</td>
            <td id="savingsBehaviorScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td rowspan="2" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle;">Loan Purpose and Repayment Plan</td>
            <td style="padding: 8px; border: 1px solid #ddd;">Loan Purpose</td>
            <td id="modal-loan-purpose_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">10</td>
            <td id="loanPurposeScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;">Loan Amount</td>
            <td id="modal-loan-amount_credit" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
            <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">10</td>
            <td id="loanAmountScore" style="padding: 8px; border: 1px solid #ddd; text-align: center;"></td>
        </tr>
        <tr style="background-color: #f3e8d6;">
            <td colspan="3" style="padding: 8px; border: 1px solid #ddd; text-align: right;"><strong>TOTAL</strong></td>
            <td id="modal-credit-score" style="padding: 8px; border: 1px solid #ddd; text-align: center;"><strong>100</strong></td>
            <td id="modal-credit-category" style="padding: 8px; border: 1px solid #ddd; text-align: center;"><strong>100</strong></td>
        </tr>
    </tbody>
</table>






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
function transferFunds(borrowerId) {
    if (confirm('Are you sure you want to Transfer Funds to this borrower?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'transfer_funds.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Funds transferred successfully!');
                location.reload(); // Refresh the page to reflect changes
            }
        };
        xhr.send('id=' + borrowerId);
    }
}

</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
  const totalCard = document.querySelector("#totalApplicantsCard .card");
  const pendingCard = document.querySelector("#pendingApplicantsCard .card");
  const approvedCard = document.querySelector("#approvedApplicantsCard .card");
  const cards = [totalCard, pendingCard, approvedCard]; // Array of all card elements

  totalCard.addEventListener("click", function () {
    setActiveCard(totalCard);
    filterTable("all");
  });

  pendingCard.addEventListener("click", function () {
    setActiveCard(pendingCard);
    filterTable("Pending");
  });

  approvedCard.addEventListener("click", function () {
    setActiveCard(approvedCard);
    filterTable("Invested");
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
      const statusCell = row.querySelector("td:nth-child(4)").innerText.trim();

      if (status === "all" || statusCell === status) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }
});


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

                // Populate educational information for credit scoring table
document.getElementById('modal-yearofstudy_credit').textContent = data.yearofstudy;
document.getElementById('modal-gwa_credit').textContent = data.gwa;
document.getElementById('modal-monthly-allowance_credit').textContent = '₱' + data.monthly_allowance;
document.getElementById('modal-source-of-allowance_credit').textContent = data.source_of_allowance;
document.getElementById('modal-expenses_credit').textContent = data.monthly_expenses;
document.getElementById('modal-affiliated-organization_credit').textContent = data.school_community;
document.getElementById('modal-spending-pattern_credit').textContent = data.spending_pattern;
document.getElementById('modal-savings-behavior_credit').textContent = data.monthly_savings;

// For the loan purpose leave it blank for now
document.getElementById('modal-loan-amount_credit').textContent = '₱' + data.loan_amount;
// Populate loan purpose
document.getElementById('modal-loan-purpose_credit').textContent = data.loan_purpose || 'N/A'; // Default to 'N/A' if not available

document.getElementById('modal-credit-score').textContent = data.credit_score;
document.getElementById('modal-credit-category').textContent = data.credit_category;

// Example of how to set scores
document.getElementById('yearsofstudyScore').textContent = data.yearsofstudy_score; // from PHP data
document.getElementById('gwaScore').textContent = data.gwa_score;
document.getElementById('monthlyAllowanceScore').textContent = data.monthly_allowance_score;
document.getElementById('sourceOfAllowanceScore').textContent = data.source_of_allowance_score;
document.getElementById('affiliatedOrganizationScore').textContent = data.school_community_score;
document.getElementById('spendingPatternScore').textContent = data.spending_pattern_score;
document.getElementById('savingsBehaviorScore').textContent = data.monthly_savings_score;
document.getElementById('loanPurposeScore').textContent = data.loan_purpose_score;
document.getElementById('loanAmountScore').textContent = data.loan_amount_score;
document.getElementById('expensesScore').textContent = data.expense_score;


            }
        };
        xhr.send();
    });
});
</script>




</script>

<script>
    // Variable to store the transaction ID
    let currentTransactionId;

    // Event listener for when the modal is shown
    var borrowerModal = document.getElementById('borrowerModal');
    borrowerModal.addEventListener('show.bs.modal', function (event) {
        // Get the button that triggered the modal
        var button = event.relatedTarget; // Button that triggered the modal

        // Extract info from data-* attributes
        currentTransactionId = button.getAttribute('data-id'); // Store the transactionId

        // Update the modal's content
        var modalTitle = borrowerModal.querySelector('.modal-title #modal-application-id');
        modalTitle.textContent = currentTransactionId;

        // Optional: Fetch more data based on transactionId here if needed
        // For example, you could make an AJAX request to get additional details
    });

    // Event listener for the "View Credit Scoring" link
    $(document).ready(function() {
        $('#viewCreditScoring').on('click', function(e) {
          
                document.getElementById('viewCreditScoring').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default anchor click behavior
        const table = document.getElementById('creditScoringTable');
        table.style.display = table.style.display === 'none' ? 'block' : 'none'; // Toggle visibility
    });

            // Log the current transaction ID
            console.log("Credit Scoring ID:", currentTransactionId);
            
            // Here you can add logic to populate the credit scoring table
            // For example, make an AJAX call to fetch data and populate the table
            $('#creditScoringTable').show(); // Show the table
        });
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