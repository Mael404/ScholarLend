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
          <!-- edit for borrower -->
          <p>To finish creating your account, please agree to the user terms and conditions:</p>
<h6>Terms and Conditions for Borrowers</h6>
<p>
  These Terms and Conditions govern the use of the Peer-to-Peer (P2P) Microloan Platform (hereinafter referred to as the "ScholarLend") by borrowers ("you" or "Borrower"). By registering as a Borrower on the Platform, you agree to comply with and be bound by the following terms. Please read them carefully before proceeding.
</p>

<h6>GENERAL TERMS AND CONDITIONS</h6>
<h6>Eligibility Requirements</h6>
<ul>
  <li>You must be a bona fide student of Bicol University and at least 18 years of age to be bound by this contract.</li>
  <li>You must have a valid university ID and an active student number to verify your status as a student.</li>
</ul>

<h6>Platform User Obligations</h6>
<ul>
  <li>You agree to act in good faith and in accordance with ScholarLend's rules and regulations.</li>
  <li>You must not engage in any activity that could harm the reputation of ScholarLend or the student community.</li>
</ul>

<h6>ACCOUNT CREATION AND MANAGEMENT</h6>
<h6>Account Setup Information</h6>
<p>
  In creating an account in ScholarLend, accurate and complete personal information must be provided as required during the registration process. You are responsible for updating changes in your account information.
</p>

<h6>Account Management</h6>
<p>
  You are responsible for the management of your account login information and for all activities that occur under your account.
</p>

<h6>BORROWING TERMS AND CONDITION</h6>
<h6>Loan Application</h6>
<p>
  In submitting a loan application, you must provide accurate and complete personal information, financial information, loan information, payment details as required in the application form. You have the right to select a loan amount ranging from P500 to P5000 and select your preferred payment schedule.
</p>
<p>
  For installment loans with daily payments, you are required to borrow for a minimum period of 5 days, meaning you cannot select a repayment schedule with fewer than 5 daily payments.
</p>
<p>
  When applying for a loan application, you are required to pay a transaction fee of PHP 15.00. This fee will be deducted from the proceeds you will receive at the time of the loan disbursement.
</p>

<h6>Access to your Information</h6>
<p>
  Lenders will be notified of your loan application. Loan pertinent information will be made available to the lender to allow him/her to make informed loan decisions. This includes loan details, payment terms, credit score breakdown, and academic transcript.
</p>

<h6>Loan Contract</h6>
<p>
  A loan contract will be presented to you, and you will be required to electronically affix your signature to the contract prior to submitting your application for review and approval.
</p>
<p>
  You acknowledge and agree that the lender who will fund your loan application shall be the other party to this contract. You further agree that the identity of this party will be disclosed to you only after the loan has been successfully disbursed.
</p>
<p>
  By affixing your signature, you acknowledge and consent that your personal information, including your name, address, loan details, and payment information will be made available to other parties of the contract.
</p>
<p>
  The loan contract binds you to repay the loan in accordance with the terms specified in the loan agreement, including the payment of interest as outlined therein. You further agree to abide by the details and conditions set forth in the loan application you have submitted.
</p>
<p>
  Any violation of the terms and conditions of the loan contract, including failure to make timely repayments or misrepresentation of information, will constitute a breach of contract, which may result in legal action and penalties.
</p>

<h6>Loan Repayment</h6>
<p>
  You must strictly comply with the repayment schedule of your loan. You must ensure that after paying your outstanding balance, upload the GCash receipt for verification.
</p>
<p>
  ScholarLend will notify you of upcoming repayment deadlines and allow you to track your repayment progress.
</p>
<p>
  Failure to pay on time will constitute a surcharge of an amount double the interest to be paid for that scheduled payment date.
</p>
<p>
  Payment of an installment in advance will still require you to pay the interest that would have accrued up to the scheduled payment date.
</p>
<p>
  If you choose to make an early lump-sum payment, you will be required to pay the principal, interest, and an early payment fee of 5% of the outstanding balance, as this alters the agreed-upon payment terms and ensures the lender receives the expected interest.
</p>

<h6>DATA PROTECTION AND PRIVACY POLICY</h6>
<h6>Data Collection and Usage</h6>
<p>
  We collect and process your personal data to administer and manage your account in ScholarLend and for the platform’s database and administrative records. This may include but is not limited to your name, contact information, date of birth, and any other information provided on this form.
</p>

<h6>Data Security</h6>
<p>
  We take the security of your personal data seriously. Your data will only be accessible to authorized officers for the purposes mentioned in this notice.
</p>

<h6>Data Retention</h6>
<p>
  Your personal data will be retained for as long as necessary to fulfill the purposes outlined in this notice or as required by applicable laws and regulations.
</p>

<h6>Data Sharing</h6>
<p>
  We will not sell, lease, or otherwise distribute your personal data to third parties for marketing or other unrelated purposes without your explicit consent.
</p>

<h6>Your Rights</h6>
<p>
  You have the right to request access to, correction of, or deletion of your personal data held by us. You may also request to limit the processing of your data or withdraw your consent at any time.
</p>

<h6>AMENDMENT AND TERMINATION</h6>
<h6>Amendments</h6>
<p>
  ScholarLend reserves the right to amend these Terms and Conditions at any time. You will be notified of any changes, and continued use of the ScholarLend constitutes acceptance of the revised terms.
</p>

<h6>Suspension and Termination</h6>
<p>
  ScholarLend reserves the right to suspend or terminate your account if you violate these Terms and Conditions or engage in any fraudulent or harmful activity.
</p>

<p>
  By checking the box below, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions. If you do not agree with these terms, please do not use the Platform.
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