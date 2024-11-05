<?php
session_start(); // Start session to access session variables


include 'display_user_wallet.php';

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
    font-weight: bold; 
    border-radius: 8px; 
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
    <a href="lender.php" class="list-group-item list-group-item-action ">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </a>
    <a href="#" class="list-group-item">
        <i class="fas fa-envelope me-2"></i>Messages
    </a>
    <a href="lender_addcredit.php" class="list-group-item active">
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
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
            <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
           
            </h2>
        </div>

       

        <!-- Wallet Section (Positioned Where User Dropdown Was) -->
        <a class="nav-link wallet-link second-text fw-bold ms-auto" href="#">
    <i class="fas fa-wallet me-2"></i>Balance: 
    <span class="wallet-balance">PHP <?php echo number_format($wallet_balance, 2); ?></span>
</a>

    </div>
</nav>

<!-- Optional CSS for wallet styling -->
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
// Connect to the database
$pdo = new PDO("mysql:host=localhost;dbname=scholarlend_db", "username", "password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$current_user_id = $_SESSION['user_id']; // Assuming `user_id` is stored in the session upon login

// Query 1: Get available to lend amount from users_tb
$available_to_lend = 0;
$query = $pdo->prepare("SELECT wallet_balance FROM users_tb WHERE user_id = ?");
$query->execute([$current_user_id]);
if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    $available_to_lend = $result['wallet_balance'];
}

// Query 2: Get total amount lent and loans made from users_tb
$total_amount_lent = 0;
$loans_made = 0;
$query = $pdo->prepare("SELECT total_amount_lent, loans_made FROM users_tb WHERE user_id = ?");
$query->execute([$current_user_id]);
if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    $total_amount_lent = $result['total_amount_lent'];
    $loans_made = $result['loans_made'];
}

// Query 3: Calculate outstanding loans from borrower_info
$outstanding_loans = 0;
$query = $pdo->prepare("SELECT SUM(outstanding_balance) AS total_outstanding FROM borrower_info WHERE lender_id = ?");
$query->execute([$current_user_id]);
if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    $outstanding_loans = $result['total_outstanding'];
}
?>

<div class="container-fluid px-4">
    <!-- Account Overview -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="card p-3" style="background-color: #f4f1ec;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title" style="font-family: 'Times New Roman', Times, serif; font-size:xx-large;">Account Overview</h5>
                        <div class="d-flex">
                            <div class="mr-4">
                                <span class="text-muted">AVAILABLE TO LEND</span>
                                <h4>₱<?php echo number_format($available_to_lend, 2); ?></h4>
                            </div>
                            <div style="margin-left: 350px;">
                                <span class="text-muted">OUTSTANDING LOANS</span>
                                <h4 class="text-muted">₱<?php echo number_format($outstanding_loans, 2); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-warning">Invest funds</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lending Insights -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="card p-3" style="background-color: #e8d1ae;">
                <h5 class="card-title" style="font-family: 'Times New Roman', Times, serif; font-size:xx-large;">Your lending insights</h5>
                <div class="d-flex justify-content-between align-items-center" style="background-color: #e8d1ae;">
                    <div>
                        <span class="text-muted">TOTAL AMOUNT LENT</span>
                        <h4>₱<?php echo number_format($total_amount_lent, 2); ?></h4>
                    </div>
                    <div>
                        <span class="text-muted">LOANS MADE</span>
                        <h4><?php echo $loans_made; ?></h4>
                    </div>
                    <div>
                        <button class="btn btn-dark">View loans</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            


                

                   

            

      
 
  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    

</body>

</html>