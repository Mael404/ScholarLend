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


  <style>/* CSS */

    /* Customize the background color and border */
    .mobile-nav-toggle {
      background-color: #e5d8c7; /* Custom color */
      border:none; /* Custom border color */
      border-radius: 8px; /* Rounded corners */
      padding: 10px 15px; /* Adjust padding */
      display: flex;
      align-items: center;
      justify-content: center;
      
    }
    
    /* Change the icon color */
    .mobile-nav-toggle i {
      color: #323246; /* Custom icon color */
      font-size: 1.5rem; /* Custom icon size */
    }
    
    /* Add hover and focus effects */
    .mobile-nav-toggle:hover,
    .mobile-nav-toggle:focus {
      background-color:#e5d8c7; /* Lighter background color on hover/focus */
      border-color: #e5d8c7; /* Lighter border color on hover/focus */
      border: none;
    }
    
    /* Optional: Add transition effect */
    .mobile-nav-toggle {
      transition: background-color 0.3s, border-color 0.3s;
    }
  /* CSS */
  
  /* Default styles for desktop view */
  .navmenu {
    display: flex;
    justify-content: center;
    width: 100%;
  }

  .input-group {
    width: 100%;
  }

  /* Ensure the search bar resizes */
  @media (max-width: 576px) {
    .input-group {
      max-width: 100%;
    }
  }

  /* Mobile styles */
  @media (max-width: 991.98px) {
    #navbarContent {
      display: block;
    }

    #navbarContent ul {
      display: block;
      text-align: center;
      padding: 0;
      margin: 0;
    }

    .nav-item {
      margin: 10px 0;
    }

    .mobile-nav-toggle {
      position: absolute;
      top: 15px;
      right: 15px;
      z-index: 1000;
    }
  }
  
  .dropdown-container {
    margin-top: -20px; /* Adjust this value to move the dropdown section closer to the carousel */
  }
    

  .image-container {
  position: relative;
}

.overlay {
  position: absolute;
  bottom: 20px; /* Adjust position as needed */
  left: 15px;
  background-color: white;
  padding: 1.5px 11px;
  border-radius: 10px;
  display: flex;
  align-items: center;
}

.overlay p {
  margin: 0;
  font-size: 14px;
}

.overlay i {
  margin-right: 8px;
  font-size: 18px;
}

.btn-custom {
  background-color: #131E3D;
  color: white;
}

    </style>
</head>

<body class="starter-page-page">

  <header id="header" class="header d-flex align-items-center sticky-top" style="background-color: #f4f1ec; border-bottom: 3px solid #d9d9d9;">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      
      <a href="index.html" class="logo d-flex align-items-center">
        <h1 class="sitename" style="font-size: 3rem; font-weight: bold; text-decoration: none; font-family: 'Times New Roman', Times, serif; color: #caac82;">
          Scholar<span style="color: #323246;">Lend</span>
        </h1>
      </a>
  
      <nav id="navmenu" class="navmenu d-flex justify-content-center align-items-center">
        <div class="collapse d-xl-flex" id="navbarContent">
          <ul class="d-flex align-items-center flex-column flex-xl-row">
            <!-- Search Bar with Icon Inside -->
            <li class="nav-item d-flex align-items-center mx-3">
              <div class="input-group">
                
                <div class="position-relative">
                  <i class="bi bi-search position-absolute" style="top: 50%; left: 10px; transform: translateY(-50%); color: gray;"></i>
                  <input type="text" class="form-control pl-4" placeholder="Find a loan" aria-label="Search" style="padding-left: 35px; width: 400px; border-radius: 2px; border-color: #998e7f;">
                </div>
                
              </div>
              
            </li>
      
            <!-- About Dropdown -->
            <li class="nav-item dropdown mx-3">
              <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                About
              </a>
              <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                <li><a class="dropdown-item" href="#">Our Story</a></li>
                <li><a class="dropdown-item" href="#">Team</a></li>
                <li><a class="dropdown-item" href="#">Contact</a></li>
              </ul>
            </li>
      
            <!-- Balance Display -->
            <li class="nav-item d-flex align-items-center mx-3">
              <span style="font-size: 1.2rem; color: #323246; background-color: #dbbf94; border-radius: 10px; padding: 7px 17px; text-align: center; font-weight: bold;">
                ₱ 00.00
              </span>
            </li>
            
      
            <li class="nav-item d-flex align-items-center mx-3">
              <div style="background-color: black; border-radius: 50%; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                <i class="bi bi-person" style="font-size: 1.5rem; color: white;"></i>
              </div>
            </li>
            
            
          </ul>
        </div>
        <button class="mobile-nav-toggle d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="bi bi-list"></i>
        </button>
      </nav>
      
  
    </div>
  </header>

  <main class="main" style="margin-top: -90px; background-color: #f4f1ec;">

    <section class="container mt-5" style="background-color: #f4f1ec;" >
      <div class="row">
        <div class="col-12 text-center">
          <h1 style="text-align: left; font-family:'Times New Roman', Times, serif;">Welcome back, <span style="color: #dbbf94;">Username</span></h1>
          <h1 class="mt-4" style="text-align: left; font-weight:400;">Recommended loans for you</h1>
        </div>
      </div>
  
      <div id="loanCarousel" class="carousel slide mt-4">
        <div class="carousel-inner">
          <!-- First Slide (active) -->
          <div class="carousel-item active">
            <div class="row">
              <!-- First Card -->
<div class="col-12 col-md-4 mb-4">
  <div class="card h-100">
    <div class="image-container">
      <img src="assets/img/hero-bg.jpg" class="card-img-top" alt="Step 1">
    </div>
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">Step 1: Apply for a loan</h5>
      <p class="card-text">
        Answer a few questions about you. Indicate your intended loan amount, choose a payment schedule, and submit your application.
      </p>
    </div>
  </div>
</div>

<!-- Second Card -->
<div class="col-12 col-md-4 mb-4">
  <div class="card h-100">
    <div class="image-container">
      <img src="assets/img/hero-bg.jpg" class="card-img-top" alt="Step 2">
    </div>
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">Step 2: Wait for loan acceptance</h5>
      <p class="card-text">
        We will review your application and connect your loans to interested lenders.
      </p>
    </div>
  </div>
</div>

<!-- Third Card -->
<div class="col-12 col-md-4 mb-4">
  <div class="card h-100">
    <div class="image-container">
      <img src="assets/img/hero-bg.jpg" class="card-img-top" alt="Step 3">
    </div>
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">Step 3: Receive your cash</h5>
      <p class="card-text">
        Upon approval and acceptance, you’ll receive your loan in your e-wallet and conveniently withdraw your cash!
      </p>
    </div>
  </div>
</div>

<!-- Apply Now Button -->
<div class="text-center mt-4">
  <a href="dashboard/borrower_applicationform.php" class="btn btn-primary" style="background-color: #131E3D; padding: 15px 40px; font-size: 1.15rem; border: none;">
    Apply Now <i class="bi bi-chevron-right" style="margin-left: 10px; font-size: 1.25rem;"></i>
  </a>
</div>






            </div>
          </div>
      
          <!-- Second Slide -->
          <div class="carousel-item">
            <div class="row">
           
            </div>
          </div>
        </div>
      
      
      
      
  


    </section>


  </main>
  
  
  


  <div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">ScholarLend</strong> <span>All Rights Reserved</span></p>
   
  </div>
  


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