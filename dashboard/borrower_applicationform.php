<?php
session_start(); // Start session to access session variables

include 'check_application.php';

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
            <br>
        
            <div class="list-group list-group-flush my-3">
    <a href="admindashboard.php" class="list-group-item list-group-item-action active">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </a>
    <a href="#" class="list-group-item">
        <i class="fas fa-envelope me-2"></i>Messages
    </a>
    <a href="#" class="list-group-item">
        <i class="fas fa-plus-circle me-2"></i>Add Credit
    </a>
    <a href="#" class="list-group-item">
        <i class="fas fa-minus-circle me-2"></i>Withdraw Credit
    </a>
    <a href="#" class="list-group-item">
        <i class="fas fa-exchange-alt me-2"></i>Transactions
    </a>
    <a href="#" class="list-group-item">
        <i class="fas fa-cog me-2"></i>Settings
    </a>
    <a href="#" class="list-group-item">
        <i class="fas fa-address-book me-2"></i>Contact Us
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
                    <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">ONLINE APPLICATION FORM</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Example User
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-9 text-center p-0 mt-3 mb-2">
                        <div class="card px-0 pt-0 pb-0 mt-3 mb-3">
                       
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

// Check if the query returned any rows
$has_pending_application = $result_pending->num_rows > 0;

// Query to check if the user has an approved application
$sql_approved = "SELECT * FROM borrower_info WHERE user_id = ? AND status = 'approved'";
$stmt_approved = $conn->prepare($sql_approved);
$stmt_approved->bind_param("i", $user_id);
$stmt_approved->execute();
$result_approved = $stmt_approved->get_result();

// Fetch approved application details if exists
$approved_application = $result_approved->fetch_assoc();

// Close the statements
$stmt_pending->close();
$stmt_approved->close();
$conn->close();

// If the user has a pending application, show the message
if ($has_pending_application) {
    echo "<p>Your application is pending.</p>";
} elseif ($approved_application) {
    // If there is an approved application, show the details
    $due_date = $approved_application['due_date'];
    $next_deadlines = $approved_application['next_deadlines']; // Get the raw value
    $total_amount = $approved_application['total_amount'];

    // Convert the comma-separated string to an array
    $next_deadlines_array = array_map('trim', explode(',', $next_deadlines));

    // Display the first deadline
    $first_deadline = !empty($next_deadlines_array) ? $next_deadlines_array[0] : 'No deadlines available';

    // Header with new background color and black text
    echo '<div style="background-color: #dbbf94; border-radius: 9px 9px 0 0; padding: 10px; margin: 20px 0; color: black; font-family: Arial, sans-serif; text-align: center;">';
    echo '<h5 style="font-weight: bolder;">LOAN APPROVED:</h5>'; 
    echo 'Your loan application is approved. Message us if you have not received the proceeds.'; 
    echo '</div>';

   
    echo '<div style="background-color: #f4f1ec; border-radius: 0 0 9px 9px; padding: 20px; margin: 0; color: #333; font-family: Arial, sans-serif;">';
    echo "<p>Due Date: <strong>$due_date</strong></p>";
    echo "<p>First Deadline: <strong>$first_deadline</strong></p>";
    echo "<p>Total Amount: <strong>$total_amount</strong></p>";

    
    echo '<form action="remove_deadline.php" method="POST" style="display: inline;">'; 
    echo '<input type="hidden" name="user_id" value="' . $user_id . '">'; 
    echo '<input type="hidden" name="deadline" value="' . htmlspecialchars($first_deadline) . '">'; 
    echo '<button type="submit" style="background-color: #131e3d; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-top: 10px; cursor: pointer;">Pay Now</button>';
    echo '</form>';

    echo '</div>';
} else {

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
                                                    <input type="text" class="form-control form-control-sm" id="yearofstudy" name="yearofstudy" placeholder="Year of Study" style="font-size: 0.9rem;" required>
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
                                                        <option value="1000">Below $1000</option>
                                                        <option value="3000">$1000 - $3000</option>
                                                        <option value="5000">$3000 - $5000</option>
                                                        <option value="10000">Above $5000</option>
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
                                                        <option value="family">Family</option>
                                                        <option value="scholarship">Scholarship</option>
                                                        <option value="parttime">Part-time Job</option>
                                                        <option value="others">Others</option>
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
                                                        <option value="1000">Below $1000</option>
                                                        <option value="3000">$1000 - $3000</option>
                                                        <option value="5000">$3000 - $5000</option>
                                                        <option value="8000">Above $5000</option>
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
            <select class="form-select" id="school_community" name="school_community" required>
                <option value="" disabled selected>Are you a member of any school community or organization?</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <label for="school_community">School Community/Organization Membership</label>
        </div>
    </div>
</div>

                                
                                        <!-- Select Spending Pattern -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="spending-pattern" name="spending-pattern" required>
                                                        <option value="" disabled selected>Select Spending Pattern</option>
                                                        <option value="frugal">Frugal</option>
                                                        <option value="moderate">Moderate</option>
                                                        <option value="extravagant">Extravagant</option>
                                                    </select>
                                                    <label for="spending-pattern">Select Spending Pattern</label>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Monthly Savings -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="monthly-savings" name="monthly-savings" required>
                                                        <option value="" disabled selected>Select How Much You Save in a Month</option>
                                                        <option value="0">None</option>
                                                        <option value="500">Below $500</option>
                                                        <option value="1000">$500 - $1000</option>
                                                        <option value="1000">Above $1000</option>
                                                    </select>
                                                    <label for="monthly-savings">Monthly Savings</label>
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
                    </select>
                    <label for="loanAmount">Loan Amount</label>
                </div>
            </div>
        </div>

                            
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-sm" id="loanPurpose" name="loan_purpose" placeholder="Loan Purpose" required>
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
                                                    <label for="cor2">Certificate of Registration (COR)</label>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="file" class="form-control form-control-sm" id="cor3" name="cor3" accept="application/pdf,image/*" required style="padding: 25px;">
                                                    <label for="cor3">Certificate of Registration (COR)</label>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="file" class="form-control form-control-sm" id="cor4" name="cor4" accept="application/pdf,image/*" required style="padding: 25px;">
                                                    <label for="cor4">Certificate of Registration (COR)</label>
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
            <label for="accountDetails">Account Details</label>
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
  <input type="hidden" id="hiddenTotalInterest" name="total_interest"> <!-- Add this line -->



                                
                            </form>

                            <?php
}
?>


                            
                        </div>
                    </div>
                </div>
            </div>

     <!-- Bootstrap Modal -->
     <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryModalLabel">Payment Summary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
    <p><strong>Payment Mode:</strong> <span id="modalPaymentMode"></span></p>
    <p><strong>Frequency:</strong> <span id="modalFrequency"></span></p>
    <p><strong>Selected Due Date:</strong> <span id="modalDueDate"></span></p>
    <p><strong>Next Deadlines:</strong> <span id="modalNextDeadlines"></span></p>
    <p><strong>Account Details:</strong> <span id="modalAccountDetails"></span></p>
    <p><strong>Total Amount to be Paid:</strong> <span id="modalTotalAmount"></span></p>
    <p><strong>Total Interest Earned:</strong> <span id="modalTotalInterest"></span></p> <!-- New line for interest -->
</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="submitForm()">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// Example function to calculate due dates
function calculateDueDates() {
    const frequency = document.getElementById('modalFrequency').innerText;
    const dueDateString = document.getElementById('modalDueDate').innerText;
    
    const dueDate = new Date(dueDateString);
    let today = new Date(); // Create a date object for today
    
    // Advance both the start and end dates
    if (frequency === 'Daily') {
        today.setDate(today.getDate() + 1); // Advance start date by 1 day
        dueDate.setDate(dueDate.getDate() + 1); // Advance end date by 1 day
    } else if (frequency === 'Weekly') {
        today.setDate(today.getDate() + 7); // Advance start date by 1 week
        dueDate.setDate(dueDate.getDate() + 7); // Advance end date by 1 week
    } else if (frequency === 'Monthly') {
        today.setMonth(today.getMonth() + 1); // Advance start date by 1 month
        dueDate.setMonth(dueDate.getMonth() + 1); // Advance end date by 1 month
    }

    let nextDeadlines = [];

    // Calculate next due dates based on frequency
    if (frequency === 'Daily') {
        while (today <= dueDate) {
            nextDeadlines.push(today.toLocaleDateString()); // Add today's date
            today.setDate(today.getDate() + 1); // Move to the next day
        }
    } else if (frequency === 'Weekly') {
        while (today <= dueDate) {
            nextDeadlines.push(today.toLocaleDateString()); // Add today's date
            today.setDate(today.getDate() + 7); // Move to the next week
        }
    } else if (frequency === 'Monthly') {
        while (today <= dueDate) {
            nextDeadlines.push(today.toLocaleDateString()); // Add today's date
            today.setMonth(today.getMonth() + 1); // Move to the next month
        }
    }

    // Update the modal with the calculated deadlines
    document.getElementById('modalNextDeadlines').innerText = nextDeadlines.join(', ');
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
    const dueDateOptions = document.getElementById('dueDateOptions'); // Dropdown for weeks/months
    const durationContainer = document.getElementById('durationContainer'); // Container for duration dropdown
    const principalInput = document.getElementById('loanAmount'); // Assuming this is where the loan amount is entered

    let totalAmountToBePaid = 0; // Keep track of the total amount

    // Add event listener to the payment mode select element
    paymentMode.addEventListener('change', function () {
        const mode = this.value;

        if (mode === 'Lump Sum') {
            setAllowedDates(); // Enable and set the due date for Lump Sum
            frequencyContainer.style.display = 'none'; // Hide frequency selection
            durationContainer.style.display = 'none'; // Hide duration selection
            dueDateInput.disabled = false; // Enable due date input
        } else if (mode === 'Installment') {
            frequencyContainer.style.display = 'block'; // Show frequency selection
            dueDateInput.disabled = true; // Disable the due date input for Installment
            durationContainer.style.display = 'none'; // Hide duration initially until frequency is selected
        }
    });

    // Call to set the allowed dates when the document loads
    setAllowedDates(); // By default, set the allowed dates

    // Event listener for payment frequency selection
    paymentFrequency.addEventListener('change', function () {
        const frequency = this.value;

        if (frequency === 'Weekly' || frequency === 'Monthly') {
            durationContainer.style.display = 'block'; // Show duration dropdown
            dueDateInput.disabled = true; // Disable due date input
            dueDateOptions.innerHTML = ''; // Clear previous options
            
            // Populate options based on the frequency
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
            durationContainer.style.display = 'none'; // Hide duration selection
            dueDateInput.disabled = false; // Enable due date input for Lump Sum or Daily frequency
        }
    });

    // Function to handle submission and showing the modal
    function showSummaryModal() {
    const paymentModeValue = paymentMode.value;
    const frequencyValue = paymentFrequency.value;
    const dueDate = dueDateInput.value; // This will be empty for Installments
    const accountDetails = document.getElementById('accountDetails').value;
    const principal = parseFloat(principalInput.value);

    if (isNaN(principal) || principal <= 0) {
        alert("Please enter a valid loan amount.");
        return;
    }

    // Validation for Installment payment
    if (paymentModeValue === 'Installment') {
        if (!frequencyValue || (frequencyValue !== 'Daily' && dueDateOptions.value === '')) {
            alert("Please fill out all fields before submitting.");
            return;
        }
    } else if (!dueDate || !accountDetails) {
        alert("Please fill out all required fields before submitting.");
        return;
    }

    // Calculate the number of days between today and the due date
    const currentDate = new Date();
    let selectedDueDate;

    // Compute the due date based on the frequency and selected duration
    if (frequencyValue === 'Weekly' || frequencyValue === 'Monthly') {
        const duration = parseInt(dueDateOptions.value);
        selectedDueDate = new Date(currentDate);

        if (frequencyValue === 'Weekly') {
            selectedDueDate.setDate(currentDate.getDate() + (duration * 7)); // Add weeks
        } else if (frequencyValue === 'Monthly') {
            selectedDueDate.setMonth(currentDate.getMonth() + duration); // Add months
        }
    } else {
        selectedDueDate = new Date(dueDate); // For Lump Sum and Daily, use the input date
    }

    const timeDifference = selectedDueDate.getTime() - currentDate.getTime();
    const noOfDays = Math.ceil(timeDifference / (1000 * 3600 * 24)); // Convert milliseconds to days

    if (noOfDays <= 0) {
        alert("Please select a future date for the due date.");
        return;
    }

    let interest = 0; // Initialize interest variable

    // Calculate total amount based on the payment mode
    if (paymentModeValue === 'Lump Sum') {
        const interestRatePerDay = 0.04 / 7; // Weekly interest rate of 4%, converted to daily rate
        interest = interestRatePerDay * principal * noOfDays; // Interest calculation
        totalAmountToBePaid = principal + interest; // Add interest to the principal
    } else if (paymentModeValue === 'Installment') {
        if (frequencyValue === 'Daily') {
            const dailyInterestRate = (0.04 / 7); // 4% per week divided by 7 days
            interest = dailyInterestRate * principal * noOfDays;
            totalAmountToBePaid = ((interest) + principal) / noOfDays;
        } else if (frequencyValue === 'Weekly') {
            const weeks = parseInt(dueDateOptions.value);
            interest = 0.04 * principal * weeks; // Total interest for the weeks
            totalAmountToBePaid = ((interest) + principal) / weeks;
        } else if (frequencyValue === 'Monthly') {
            const months = parseInt(dueDateOptions.value);
            interest = 0.04 * principal * 4 * months; // Total interest for the months
            totalAmountToBePaid = ((interest) + principal) / months;
        }
    }

    // Set the values in the modal
    document.getElementById('modalPaymentMode').textContent = paymentModeValue; // Display Payment Mode
    document.getElementById('modalFrequency').textContent = frequencyValue; // Display Frequency
    document.getElementById('modalDueDate').textContent = selectedDueDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
    document.getElementById('modalAccountDetails').textContent = accountDetails; // Display Account Details
    document.getElementById('modalTotalAmount').textContent = totalAmountToBePaid.toFixed(2); // Show 2 decimal places

    // Show the interest amount
    document.getElementById('modalTotalInterest').textContent = interest.toFixed(2); // Show interest amount

    // Show the modal using Bootstrap
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

        // Set minimum date to tomorrow
        minDate.setDate(minDate.getDate() + 1);

        // Set maximum date to 3 months from today
        maxDate.setMonth(maxDate.getMonth() + 3);

        dueDateInput.setAttribute('min', minDate.toISOString().split('T')[0]); // Set min attribute
        dueDateInput.setAttribute('max', maxDate.toISOString().split('T')[0]); // Set max attribute
    }
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
    document.getElementById('hiddenTotalInterest').value = document.getElementById('modalTotalInterest').innerText; // Add total interest
}



    function submitForm() {
        // Update the hidden inputs before form submission
        updateHiddenInputs();

        // Submit the form
        document.getElementById('msform').submit();
    }

    // Add event listener to the modal for when it's shown
    document.getElementById('summaryModal').addEventListener('shown.bs.modal', function () {
        updateHiddenInputs();
    });
</script>

</body>

</html>