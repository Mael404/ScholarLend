<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ScholarLend - log in or sign up</title>
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

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Butterfly
  * Template URL: https://bootstrapmade.com/butterfly-free-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
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
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          
          <li><a href="#contact">Contact</a></li>
          <li><a href="login.html">Log-in</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main" style="margin-top: -30px;">

  <section id="registration-section" class="registration-section section" style="background-color: #f1eee9; padding: 1rem 0;">
  <!-- Registration Form -->
  <div class="container d-flex justify-content-center" style="margin-top: 30px;">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card p-3" style="border: 1px solid #d4b891; border-radius: 8px;">
        <div class="card-body">
          <h3 class="card-title text-center mb-4" style="font-family: 'Times New Roman', Times, serif; font-weight: 560; font-size: 1.5rem;">
            <span style="color: #caac82;">Welcome to Scholar</span><span style="color: black;">Lend</span>
          </h3>
          <div>
            <p style="text-align: center; margin-top: -20px;">
              Create an account to invest and earn interest on your principal and help a fellow student in need. Our dedicated team is here to support you every step of the way!
            </p>
          </div>

          <form id="registrationForm" action="register.php" method="POST">
  <div class="row mb-3">
    <div class="col-12 col-md-4 mb-3">
      <div class="form-floating">
        <input type="text" class="form-control form-control-sm" id="firstName" name="firstName" placeholder="First Name" style="font-size: 0.9rem;" required>
        <label for="firstName">First Name</label>
      </div>
    </div>
    <div class="col-12 col-md-4 mb-3">
      <div class="form-floating">
        <input type="text" class="form-control form-control-sm" id="middleName" name="middleName" placeholder="Middle Name" style="font-size: 0.9rem;" required>
        <label for="middleName">Middle Name</label>
      </div>
    </div>
    <div class="col-12 col-md-4 mb-3">
      <div class="form-floating">
        <input type="text" class="form-control form-control-sm" id="lastName" name="lastName" placeholder="Last Name" style="font-size: 0.9rem;" required>
        <label for="lastName">Last Name</label>
      </div>
    </div>
  </div>

  <div class="mb-3">
    <div class="form-floating">
      <input type="date" class="form-control form-control-sm" id="birthdate" name="birthdate" placeholder="Birthdate" style="font-size: 0.9rem;" required>
      <label for="birthdate">Birthdate</label>
    </div>
  </div>

  <div class="mb-3">
    <div class="form-floating">
      <input type="tel" class="form-control form-control-sm" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" style="font-size: 0.9rem;" required>
      <label for="phoneNumber">Phone Number</label>
    </div>
  </div>

  <div class="mb-3">
    <div class="form-floating">
      <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email address" style="font-size: 0.9rem;" required>
      <label for="email">Email address</label>
    </div>
  </div>

  <div class="mb-3">
    <div class="form-floating">
      <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password" style="font-size: 0.9rem;" required>
      <label for="password">Password</label>
    </div>
  </div>

  <div class="mb-3">
    <div class="form-floating">
      <input type="password" class="form-control form-control-sm" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" style="font-size: 0.9rem;" required>
      <label for="confirmPassword">Confirm Password</label>
    </div>
  </div>

  <div class="d-grid gap-2 mt-3">
    <button type="submit" class="btn btn-primary" id="submitBtn" style="background: #caac82; border-color: #caac82; font-size: 0.9rem;">Create Account</button>
    <a href="login.html" class="btn btn-outline-primary" style="color: #caac82; border-color: #caac82; font-size: 0.9rem;">Log In</a>
  </div>
</form>


         <!-- MODALS -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accountModalLabel" style="font-family: 'Times New Roman', Times, serif; color:#caac82;">Oops, one more thing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>To finish creating your account, please agree to the user terms and conditions:</p>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="agreeTerms">
          <label class="form-check-label" for="agreeTerms">I agree to the terms and conditions (required)</label>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="emailUpdates">
          <label class="form-check-label" for="emailUpdates">I want to receive updates about my loans and promotions via email (optional)</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="sendOtpBtn" style="background-color:#caac82; border: none;">Send OTP</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel Registration</button>
      </div>
    </div>
  </div>
</div>
          <!-- Terms Notice Modal -->
          <div class="modal fade" id="agreeTermsModal" tabindex="-1" aria-labelledby="agreeTermsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="agreeTermsModalLabel">Notice</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  You must agree to the terms and conditions to proceed.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
          </div>

          <!-- OTP Sent Modal -->
          <div class="modal fade" id="otpSentModal" tabindex="-1" aria-labelledby="otpSentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="otpSentModalLabel">Success</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  OTP has been sent to your email!
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="window.location.href='user_otp.html';">OK</button>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
  






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
  <script>
  document.getElementById('submitBtn').addEventListener('click', function(event) {
    // Prevent form submission to show the modal instead
    event.preventDefault();
    
    // Trigger modal when the "Create Account" button is clicked
    var accountModal = new bootstrap.Modal(document.getElementById('accountModal'));
    accountModal.show();
  });

  document.getElementById('sendOtpBtn').addEventListener('click', function() {
    var agreeTerms = document.getElementById('agreeTerms').checked;

    if (!agreeTerms) {
      // Show "Agree to Terms" modal
      var agreeTermsModal = new bootstrap.Modal(document.getElementById('agreeTermsModal'));
      agreeTermsModal.show();
    } else {
      // Close the account modal
      var accountModal = bootstrap.Modal.getInstance(document.getElementById('accountModal'));
      if (accountModal) {
        accountModal.hide();
      }

      // Submit the form to register.php to send the OTP
      document.getElementById('registrationForm').submit();
    }
  });
</script>

</body>

</html>