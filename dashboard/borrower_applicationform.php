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
                    <div class="username">Your Name Here</div>
                    <div class="email">user@example.com</div>
                </div>
          
           
               
            </div>
            <br>
        
            <div class="list-group list-group-flush my-3">
                <a href="admindashboard.php" class="list-group-item list-group-item-action active">
                    <i class="fas fa-home me-2"></i>Home
                </a>
                <a href="admin_applications.php" class="list-group-item">
                    <i class="fas fa-folder-open m  e-2"></i>Applications
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

                            <form id="msform" action="borrower_apform_data.php" method="post" enctype="multipart/form-data">
                                <!-- progressbar -->
                              
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
                                                        <option value="below_1000">Below $1000</option>
                                                        <option value="1000_3000">$1000 - $3000</option>
                                                        <option value="3000_5000">$3000 - $5000</option>
                                                        <option value="above_5000">Above $5000</option>
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
                                                        <option value="" disabled selected>Select Source of Allowance</option>
                                                        <option value="family">Family</option>
                                                        <option value="scholarship">Scholarship</option>
                                                        <option value="part-time">Part-time Job</option>
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
                                                        <option value="below_1000">Below $1000</option>
                                                        <option value="1000_3000">$1000 - $3000</option>
                                                        <option value="3000_5000">$3000 - $5000</option>
                                                        <option value="above_5000">Above $5000</option>
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
                                                        <option value="none">None</option>
                                                        <option value="below_500">Below $500</option>
                                                        <option value="500_1000">$500 - $1000</option>
                                                        <option value="above_1000">Above $1000</option>
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
                                                    <input type="number" class="form-control form-control-sm" id="loanAmount" name="loan_amount" placeholder="Loan Amount" required>
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
                            
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control form-control-sm" id="monthlyExpenses" name="monthly_expenses" placeholder="Monthly Expenses" required>
                                                    <label for="monthlyExpenses">Monthly Expenses</label>
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
                <div class="col-5">
                    <!-- Any additional content can go here -->
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
        
            <!-- Due Date -->
            <div class="form-floating mb-3">
                <input type="date" class="form-control" name="due_date" id="dueDate" placeholder="Select Date of Payment">
                <label for="dueDate">Due Date</label>
            </div>
        
            <!-- Account Details -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="account_details" id="accountDetails" placeholder="Enter Bank Account Details">
                <label for="accountDetails">Account Details</label>
            </div>
        
            <input type="submit" name="submit" class="next action-button" value="Submit" />
            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
        </div>
    </fieldset>
                                
                            </form>

                            
                        </div>
                    </div>
                </div>
            </div>
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

</body>

</html>