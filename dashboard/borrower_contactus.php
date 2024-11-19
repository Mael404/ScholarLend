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

.section-titlez {
    color: #d49f3f;
    font-weight: bold;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    margin-right: 10px;
    font-size: larger;
}
.section-titlez::before {
    content: "●";
    margin-right: 8px;
    font-size: 24px;
    color: #d49f3f;
}
.contact-container {
    display: flex;
    gap: 0px;
    max-width: 1000px; /* Increased max width for better space utilization */
    margin: auto;
    padding-top: 20px;
}
.form-control {
    border-color: #d49f3f;
}
.form-control::placeholder {
    color: #d49f3f;
}
.btn-send {
    background-color: #d49f3f;
    color: white;
    border: none;
    padding: 10px 20px;
    font-weight: bold;
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


   
    <a href="borrower_transactions.php" class="list-group-item">
        <i class="fas fa-exchange-alt me-2"></i>Transactions
    </a>
    <a href="borrower_settings.php" class="list-group-item">
        <i class="fas fa-cog me-2"></i>Settings
    </a>
    <a href="borrower_contactus.php" class="list-group-item active">
        <i class="fas fa-address-book me-2"></i>Contact Us
    </a>
    <a href="/butterfly/index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="fas fa-power-off me-2"></i>Logout
    </a>
</div>


            
            
        </div>
        
        <div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                    Contact Us
                </h2>
            </div>
        </div>
    </nav>

    <div class="container mt-2">
    <div class="contact-container">
       
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="section-titlez">Send Us Message</div>
                <p>To reach our customer support, submit a ticket or schedule a call below. Please provide a detailed description of your problem or questions.</p>
                <form method="POST" action="contactus.php"> <!-- Adjust action to your file's path -->
    <div class="mb-3">
        <select class="form-control" name="subject" aria-label="Subject" required>
            <option value="" selected>Select Subject</option>
            <option value="Inquiry">Inquiry</option>
            <option value="Follow-up">Follow-up</option>
            <option value="Technical Problem">Technical Problem</option>
            <option value="Other Loan Application Concern">Other Loan Application Concern</option>
        </select>
    </div>
    <div class="mb-4">
        <textarea class="form-control" name="message" rows="5" placeholder="Enter Message" required></textarea>
    </div>
    <button type="submit" class="btn btn-send">Send Message</button>
</form>

            </div>

            <div class="col-12 col-md-4">
                <div class="section-titlez">Contact Number</div>
                <p>Landline:</p>
                <p>Smart:</p>
                <p>Globe:</p>
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

 </script>



</body>

</html>