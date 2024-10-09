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

// Query to fetch all required data
$sql = "SELECT fname, mname, lname, email, birthdate, user_id FROM borrower_info";
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
#image-container img {
        max-width: 100%; /* Ensure images are responsive */
        height: auto;    /* Maintain aspect ratio */
        width: 100%;     /* Set width to 100% of the container */
        max-height: 400px; /* Set a max-height for larger images */
        object-fit: cover; /* Crop images to fit the container */
    }
    .modal-body {
    font-size: 1.1rem; /* Increase font size */
}

.img-fluid {
    max-width: 100%; /* Ensure images are responsive */
    height: auto; /* Maintain aspect ratio */
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
                    <div class="username">Your Name Here</div>
                    <div class="email">user@example.com</div>
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

  <div class="container mt-4">
    <div class="row">
      <!-- Total Applicants Card -->
      <div class="col-md-4">
        <div class="card text-center rounded">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-center">
              <i class="fas fa-users fa-2x me-3"></i>
              <h5 class="card-title">Total Applicants</h5>
            </div>
            <p class="card-text fs-4">20</p>
          </div>
        </div>
      </div>

      <!-- Pending Card -->
      <div class="col-md-4">
        <div class="card text-center rounded">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-center">
              <i class="fas fa-hourglass-half fa-2x me-3"></i>
              <h5 class="card-title">Pending</h5>
            </div>
            <p class="card-text fs-4">2</p>
          </div>
        </div>
      </div>

      <!-- Approved Card -->
      <div class="col-md-4">
        <div class="card text-center rounded">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-center">
              <i class="fas fa-check fa-2x me-3"></i>
              <h5 class="card-title">Approved</h5>
            </div>
            <p class="card-text fs-4">3</p>
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
            <th scope="col">View More</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            $counter = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<th scope='row'>" . $counter++ . "</th>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td>" . $row['mname'] . "</td>";
                echo "<td>" . $row['lname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['birthdate'] . "</td>";
                echo "<td>
                        <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#borrowerModal' data-id='" . $row['user_id'] . "'>View More</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

</div>

  </div>
<!-- Borrower Modal -->
<div class="modal fade" id="borrowerModal" tabindex="-1" aria-labelledby="borrowerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrowerModalLabel">Borrower Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Personal Information</h6>
                        <p><strong>First Name:</strong> <span id="modal-fname"></span></p>
                        <p><strong>Middle Name:</strong> <span id="modal-mname"></span></p>
                        <p><strong>Last Name:</strong> <span id="modal-lname"></span></p>
                        <p><strong>Birthdate:</strong> <span id="modal-birthdate"></span></p>
                        <p><strong>Gender:</strong> <span id="modal-gender"></span></p>
                        <p><strong>Cell Phone Number:</strong> <span id="modal-cellphonenumber"></span></p>
                        <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Loan Details</h6>
                        <p><strong>Loan Amount:</strong> <span id="modal-loan_amount"></span></p>
                        <p><strong>Loan Purpose:</strong> <span id="modal-loan_purpose"></span></p>
                        <p><strong>Loan Description:</strong> <span id="modal-loan_description"></span></p>
                        <p><strong>Payment Mode:</strong> <span id="modal-payment_mode"></span></p>
                        <p><strong>Payment Frequency:</strong> <span id="modal-payment_frequency"></span></p>
                        <p><strong>Due Date:</strong> <span id="modal-due_date"></span></p>
                        <p><strong>Total Amount:</strong> <span id="modal-total_amount"></span></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Education</h6>
                        <p><strong>School:</strong> <span id="modal-school"></span></p>
                        <p><strong>College:</strong> <span id="modal-college"></span></p>
                        <p><strong>Course:</strong> <span id="modal-course"></span></p>
                        <p><strong>Year of Study:</strong> <span id="modal-yearofstudy"></span></p>
                        <p><strong>Graduation Date:</strong> <span id="modal-graduationdate"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Financial Information</h6>
                        <p><strong>Monthly Allowance:</strong> <span id="modal-monthly_allowance"></span></p>
                        <p><strong>Source of Allowance:</strong> <span id="modal-source_of_allowance"></span></p>
                        <p><strong>Monthly Expenses:</strong> <span id="modal-monthly_expenses"></span></p>
                        <p><strong>Monthly Savings:</strong> <span id="modal-monthly_savings"></span></p>
                        <p><strong>Career Goals:</strong> <span id="modal-career_goals"></span></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Images</h6>
                        <img id="modal-cor1" class="img-fluid mb-2" alt="COR1 Image">
                        <img id="modal-cor2" class="img-fluid mb-2" alt="COR2 Image">
                        <img id="modal-cor3" class="img-fluid mb-2" alt="COR3 Image">
                        <img id="modal-cor4" class="img-fluid mb-2" alt="COR4 Image">
                    </div>
                    <div class="col-md-6">
                        <h6>Community & Spending</h6>
                        <p><strong>School Community:</strong> <span id="modal-school_community"></span></p>
                        <p><strong>Spending Pattern:</strong> <span id="modal-spending_pattern"></span></p>
                        <p><strong>Account Details:</strong> <span id="modal-account_details"></span></p>
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

<!-- Bootstrap JS 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    
   
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var borrowerModal = document.getElementById('borrowerModal');
    
    borrowerModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-id');

        // Use AJAX to fetch the data
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'view_borrower.php?id=' + userId, true);
        xhr.onload = function () {
            if (this.status == 200) {
                var data = JSON.parse(this.responseText);

                // Populate the modal fields with fetched data
                document.getElementById('modal-fname').innerText = data.fname;
                document.getElementById('modal-mname').innerText = data.mname;
                document.getElementById('modal-lname').innerText = data.lname;
                document.getElementById('modal-birthdate').innerText = data.birthdate;
                document.getElementById('modal-gender').innerText = data.gender;
                document.getElementById('modal-cellphonenumber').innerText = data.cellphonenumber;
                document.getElementById('modal-email').innerText = data.email;
                document.getElementById('modal-loan_amount').innerText = data.loan_amount;
                document.getElementById('modal-loan_purpose').innerText = data.loan_purpose;
                document.getElementById('modal-loan_description').innerText = data.loan_description;
                document.getElementById('modal-payment_mode').innerText = data.payment_mode;
                document.getElementById('modal-payment_frequency').innerText = data.payment_frequency;
                document.getElementById('modal-due_date').innerText = data.due_date;
                document.getElementById('modal-total_amount').innerText = data.total_amount;
                document.getElementById('modal-school').innerText = data.school;
                document.getElementById('modal-college').innerText = data.college;
                document.getElementById('modal-course').innerText = data.course;
                document.getElementById('modal-yearofstudy').innerText = data.yearofstudy;
                document.getElementById('modal-graduationdate').innerText = data.graduationdate;
                document.getElementById('modal-monthly_allowance').innerText = data.monthly_allowance;
                document.getElementById('modal-source_of_allowance').innerText = data.source_of_allowance;
                document.getElementById('modal-monthly_expenses').innerText = data.monthly_expenses;
                document.getElementById('modal-monthly_savings').innerText = data.monthly_savings;
                document.getElementById('modal-career_goals').innerText = data.career_goals;
                document.getElementById('modal-school_community').innerText = data.school_community;
                document.getElementById('modal-spending_pattern').innerText = data.spending_pattern;
                document.getElementById('modal-account_details').innerText = data.account_details;

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
            "info": true
        });
    });
    </script>


</body>

</html>