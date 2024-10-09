<?php
session_start();

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

// Initialize error message
$error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input to avoid SQL injection
    $email = $conn->real_escape_string($email);

    // Query to check if user exists
    $sql = "SELECT * FROM users_tb WHERE email = '$email' AND is_verified = 1 LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

       // After verifying the password
if (password_verify($password, $user['password'])) {
  $_SESSION['user_id'] = $user['user_id'];
  $_SESSION['first_name'] = $user['first_name'];
  $_SESSION['email'] = $user['email']; // Add this line
  $_SESSION['account_role'] = $user['account_role'];

  // Redirect based on role
  if (strtolower($user['account_role']) == 'lender') {
      header("Location: lenderdashboard.html");
  } elseif (strtolower($user['account_role']) == 'borrower') {
      header("Location: borrower_dashboard.php");
  } 
  elseif (strtolower($user['account_role']) == 'admin') {
    header("Location: dashboard/admin_applications.php");
} 
    else {
      header("Location: dashboard.html");
  }

  exit();
}
else {
            // Set error message
            $error_message = "Invalid email or password.";
        }
    } else {
        // Set error message
        $error_message = "Invalid email or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ScholarLend</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/fslogo.png" rel="icon">
  <link href="assets/img/fslogo.png" rel="apple-touch-icon">

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

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body class="starter-page-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <h1 class="sitename" style="font-size: 3rem; font-weight: bold; text-decoration: none; font-family: 'Times New Roman', Times, serif; color: #caac82;">
          Scholar<span style="color: #323246;">Lend</span>
        </h1>
      </a>
      
      
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          
          <li><a href="#contact">Contact</a></li>
          <li><a href="login.html" class="active">Log-in</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main" style="margin-top: -30px;">

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section" style="background-color: #f1eee9; height: 92vh;" >

<!-- Sign Up Form -->
<div class="container d-flex justify-content-center">
  <div class="col-md-6 col-lg-4">
    <div class="card p-4" style="border: 1px solid #d4b891; border-radius: 10px;">
      <div class="card-body">
        <h3 class="card-title text-center mb-2" style="font-weight: 400;">Sign In Below</h3>
        <p class="text-center">
          <span style="color: black;">or </span>
          <a href="#" data-bs-toggle="modal" data-bs-target="#accountTypeModal" style="color: #caac82; font-weight: bold; text-decoration: none;">
            create a new ScholarLend account
        </a>
        
        
        </p>
        <p class="text-center" style="margin: -10px">
          <span style="color: black; font-weight: 300; font-size: medium;">Sign in the same way you did last time to avoid creating a second ScholarLend account</span>
        </p>
        <form method="POST" action="login.php">
    <div class="mb-3" style="margin-top: 10%;">
        <label for="email" class="form-label" style="font-weight: bold;">Email address:</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required style="border: 1px solid #d4b891; border-radius: 0%;">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label" style="font-weight: bold;">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required style="border: 1px solid #d4b891; border-radius: 0%;">
    </div>

    <!-- Display error message here -->
    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="d-grid gap-2" style="margin-top: 10%;">
        <button type="submit" class="btn btn-primary" style="background: #caac82; border-color: #caac82;">Sign In</button>
    </div>
    <div class="form-check mt-3 d-flex justify-content-center">
        <input class="form-check-input" type="checkbox" id="rememberMe">
        <label class="form-check-label ms-2" for="rememberMe" style="font-weight: 400;">Remember me</label>
    </div>
    <div class="text-center mt-2">
        <a href="#" style="color: #caac82; font-weight: 400; text-decoration: none; padding-bottom: 10px; border-bottom: 2px solid #caac82;">Forgot password?</a>
    </div>
</form>

      </div>
    </div>
  </div>
</div>
<!-- End Sign Up Form -->

<div class="modal fade" id="accountTypeModal" tabindex="-1" aria-labelledby="accountTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="width: 100%; text-align: center;">
        <h5 class="modal-title" id="accountTypeModalLabel" style="flex: 1;">Choose Account Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Please select the type of account you would like to create:</p>
        <div class="d-flex justify-content-around">
          <a href="registration-lender.php" class="btn btn-primary" style="background: #323246; border-color: #caac82;">Lender Account</a>
          <a href="registration-borrower.php" class="btn btn-secondary" style="background: #323246; border-color: #caac82;">Borrower Account</a>
        </div>
      </div>
    </div>
  </div>
</div>







<div class="container copyright text-center mt-4">
  <p>© <span>Copyright</span> <strong class="px-1 sitename">ScholarLend</strong> <span>All Rights Reserved</span></p>
 
</div>


     

    </section><!-- /Starter Section Section -->

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