<?php
// Start output buffering
ob_start();

// Start the session
session_start();

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

// Check if the user is logged in
if (isset($_SESSION['first_name'])) {
    $firstName = $_SESSION['first_name'];
    $walletBalance = $_SESSION['wallet_balance']; // Get the wallet balance from the session

    // Fetch all posted loans
    $sql = "SELECT transaction_id, fname, course, loan_amount, loan_description FROM borrower_info WHERE status = 'posted'"; // Use fname in the query
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows == 0) {
        echo "<p>No loans found with posted status.</p>";
    }

    $borrowerLoans = [];
    while ($row = $result->fetch_assoc()) {
        $borrowerLoans[] = $row; // Store each loan in an array
    }
} else {
    $firstName = "User"; // Fallback in case the user is not logged in
    $walletBalance = 0; // Fallback value for wallet balance
    $borrowerLoans = []; // No loans if the user is not logged in
}
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
             
            </li>
      
            <!-- Balance Display -->
            <li class="nav-item d-flex align-items-center mx-3">
    <span style="font-size: 1.2rem; color: #323246; background-color: #dbbf94; border-radius: 10px; padding: 7px 17px; text-align: center; font-weight: bold;">
        ₱ <?php echo number_format($_SESSION['wallet_balance'], 2); ?> <!-- Display the wallet balance -->
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
        <h1 style="text-align: left; font-family:'Times New Roman', Times, serif;">
        Welcome back, <span style="color: #dbbf94;"><?php echo htmlspecialchars($firstName); ?></span>
    </h1>
          <h1 class="mt-4" style="text-align: left; font-weight:400;">Recommended loans for you</h1>
        </div>
      </div>
  
      <div id="loanCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
          <!-- First Slide (active) -->
          <div class="carousel-item active">
            <div class="row">



            <?php foreach ($borrowerLoans as $loan): ?>
        <div class="col-12 col-md-4 mb-4">
            <div class="card h-100">
                <div class="image-container">
                    <img src="assets/img/hero-bg.jpg" class="card-img-top" alt="Loan">
                    <div class="overlay">
                        <p><i class="bi bi-book"></i> <?php echo htmlspecialchars($loan['course']); ?></p>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">Transaction ID: <?php echo htmlspecialchars($loan['transaction_id']); ?></p> <!-- Display transaction ID -->
                    <p class="card-text">Php <?php echo number_format($loan['loan_amount'], 2); ?> is requested by <?php echo htmlspecialchars($loan['fname']); ?> to meet their financial needs. (<?php echo htmlspecialchars($loan['loan_description']); ?>)</p>

                    <div class="mt-auto text-end">
                    <a href="lenderviewloan.php?transaction_id=<?php echo htmlspecialchars($loan['transaction_id']); ?>&fname=<?php echo urlencode($loan['fname']); ?>&loan_description=<?php echo urlencode($loan['loan_description']); ?>&loan_amount=<?php echo urlencode($loan['loan_amount']); ?>" class="btn btn-primary" style="background-color: #131E3D;">View Loan</a>


                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>



             
      
        <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#loanCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#loanCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      
      
      
  
      <div class="mt-1">
        <div class="row">
          <div class="col-12 col-md-4 mb-3">
            <div class="mb-3">
              <label for="purpose" class="form-label">Purpose</label>
              <select id="purpose" class="form-select">
                <option value="home">Home</option>
                <option value="education">Education</option>
                <option value="business">Business</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select id="gender" class="form-select">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <div class="d-flex align-items-center">
              <div class="flex-grow-1 me-2">
                <label for="courses" class="form-label">Courses</label>
                <select id="courses" class="form-select">
                  <option value="course1">Course 1</option>
                  <option value="course2">Course 2</option>
                  <option value="course3">Course 3</option>
                </select>
              </div>
              <button type="button" class="btn btn-primary" style="margin-top: 30px; background-color: #caac82; border-color: #caac82;">Filter Loans</button>
            </div>
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