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
          <li><a href="login.php">Log-in</a></li>
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

              <form id="registrationForm" action="register_lender.php" method="POST">
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
        <a href="login.php" class="btn btn-outline-primary" style="color: #caac82; border-color: #caac82; font-size: 0.9rem;">Log In</a>
      </div>
    </form>


    <!-- MODALS -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accountModalLabel" style="font-family: 'Times New Roman', Times, serif; color:#caac82;">Oops, one more thing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>To finish creating your account, please agree to the user terms and conditions:</p>
        <h6>Terms and Conditions for Lenders</h6>
        <p>
          These Terms and Conditions govern the use by lenders of the Peer-to-Peer (P2P) Microloan Platform, hereinafter referred to as ScholarLend. By registering as a Lender on the Platform, you agree to comply with and be bound by the following terms. Please read them carefully before proceeding.
        </p>

        <h6>General Terms and Conditions</h6>
        <h6>Eligibility Requirements</h6>
        <ul>
          <li>You must be a bona fide student of Bicol University and at least 18 years of age to be bound by this contract.</li>
          <li>You must have a valid university ID and an active student number to verify your status as a student.</li>
          <li>You must have sufficient financial resources to fund loan applications of your desire.</li>
        </ul>

        <h6>Platform User Obligations</h6>
        <ul>
          <li>You agree to act in good faith and in accordance with ScholarLend's rules and regulations.</li>
          <li>You must not engage in any activity that could harm the reputation of ScholarLend or the student community.</li>
        </ul>

        <h6>Account Creation and Management</h6>
        <h6>Account Setup Information</h6>
        <p>
          In creating an account in ScholarLend, accurate and complete personal information must be provided as required during the registration process. You are responsible for updating changes in your account information.
        </p>

        <h6>Account Management</h6>
        <p>
          You are responsible for the management of your account login information and for all activities that occur under your account.
        </p>

        <h6>Lending Terms and Conditions</h6>
        <h6>Loan Selection</h6>
        <p>
          You reserve the right to choose a loan application to fund. Notifications of loan requests from students will be sent to your provided email address. You may review and assess the provided information on the website and choose to lend based on your own discretion.
        </p>

        <h6>Access to Borrower’s Information</h6>
        <p>
          In browsing loan applications, you will be provided all information necessary to make informed lending decisions, including loan details, payment terms, as well as credit score breakdown and academic transcript.
        </p>

        <h6>Loan Contract</h6>
        <p>
          A loan contract will be presented to you, and you will be required to electronically affix your signature to the contract after selecting a loan application to fund. The loan contract is between you, the borrower, and the intermediary (administrator). By affixing your signature, you acknowledge and consent that your personal information, including your name and payment details, will be disclosed to the other parties of the loan contract.
        </p>
        <p>
          The loan contract binds you to the conditions and details set forth in the contract, including commissions, interest earned, and modes and dates of payment applied for by the borrower.
        </p>

        <h6>Payments and Returns</h6>
        <p>
          Payments of loans will be sent directly to your account on the date indicated in the payment schedule. ScholarLend will charge a commission fee of 30% of the interest earned, which will be deducted automatically before the interest is credited to your account.
        </p>

        <h6>Risk Acknowledgement</h6>
        <h6>Credit Risk Understanding</h6>
        <p>
          Lending on ScholarLend involves credit risk or the possibility of loss due to the borrower’s non-repayment of the loan. You acknowledge and accept this risk by participating as a Lender.
        </p>

        <h6>Liability in Risk of Loss</h6>
        <p>
          The corporation’s liability for any loss incurred by lenders due to borrower default shall not exceed 25% of the outstanding amount, regardless of the circumstances.
        </p>

        <h6>Data Protection and Privacy Policy</h6>
        <h6>Data Collection and Usage</h6>
        <p>
          We collect and process your personal data to administer and manage your account in ScholarLend and for the platform’s database and administrative records. This may include but is not limited to your name, contact information, date of birth, and any other information provided on this form.
        </p>

        <h6>Data Security</h6>
        <p>
          We take the security of your personal data seriously. Your data will only be accessible to authorized officers for the purposes mentioned in this notice.
        </p>

        <h6>Amendment and Termination</h6>
        <h6>Amendments</h6>
        <p>
          ScholarLend reserves the right to amend these Terms and Conditions at any time. You will be notified of any changes, and continued use of ScholarLend constitutes acceptance of the revised terms.
        </p>

        <h6>Suspension and Termination</h6>
        <p>
          ScholarLend reserves the right to suspend or terminate your account if you violate these Terms and Conditions or engage in any fraudulent or harmful activity.
        </p>

        <p>
          By checking the box below, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions. If you do not agree with these terms, please do not use ScholarLend.
        </p>
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

          <!-- Age Restriction Modal -->
<div class="modal fade" id="ageModal" tabindex="-1" aria-labelledby="ageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ageModalLabel">Age Restriction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You must be at least 18 years old to create an account.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Password Mismatch Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Password Mismatch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Passwords do not match. Please try again.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Required Fields Alert -->
<div class="modal fade" id="requiredFieldsModal" tabindex="-1" aria-labelledby="requiredFieldsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requiredFieldsModalLabel">Missing Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Please fill out all required fields.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
  // Calculate the age based on the provided birthdate
  function calculateAge(birthdate) {
    const today = new Date();
    const birthDate = new Date(birthdate);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    return age;
  }

  // Form validation function
  function validateForm() {
    const birthdate = document.getElementById('birthdate').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    const inputs = document.querySelectorAll('#registrationForm input[required]');
    let formIsValid = true;

    // Check if any required field is empty
    inputs.forEach(function(input) {
      if (input.value.trim() === '') {
        input.classList.add('is-invalid'); // Optionally add visual feedback
        formIsValid = false;
      } else {
        input.classList.remove('is-invalid'); // Remove invalid class if field is filled
      }
    });

    if (!formIsValid) {
      // Show modal for missing information
      const requiredFieldsModal = new bootstrap.Modal(document.getElementById('requiredFieldsModal'));
      requiredFieldsModal.show();
      return false; // Prevent the form from proceeding if fields are empty
    }

    // Age validation
    if (birthdate) {
      const age = calculateAge(birthdate);
      if (age < 18) {
        const ageModal = new bootstrap.Modal(document.getElementById('ageModal'));
        ageModal.show();
        return false; // Prevent form from submitting if under 18
      }
    }

    // Password match validation
    if (password !== confirmPassword) {
      const passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
      passwordModal.show();
      return false; // Prevent form from submitting if passwords do not match
    }

    return true; // All checks passed
  }

  // Event listener for the submit button click
  document.getElementById('submitBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission

    if (validateForm()) {
      // Show account modal only if form is valid
      const accountModal = new bootstrap.Modal(document.getElementById('accountModal'));
      accountModal.show();
    }
  });

  // Event listener for sending OTP
  document.getElementById('sendOtpBtn').addEventListener('click', function() {
    const agreeTerms = document.getElementById('agreeTerms').checked;

    if (!agreeTerms) {
      // Show terms agreement modal if terms are not agreed
      const agreeTermsModal = new bootstrap.Modal(document.getElementById('agreeTermsModal'));
      agreeTermsModal.show();
    } else {
      // Hide the account modal if terms are agreed
      const accountModal = bootstrap.Modal.getInstance(document.getElementById('accountModal'));
      if (accountModal) {
        accountModal.hide();
      }

      // Submit the form if all checks passed
      document.getElementById('registrationForm').submit();
    }
  });
</script>



</body>

</html>