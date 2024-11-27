<?php
session_start(); // Start the session

// Retrieve error message from session if set
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Clear the error message after displaying it to prevent it from showing again
unset($_SESSION['error_message']);
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

<!-- forgot pass Form -->
<div class="container d-flex justify-content-center">
  <div class="col-md-6 col-lg-4 mt-1">
    <div class="card p-4" style="border: 1px solid #d4b891; border-radius: 10px;">
      <div class="card-body">
        <h3 class="card-title text-center mb-2" style="font-weight: 400;">Forgot Password?</h3>
      
        </p>
        <p class="text-center" style="margin: -10px">
          <span style="color: black; font-weight: 300; font-size: medium;">
          Please enter your email address below to proceed with the password reset process.</span>
        </p>
      
        <form method="POST" action="forgot_password_data.php" onsubmit="return validateForm()">
    <div class="mb-3" style="margin-top: 10%;">
        <label for="email" class="form-label" style="font-weight: bold;">Email address:</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required style="border: 1px solid #d4b891; border-radius: 0%;">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label" style="font-weight: bold;">New Password:</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required style="border: 1px solid #d4b891; border-radius: 0%;">
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label" style="font-weight: bold;">Confirm New Password:</label>
        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required style="border: 1px solid #d4b891; border-radius: 0%;">
    </div>

    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <div class="d-grid gap-2" style="margin-top: 10%;">
        <button type="submit" name="submit" class="btn btn-primary" style="background: #caac82; border-color: #caac82;">Verify</button>
    </div>
    <div class="text-center mt-2">
        <a href="login.php" style="color: #caac82; font-weight: 400; text-decoration: none; padding-bottom: 10px; border-bottom: 2px solid #caac82;">Back to Log-in</a>
    </div>
</form>


<!-- Bootstrap 5 Modal for password mismatch alert -->
<div class="modal fade" id="passwordMismatchModal" tabindex="-1" aria-labelledby="passwordMismatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordMismatchModalLabel">Password Mismatch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The passwords you entered do not match. Please ensure both passwords are identical.</p>
            </div>
        </div>
    </div>
</div>








      </div>
    </div>
  </div>
</div>








<div class="container copyright text-center mt-5">
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

  <script>
    // Function to validate the form before submission
    function validateForm() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        
        // Check if the passwords match
        if (password !== confirmPassword) {
            // Show the BS5 modal
            var myModal = new bootstrap.Modal(document.getElementById('passwordMismatchModal'));
            myModal.show();
            return false;  // Prevent form submission
        }

        return true;  // Allow form submission
    }
</script>
</body>

</html>