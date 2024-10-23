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
$sql = "SELECT fname, mname, lname, email, birthdate, transaction_id FROM borrower_info WHERE status = 'Pending'";

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

            <br>
        
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
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">Middle Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Birthdate</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                // Start a new row
                echo "<tr>";
                echo "<th scope='row'>" . $counter++ . "</th>"; // 1st column (index)
                
                // 2nd to 6th columns (data fields)
                echo "<td>" . (isset($row['fname']) ? htmlspecialchars($row['fname']) : '') . "</td>"; // 2nd column
                echo "<td>" . (isset($row['mname']) ? htmlspecialchars($row['mname']) : '') . "</td>"; // 3rd column
                echo "<td>" . (isset($row['lname']) ? htmlspecialchars($row['lname']) : '') . "</td>"; // 4th column
                echo "<td>" . (isset($row['email']) ? htmlspecialchars($row['email']) : '') . "</td>"; // 5th column
                echo "<td>" . (isset($row['birthdate']) ? htmlspecialchars($row['birthdate']) : '') . "</td>"; // 6th column
                
                // 7th column (actions)
                echo "<td>
                        <button type='button' class='btn btn-link' data-bs-toggle='modal' data-bs-target='#borrowerModal' data-id='" . htmlspecialchars($row['transaction_id']) . "'>
                            <i class='fas fa-eye' style='color: blue;'></i>
                        </button>
                        <button type='button' class='btn btn-outline-success' onclick='checkApplicant(" . htmlspecialchars($row['transaction_id']) . ")'>
                            <i class='fas fa-check' style='color: green;'></i>
                        </button>
                        <button type='button' class='btn btn-outline-danger' onclick='deleteApplicant(" . htmlspecialchars($row['transaction_id']) . ")'>
                            <i class='fas fa-trash'></i>
                        </button>
                      </td>";
                
                // Close the row
                echo "</tr>";
            }
        } 
        $conn->close();
        ?>
    </tbody>
</table>





        </div>

  </div>

  
<!-- Borrower Modal -->
<div class="modal fade" id="borrowerModal" tabindex="-1" aria-labelledby="borrowerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrowerModalLabel">Borrower Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="section-title">Personal Information</h6>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-fname" value="" readonly>
                            <label for="modal-fname">&nbsp;&nbsp;First Name:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-mname" value="" readonly>
                            <label for="modal-mname">&nbsp;&nbsp;Middle Name:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-lname" value="" readonly>
                            <label for="modal-lname">&nbsp;&nbsp;Last Name:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-birthdate" value="" readonly>
                            <label for="modal-birthdate">&nbsp;&nbsp;Birthdate:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-gender" value="" readonly>
                            <label for="modal-gender">&nbsp;&nbsp;Gender:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-cellphonenumber" value="" readonly>
                            <label for="modal-cellphonenumber">&nbsp;&nbsp;Cell Phone:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-email" value="" readonly>
                            <label for="modal-email">&nbsp;&nbsp;Email:</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="section-title">Community & Spending</h6>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-school_community" value="" readonly>
                            <label for="modal-school_community">&nbsp;&nbsp;School Community:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-spending_pattern" value="" readonly>
                            <label for="modal-spending_pattern">&nbsp;&nbsp;Spending Pattern:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-account_details" value="" readonly>
                            <label for="modal-account_details">&nbsp;&nbsp;Account Details:</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="section-title">Education</h6>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-school" value="" readonly>
                            <label for="modal-school">&nbsp;&nbsp;School:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-college" value="" readonly>
                            <label for="modal-college">&nbsp;&nbsp;College:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-course" value="" readonly>
                            <label for="modal-course">&nbsp;&nbsp;Course:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-yearofstudy" value="" readonly>
                            <label for="modal-yearofstudy">&nbsp;&nbsp;Year of Study:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-graduationdate" value="" readonly>
                            <label for="modal-graduationdate">&nbsp;&nbsp;Graduation Date:</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="section-title">Financial Information</h6>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-monthly_allowance" value="" readonly>
                            <label for="modal-monthly_allowance">&nbsp;&nbsp;Monthly Allowance:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-source_of_allowance" value="" readonly>
                            <label for="modal-source_of_allowance">&nbsp;&nbsp;Source of Allowance:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-monthly_expenses" value="" readonly>
                            <label for="modal-monthly_expenses">&nbsp;&nbsp;Monthly Expenses:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-monthly_savings" value="" readonly>
                            <label for="modal-monthly_savings">&nbsp;&nbsp;Monthly Savings:</label>
                        </div>
                        <div class="form-floating mb-3">
    <textarea class="form-control" id="modal-career_goals" rows="4" readonly></textarea>
    <label for="modal-career_goals">&nbsp;&nbsp;Career Goals:</label>
</div>

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="section-title">Loan Details</h6>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-loan_amount" value="" readonly>
                            <label for="modal-loan_amount">&nbsp;&nbsp;Loan Amount:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-loan_purpose" value="" readonly>
                            <label for="modal-loan_purpose">&nbsp;&nbsp;Loan Purpose:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-loan_description" value="" readonly>
                            <label for="modal-loan_description">&nbsp;&nbsp;Loan Description:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-payment_mode" value="" readonly>
                            <label for="modal-payment_mode">&nbsp;&nbsp;Payment Mode:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-payment_frequency" value="" readonly>
                            <label for="modal-payment_frequency">&nbsp;&nbsp;Payment Frequency:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-due_date" value="" readonly>
                            <label for="modal-due_date">&nbsp;&nbsp;Due Date:</label>
                        </div>
                        <div class="form-floating mb-3">
    <input type="text" class="form-control" id="modal-next_deadlines" value="" readonly style="height: 50px; width: 100%;">
    <label for="modal-next_deadlines">&nbsp;&nbsp;Next Deadlines:</label>
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control" id="modal-deadlines_count" value="" readonly style="height: 50px; width: 100%;">
    <label for="modal-deadlines_count">&nbsp;&nbsp;Number of Deadlines:</label>
</div>



                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modal-total_amount" value="" readonly>
                            <label for="modal-total_amount">&nbsp;&nbsp;Total Amount:</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 text-center">
                    <div class="col-md-12">
                        <h6 class="section-title">COR Image Uploads</h6>
                        <div class="image-uploads">
                            <img id="modal-cor1" class="img-fluid mb-2" alt="COR1 Image">
                            <img id="modal-cor2" class="img-fluid mb-2" alt="COR2 Image">
                            <img id="modal-cor3" class="img-fluid mb-2" alt="COR3 Image">
                            <img id="modal-cor4" class="img-fluid mb-2" alt="COR4 Image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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


<script>
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
                document.getElementById('modal-fname').value = data.fname;
                document.getElementById('modal-mname').value = data.mname;
                document.getElementById('modal-lname').value = data.lname;
                document.getElementById('modal-birthdate').value = data.birthdate;
                document.getElementById('modal-gender').value = data.gender;
                document.getElementById('modal-cellphonenumber').value = data.cellphonenumber;
                document.getElementById('modal-email').value = data.email;
                document.getElementById('modal-loan_amount').value = data.loan_amount;
                document.getElementById('modal-loan_purpose').value = data.loan_purpose;
                document.getElementById('modal-loan_description').value = data.loan_description;
                document.getElementById('modal-payment_mode').value = data.payment_mode;
                document.getElementById('modal-payment_frequency').value = data.payment_frequency;
                document.getElementById('modal-due_date').value = data.due_date;
                document.getElementById('modal-total_amount').value = data.total_amount;
                document.getElementById('modal-next_deadlines').value = data.next_deadlines; // New line for next_deadlines
                document.getElementById('modal-school').value = data.school;
                document.getElementById('modal-college').value = data.college;
                document.getElementById('modal-course').value = data.course;
                document.getElementById('modal-yearofstudy').value = data.yearofstudy;
                document.getElementById('modal-graduationdate').value = data.graduationdate;
                document.getElementById('modal-monthly_allowance').value = data.monthly_allowance;
                document.getElementById('modal-source_of_allowance').value = data.source_of_allowance;
                document.getElementById('modal-monthly_expenses').value = data.monthly_expenses;
                document.getElementById('modal-monthly_savings').value = data.monthly_savings;
                document.getElementById('modal-career_goals').value = data.career_goals;
                document.getElementById('modal-school_community').value = data.school_community;
                document.getElementById('modal-spending_pattern').value = data.spending_pattern;
                document.getElementById('modal-account_details').value = data.account_details;

                // Log next_deadlines to console
                console.log('Next Deadlines:', data.next_deadlines); // Log the next_deadlines
                
                // Split the next_deadlines string into an array
                var deadlinesArray = data.next_deadlines.split(', ').map(function(date) {
                    return date.trim(); // Trim any whitespace
                });

                // Count the number of deadlines
                var countDeadlines = deadlinesArray.length;
                console.log('Number of Deadlines:', countDeadlines); // Log the count of deadlines

                // Display the count in the modal
                document.getElementById('modal-deadlines_count').value = countDeadlines; // New line to set the count in the modal

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