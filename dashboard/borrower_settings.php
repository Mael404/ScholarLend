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


   
    <a href="borrower_transactions.php" class="list-group-item ">
        <i class="fas fa-exchange-alt me-2"></i>Transactions
    </a>
    <a href="borrower_settings.php" class="list-group-item active">
        <i class="fas fa-cog me-2"></i>Settings
    </a>
    <a href="borrower_contactus.php" class="list-group-item">
        <i class="fas fa-address-book me-2"></i>Contact Us
    </a>
    <a href="/butterfly/index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="fas fa-power-off me-2"></i>Logout
    </a>
</div>


            
            
        </div>
        
<!-- HTML Code for Profile Settings -->
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                    Account Settings
                </h2>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Profile Settings Card -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Manage Your Account</h5>
                
                <!-- Options List -->
                <div class="list-group">
                    <!-- Forgot Password Option -->
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                        <i class="fas fa-key me-2"></i> Forgot Password
                    </a>
                    
                    <!-- Update Password Option -->
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                        <i class="fas fa-lock me-2"></i> Update Password
                    </a>

                    <!-- Change Email Option -->
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#changeEmailModal">
                        <i class="fas fa-envelope me-2"></i> Change Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Modal -->
<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="forgot-email" class="form-label">Enter your email to reset password</label>
            <input type="email" class="form-control" id="forgot-email" placeholder="Enter registered email" required>
        </div>
        <div class="mb-3" id="password-fields" style="display: none;">
            <label for="new-password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="new-password" placeholder="Enter new password" required>
        </div>
        <div class="mb-3" id="confirm-password-fields" style="display: none;">
            <label for="confirm-password" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm-password" placeholder="Confirm new password" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="reset-password-btn">Reset Password</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePasswordForm">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updatePasswordBtn">Update Password</button>
            </div>
        </div>
    </div>
</div>


<!-- Change Email Modal -->
<div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="changeEmailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeEmailModalLabel">Change Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="new-email" class="form-label">New Email Address</label>
            <input type="email" class="form-control" id="new-email" placeholder="Enter new email" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Change Email</button>
      </div>
    </div>
  </div>
</div>

    
                   
      
<!-- Script Dependencies (Correct order) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  <!-- Latest jQuery -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>  <!-- DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>  <!-- Bootstrap JS -->
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>  <!-- DataTables Bootstrap JS -->

<script>
document.getElementById('reset-password-btn').addEventListener('click', function () {
    var email = document.getElementById('forgot-email').value;
    var newPassword = document.getElementById('new-password').value;
    var confirmPassword = document.getElementById('confirm-password').value;

    if (!email) {
        alert('Please enter an email.');
        return;
    }

    if (newPassword !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }

    console.log("Email:", email); // Check the email
    console.log("New Password:", newPassword); // Check the new password

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "reset_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                $('#forgotPasswordModal').modal('hide');
            } else {
                alert(response.message);
            }
        }
    };

    var data = "email=" + encodeURIComponent(email) + "&new_password=" + encodeURIComponent(newPassword);
    console.log("Data to send:", data); // Check the data being sent

    xhr.send(data);
});
document.getElementById('forgot-email').addEventListener('input', function () {
    if (this.value) {
        document.getElementById('password-fields').style.display = 'block';
        document.getElementById('confirm-password-fields').style.display = 'block';
    } else {
        document.getElementById('password-fields').style.display = 'none';
        document.getElementById('confirm-password-fields').style.display = 'none';
    }
});

// Event listener for the update password button
document.getElementById('updatePasswordBtn').addEventListener('click', function () {
    var currentPassword = document.getElementById('currentPassword').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('Please fill in all fields.');
        return;
    }

    if (newPassword !== confirmPassword) {
        alert('New password and confirm password do not match.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            alert(response.message); // Show the response message

            if (response.success) {
                $('#updatePasswordModal').modal('hide'); // Hide the modal if successful
            }
        }
    };

    // Sending the data to the server
    var data = "currentPassword=" + encodeURIComponent(currentPassword) + 
               "&newPassword=" + encodeURIComponent(newPassword) + 
               "&confirmPassword=" + encodeURIComponent(confirmPassword);
    xhr.send(data);
});



document.querySelector('#changeEmailModal .btn-primary').addEventListener('click', function () {
    var newEmail = document.getElementById('new-email').value;

    if (!newEmail) {
        alert('Please enter a new email address.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "change_email.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                $('#changeEmailModal').modal('hide');
            } else {
                alert(response.message);
            }
        }
    };

    var data = "new_email=" + encodeURIComponent(newEmail);
    xhr.send(data);
});

</script>

</body>




</html>