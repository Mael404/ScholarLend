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

<!-- Registration Section -->
<section id="registration-section" class="registration-section section" style="background-color: #f1eee9; padding: 1rem 0;">

    <!-- Registration Form -->
    <div class="container d-flex justify-content-center" style="margin-top: 30px;">
      <div class="col-12 col-md-8 col-lg-6"> <!-- Adjusted column size for different screen sizes -->
        <div class="card p-3" style="border: 1px solid #d4b891; border-radius: 8px;">
          <div class="card-body">
            <h3 class="card-title text-center mb-4" style="font-family: 'Times New Roman', Times, serif; font-weight: 560; font-size: 1.5rem;">
              <span style="color: #caac82;">Welcome to Scholar</span><span style="color: black;">Lend</span>
            </h3>
            <div><p style="text-align: center; margin-top: -20px;">Create an account to invest and earn interest on your principal and help
              a fellow student in need. Our dedicated team is here to support you every step of the way!
            </p></div>
            <form>
              <div class="row mb-3">
                <div class="col-12 col-md-4 mb-3">
                  <div class="form-floating">
                    <input type="text" class="form-control form-control-sm" id="firstName" placeholder="First Name" style="font-size: 0.9rem;">
                    <label for="firstName">First Name</label>
                  </div>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <div class="form-floating">
                    <input type="text" class="form-control form-control-sm" id="middleName" placeholder="Middle Name" style="font-size: 0.9rem;">
                    <label for="middleName">Middle Name</label>
                  </div>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <div class="form-floating">
                    <input type="text" class="form-control form-control-sm" id="lastName" placeholder="Last Name" style="font-size: 0.9rem;">
                    <label for="lastName">Last Name</label>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="date" class="form-control form-control-sm" id="birthdate" placeholder="Birthdate" style="font-size: 0.9rem;">
                  <label for="birthdate">Birthdate</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="email" class="form-control form-control-sm" id="email" placeholder="Email address" style="font-size: 0.9rem;">
                  <label for="email">Email address</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" style="font-size: 0.9rem;">
                  <label for="password">Password</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="password" class="form-control form-control-sm" id="confirmPassword" placeholder="Confirm Password" style="font-size: 0.9rem;">
                  <label for="confirmPassword">Confirm Password</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="file" class="form-control form-control-sm" id="selfie" style="font-size: 0.9rem;">
                  <label for="selfie">Upload a Selfie</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <input type="file" class="form-control form-control-sm" id="id" style="font-size: 0.9rem;">
                  <label for="id">Upload a Valid ID</label>
                </div>
              </div>
              <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-primary" style="background: #caac82; border-color: #caac82; font-size: 0.9rem;">Create Account</button>
                <button type="button" class="btn btn-outline-primary" style="color: #caac82; border-color: #caac82; font-size: 0.9rem;">Log In</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Registration Form -->
  
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

</body>

</html>