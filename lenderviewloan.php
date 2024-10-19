<?php
// Start the session
session_start();

include 'condb.php';
$transaction_id = $_GET['transaction_id']; // Assuming transaction_id is passed via GET request

$query = "SELECT created_at, total_amount, payment_frequency, days_to_next_deadline FROM borrower_info WHERE transaction_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $transaction_id);
$stmt->execute();
$result = $stmt->get_result();
$loan = $result->fetch_assoc(); // Fetching the loan details

// Check if the parameters are set
if (isset($_GET['transaction_id'], $_GET['fname'], $_GET['loan_description'], $_GET['loan_amount'])) {
    $transaction_id = $_GET['transaction_id'];
    $fname = htmlspecialchars($_GET['fname']); // Sanitize the input
    $loan_description = htmlspecialchars($_GET['loan_description']); // Sanitize the input
    $loan_amount = htmlspecialchars($_GET['loan_amount']); // Sanitize the input
} else {
    // Handle the case where parameters are missing
    $fname = "Unknown Borrower";
    $loan_description = "No description available.";
    $loan_amount = "0.00"; // Default value
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Starter Page - Butterfly Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="starter-page-page">

  <main class="main">

    <section id="hero" class="hero section light-background" style="position: relative; background-image: url('assets/img/hero-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">
        <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #131e3d; opacity: 0.5;"></div>
    <div class="container mt-5">
    <!-- Borrower Profile Section -->
    <div class="row">
    <div class="col-12 col-md-8 mb-4">
    
    <div class="borrower-profile card p-4" style="border-radius: 10px; background-color: #fff; min-height: 400px; position: relative; display: flex; flex-direction: column;">
    <div class="d-flex align-items-center mb-3 position-relative">
        <!-- Image container with overlay -->
        <div class="borrower-image-container" style="position: relative; width: 60px; height: 60px;">
            <img src="borrower-image.jpg" alt="<?php echo $fname; ?>" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div class="ms-3">
            <h5><?php echo $fname; ?></h5>
            <p class="text-muted mb-0">Junior</p>
        </div>
    </div>
    <p><?php echo $loan_description; ?></p>
    
    <!-- Tags -->
    <div class="d-flex mt-auto">
        <span class="badge bg-light text-dark me-2" style="padding: 10px; border-radius: 20px;">
            <i class="fas fa-graduation-cap"></i> BS Entrepreneurship
        </span>
        <span class="badge bg-light text-dark" style="padding: 10px; border-radius: 20px;">
            Expenses
        </span>
    </div>
</div>


    </div>

    <!-- Help Fund Section -->
    <div class="col-12 col-md-4">
    <div class="help-fund card p-4" style="background-color: #fff; border-radius: 10px;">
        <h5>Help fund this loan</h5>
        <div class="input-group mt-3">
            <input type="text" class="form-control" value="<?php echo $loan_amount; ?>" readonly>
            <button class="btn" style="background-color: #dbbf94; color: #323246; border: none; margin-left: 10px;">Lend now</button>
        </div>
        <button class="btn mt-3" style="background-color: #192a4d; color: white; width: 100%;">Invest funds</button>

        <!-- Borrower Profile and Loan Details -->
        <div class="d-flex justify-content-between align-items-center mt-4" style="color: #dbbf94;">
            <!-- Trigger modal for Borrower Profile -->
            <span data-bs-toggle="modal" data-bs-target="#borrowerProfileModal" style="cursor: pointer;">
                <i class="fas fa-user"></i> Borrower Profile
            </span>
            <!-- Trigger modal for Loan Details -->
            <span data-bs-toggle="modal" data-bs-target="#loanDetailsModal" style="cursor: pointer;">
                <i class="fas fa-bars"></i> Loan details
            </span>
        </div>
    </div>
</div>

<!-- Modal for Borrower Profile -->
<div class="modal fade" id="borrowerProfileModal" tabindex="-1" aria-labelledby="borrowerProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="borrowerProfileModalLabel">Borrower A</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>Borrower A</h5>
        <p class="text-muted">Junior BS Entrepreneurship</p>

        <h6>Career goals and plans</h6>
        <p>My goal is to launch a tech startup that addresses a market need after gaining experience through internships and startup competitions. Long-term, I plan to scale the business and mentor aspiring entrepreneurs.</p>
        
        <h6>Access documents here:</h6>
        <ul>
          <li><a href="#">Risk assessment Report</a></li>
          <li><a href="#">Credit score Breakdown</a></li>
          <li><a href="#">Academic Transcript</a></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Loan Details -->
<!-- Modal for Loan Details -->
<div class="modal fade" id="loanDetailsModal" tabindex="-1" aria-labelledby="loanDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loanDetailsModalLabel">Loan Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul style="list-style: none; padding: 0;">
          <li><strong>Loan amount</strong> <span style="float: right;">₱<?php echo $loan_amount; ?></span></li>
          <li><strong>Application date</strong> <span style="float: right;"><?php echo date('F j, Y', strtotime($loan['created_at'])); ?></span></li>
          <li><strong>Days to next deadline</strong> 
    <span style="float: right;">
        <?php 
            // Fetch the payment frequency
            $frequency = strtolower($loan['payment_frequency']);
            $days_to_next_deadline = $loan['days_to_next_deadline'];

            // Determine the correct label based on the payment frequency
            switch ($frequency) {
                case 'daily':
                    $label = 'Days';
                    break;
                case 'weekly':
                    $label = 'Weeks';
                    break;
                case 'monthly':
                    $label = 'Months';
                    break;
                default:
                    $label = 'Days'; // Default to Days if no match
            }

            // Output the days and label
            echo $days_to_next_deadline . ' ' . $label;
        ?>
    </span>
</li>

<li><strong>Frequency of payment</strong> 
    <span style="float: right;"><?php echo ucfirst($loan['payment_frequency']); ?></span>
</li>

          <li><strong>Frequency of payment</strong> <span style="float: right;"><?php echo ucfirst($loan['payment_frequency']); ?></span></li>
          <li><strong>Amount paid per installment</strong> 
    <span style="float: right;">₱<?php echo number_format($loan['total_amount'], 2); ?></span>
</li>


          <li><strong>Is the borrower paying interest?</strong> <span style="float: right;">Yes</span></li>
        </ul>

        <!-- Repayment Schedule Link -->
        <div style="margin-top: 20px;">
          <a href="#" style="color: #dbbf94; font-weight: bold; text-decoration: none;">DETAILED REPAYMENT SCHEDULE &gt;</a>
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


  </section>
  
   
   <!-- CSS for responsiveness -->
   
   
   
   
    
    
    

  </main>
  
  
  
  





  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>