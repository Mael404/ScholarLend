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

<a href="borrower_messages.php" class="list-group-item position-relative active" style="z-index: 1;">
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
    <a href="borrower_contactus.php" class="list-group-item">
        <i class="fas fa-address-book me-2"></i>Contact Us
    </a>
    <a href="/butterfly/index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="fas fa-power-off me-2"></i>Logout
    </a>
</div>


            
            
        </div>
        
        <!-- /#sidebar-wrapper -->

        <?php

require 'condb.php'; // include your database connection file

// Assuming the user_id is stored in a session variable
$current_user_id = $_SESSION['user_id'];

// Prepare the query to fetch messages for the current user
$sql = "SELECT id, message, created_at, status FROM messages WHERE borrower_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
if ($result->num_rows > 0) {
    // Fetch each message and add it to the messages array
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}
$stmt->close();
$conn->close();
?>

<!-- HTML Code to Display Messages -->
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                    Notifications
                </h2>
                <span class="badge bg-danger ms-2" style="border-radius: 50%;">
                    <?php echo count($messages); // Display the count of unread messages ?>
                </span>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="notification">
            <?php if (!empty($messages)) : ?>
                <?php foreach ($messages as $msg) : ?>
                    <div class="notification-item" 
                         onclick="markAsRead(<?php echo $msg['id']; ?>)" 
                         style="<?php echo ($msg['status'] == 'unread') ? 'font-weight: bold;' : ''; ?>">
                        <i class="fas fa-comment-dots"></i>
                        <div>
                            <h5 class="mb-1">Message</h5>
                            <p><?php echo htmlspecialchars($msg['message']); ?></p>
                            <small class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($msg['created_at'])); ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No new notifications.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JavaScript and AJAX to Mark as Read -->
<script>
function markAsRead(messageId) {
    // Send AJAX request to update message status to "read"
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "mark_as_read.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Remove bold style after marking as read
            document.querySelector(`[onclick="markAsRead(${messageId})"]`).style.fontWeight = 'normal';
        }
    };
    xhr.send("id=" + messageId);
}
</script>

<style>
.notification {
        max-width: 900px;
        margin: auto;
        font-family: Arial, sans-serif;
    }

    .notification-item {
        display: flex;
        align-items: flex-start;
        padding: 10px 5px;
        border-bottom: 1px solid #e0e0e0;
        margin-left: -20px;
        cursor: pointer;
    }

    .notification-item i {
        font-size: 44px;
        margin-right: 40px;
        color: #aaa;
    }

    .notification-item h5 {
        margin: 0;
    }

    .notification-item p {
        margin: 0;
    }

    .notification-item .text-muted {
        color: #aaa;
    }

    
</style>


   
            
            


                

                   
      
 
  

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