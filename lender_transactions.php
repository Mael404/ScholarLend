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
            
          <br>
            <div class="user-info d-flex align-items-center my-3 text-center">
            <i class="fas fa-user-circle" style="font-size: 50px; margin-right: 10px; color:#dbbf94;"></i>
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
    <a href="lender.php" class="list-group-item list-group-item-action  ">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </a>
    <a href="lender_messages.php" class="list-group-item ">
        <i class="fas fa-envelope me-2"></i>Messages
    </a>
   
    <a href="lender_transactions.php" class="list-group-item active">
        <i class="fas fa-exchange-alt me-2"></i>Transactions
    </a>
    <a href="lender_settings.php" class="list-group-item">
        <i class="fas fa-cog me-2"></i>Settings
    </a>
    <a href="lender_contactus.php" class="list-group-item">
        <i class="fas fa-address-book me-2"></i>Contact Us
    </a>
    <a href="index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="fas fa-power-off me-2"></i>Logout
    </a>
</div>


            
            
        </div>
        

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

// Initialize variables
$total_loaned = 0;
$loans_made = 0;

// Query to get total_loaned and loans_made from users_tb table
$sql = "SELECT total_amount_lent, loans_made FROM users_tb WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $total_loaned = $row['total_amount_lent'] ?? 0;  // Default to 0 if null
    $loans_made = $row['loans_made'] ?? 0;            // Default to 0 if null
}

$stmt->close();

// Fetch transaction history from borrower_info table where lender_id matches user_id
// Query to get transaction history where lender_id matches the logged-in user_id
$sql = "SELECT transaction_id, loan_amount, created_at, status 
        FROM borrower_info 
        WHERE lender_id = ?";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Bind the logged-in user_id to the query
$stmt->execute();
$transactions = $stmt->get_result();
?>

<!-- HTML Code to Display Messages -->
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                    Transaction History
                </h2>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- PHP-generated card -->
        <div class="card p-4 text-left" style=" background-color: #f4e4c3; border-radius: 8px; border: none; height: 250px;">
            <h5 class="fw-bold" style="font-family:'Times New Roman', Times, serif; font-size:40px;">Lending Insights</h5>
            <div class="d-flex justify-content-between align-items-center h-100">
                <div>
                    <p class="mb-1" style="font-size: 1em; color: #999999;">TOTAL AMOUNT LOANED</p>
                    <p class="fw-bold" style="color: #d3a569; font-size: 2em;">₱<?php echo number_format($total_loaned, 2); ?></p>
                </div>
                <div style="flex: 1; text-align: center;">
                    <p class="mb-1" style="font-size: 1em; color: #999999;">LOANS MADE</p>
                    <p class="fw-bold" style="color: #000000; font-size: 2.5em;"><?php echo $loans_made; ?></p>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive mt-5">
            <table id="applicantsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Loan Lent</th>
                        <th>Loan Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($transactions->num_rows > 0): ?>
                        <?php while ($row = $transactions->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['transaction_id']); ?></td>
                                <td>₱<?php echo number_format($row['loan_amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars(date('F j, Y', strtotime($row['created_at']))); ?></td>

                                <td>
    <?php 
        // Check the status and change it if it's not "Complete"
        $status = $row['status'];
        if ($status !== "Complete") {
            $status = "Ongoing";
        }
        echo htmlspecialchars($status); 
    ?>
</td>

                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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