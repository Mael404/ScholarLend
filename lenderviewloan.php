<?php
// Start the session
session_start();

include 'condb.php';
$transaction_id = $_GET['transaction_id']; // Assuming transaction_id is passed via GET request

// Retrieve borrower information from borrower_info table
$query = "SELECT created_at, total_amount, payment_frequency, days_to_next_deadline,next_deadlines, fname, lname, course, career_goals,
          yearofstudy, gwa, school_community, spending_pattern, loan_amount, loan_purpose, monthly_allowance, 
          source_of_allowance, monthly_expenses
          FROM borrower_info WHERE transaction_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $transaction_id);
$stmt->execute();
$result = $stmt->get_result();
$loan = $result->fetch_assoc(); // Fetching the loan details

// Set the variables from the fetched data
$fname = htmlspecialchars($loan['fname'] ?? "Unknown Borrower");
$lname = htmlspecialchars($loan['lname'] ?? ""); // Assuming lname is also fetched
$course = htmlspecialchars($loan['course'] ?? "Course not specified");
$career_goals = htmlspecialchars($loan['career_goals'] ?? "No goals specified.");
$total_amount = (int) ($loan['total_amount'] ?? 0);
$days_to_next_deadline = (int) ($loan['days_to_next_deadline'] ?? 0);

// Reintroducing loan description and loan amount for displaying
if (isset($_GET['loan_description'], $_GET['loan_amount'])) {
    $loan_description = htmlspecialchars($_GET['loan_description']); // Sanitize the input
    $loan_amount = htmlspecialchars($_GET['loan_amount']); // Sanitize the input
} else {
    // Default values if parameters are missing
    $loan_description = "No description available.";
    $loan_amount = "0.00"; // Default value
}

// Initialize credit score and criteria-specific scores
$credit_score = 0;
$yearsofstudy_score = 0;
$gwa_score = 0;
$school_community_score = 0;
$spending_pattern_score = 0;
$loan_purpose_score = 0;
$loan_amount_score = 0;
$monthly_allowance_score = 0;
$source_of_allowance_score = 0;
$expense_score = 0;

// Calculate the credit score based on year of study
$yearsofstudy = $loan['yearofstudy'];
switch ($yearsofstudy) {
    case '4th year': $yearsofstudy_score = 7; break;
    case '3rd year': $yearsofstudy_score = 6; break;
    case '2nd year': $yearsofstudy_score = 5; break;
    case '1st year': $yearsofstudy_score = 4; break;
}
$credit_score += $yearsofstudy_score;

// Calculate the score based on GWA
$gwa = (float) $loan['gwa'];
if ($gwa >= 1.0 && $gwa <= 1.4) {
    $gwa_score = 8;
} elseif ($gwa >= 1.5 && $gwa <= 1.7) {
    $gwa_score = 7;
} elseif ($gwa >= 1.8 && $gwa <= 2.5) {
    $gwa_score = 6;
} elseif ($gwa >= 2.6 && $gwa <= 2.8) {
    $gwa_score = 5;
} elseif ($gwa >= 2.9 && $gwa <= 3.0) {
    $gwa_score = 4;
} elseif ($gwa >= 3.1 && $gwa <= 4.0) {
    $gwa_score = 3;
} else {
    $gwa_score = 2;
}
$credit_score += $gwa_score;

// Calculate the score based on school community
$school_community = strtolower($loan['school_community']);
$school_community_score = ($school_community === 'no') ? 4 : 5;
$credit_score += $school_community_score;

// Calculate the score based on spending pattern
$spending_pattern = strtolower($loan['spending_pattern']);
$spending_pattern_score = ($spending_pattern === 'regular expenses') ? 10 : 8;
$credit_score += $spending_pattern_score;

// Calculate the score based on loan purpose
$loan_purpose = strtolower($loan['loan_purpose']);
$loan_purpose_score = ($loan_purpose === 'directly attributable to studying' || $loan_purpose === 'overhead to studying') ? 10 : (($loan_purpose === 'general') ? 8 : 0);
$credit_score += $loan_purpose_score;

// Calculate the score based on monthly expenses
$monthly_expenses = strtolower($loan['monthly_expenses']);
switch ($monthly_expenses) {
    case 'below 1,000': $expense_score = 20; break;
    case '1,001 - 3,000': $expense_score = 19; break;
    case '3,001 - 5,000': $expense_score = 18; break;
    case '5,001 - 7,000': $expense_score = 17; break;
    case '7,001 - 9,000': $expense_score = 16; break;
    case '9,001 - 11,000': $expense_score = 15; break;
    case 'above 11,000': $expense_score = 14; break;
    default: $expense_score = 0;
}
$credit_score += $expense_score;

// Calculate the score based on loan amount
$loan_amount = (int) $loan['loan_amount'];
if ($loan_amount == 500 || $loan_amount == 1000) {
    $loan_amount_score = 10;
} elseif ($loan_amount == 2000) {
    $loan_amount_score = 9;
} elseif ($loan_amount == 3000) {
    $loan_amount_score = 8;
} elseif ($loan_amount == 4000) {
    $loan_amount_score = 7;
} else {
    $loan_amount_score = 6;
}
$credit_score += $loan_amount_score;

// Calculate the score based on monthly allowance
$monthly_allowance = strtolower($loan['monthly_allowance']);
switch ($monthly_allowance) {
    case 'above 11,000': $monthly_allowance_score = 20; break;
    case '9,001 - 11,000': $monthly_allowance_score = 19; break;
    case '7,001 - 9,000': $monthly_allowance_score = 18; break;
    case '5,001 - 7,000': $monthly_allowance_score = 17; break;
    case '3,001 - 5,000': $monthly_allowance_score = 16; break;
    case '1,001 - 3,000': $monthly_allowance_score = 15; break;
    case 'below 1,000': $monthly_allowance_score = 14; break;
    default: $monthly_allowance_score = 0;
}
$credit_score += $monthly_allowance_score;

// Calculate the score based on source of allowance
$source_of_allowance = strtolower($loan['source_of_allowance']);
$source_of_allowance_score = ($source_of_allowance === 'own business' || $source_of_allowance === 'parental support') ? 10 : (($source_of_allowance === 'scholarships') ? 9 : (($source_of_allowance === 'part-time job') ? 8 : 0));
$credit_score += $source_of_allowance_score;

// Determine credit score category
$credit_category = '';
if ($credit_score >= 90) {
    $credit_category = 'Excellent';
} elseif ($credit_score >= 80) {
    $credit_category = 'Very Good';
} elseif ($credit_score >= 70) {
    $credit_category = 'Good';
} elseif ($credit_score >= 51) {
    $credit_category = 'Fair';
} else {
    $credit_category = 'Poor';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Scholarlend</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

   <link href="assets/img/fslogo.png" rel="icon">
  <link href="assets/img/fslogo.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
   <style>
    .go-back-btn {
    background-color: transparent; /* No background */
    color: #FDD7A3; /* Light orange text */
    border: none; /* No border */
    font-size: 18px; /* Adjust font size as needed */
    display: flex; /* Align icon and text */
    align-items: center;
    cursor: pointer; /* Pointer cursor for better UX */
    font-family: 'Arial', sans-serif; /* Clean font */
    position: absolute; /* Position relative to parent section */
    top: 20px; /* Distance from top */
    left: 20px; /* Distance from left */
    z-index: 10; /* Ensure it appears above other elements */
}

.go-back-icon {
    margin-right: 8px; /* Space between the arrow and text */
    font-size: 18px; /* Arrow size */
}

.go-back-btn:hover {
    text-decoration: underline; /* Add underline effect on hover */
}

     .gcash-title {
      font-size: 24px;
      color: #caaa82;
      font-weight: bold;
      text-align: left;
    }

    .instructions {
      text-align: left;
      margin-top: 10px;
    }

    .btn-complete {
      background-color: #caaa82;
      color: white;
      font-weight: bold;
    }

    .btn-complete:hover {
      background-color: #b08e6e;
    }

    .gcash-qr {
      width: 100%;
      max-width: 200px;
      margin: auto;
    }

    .upload-section {
      margin-top: 20px;
    }

    .back-link {
      color: #caaa82;
      font-weight: bold;
      margin-top: 10px;
      display: inline-block;
    }
   </style>
</head>

<body class="starter-page-page">

  <main class="main">

    <section id="hero" class="hero section light-background" style="position: relative; background-image: url('assets/img/hero-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">
      
        <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #131e3d; opacity: 0.7;"></div>
     <!-- Add the Go Back button -->
     <button class="go-back-btn" onclick="redirectToLender()">
    <i class="fas fa-arrow-left go-back-icon"></i> Go Back
</button>

        <div class="container mt-5">
      
    <!-- Borrower Profile Section -->
    <div class="row">
    <div class="col-12 col-md-8 mb-4">
    
 
    
    <div class="borrower-profile card p-4" style="border-radius: 10px; background-color: #fff; min-height: 400px; position: relative; display: flex; flex-direction: column;">
    <div class="d-flex align-items-center mb-3 position-relative">
        <!-- Image container with overlay -->
        <div style="width: 60px; height: 60px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; border-radius: 50%;">
    <i class="fas fa-user" style="font-size: 40px; color: #333;"></i>
</div>
        <div class="ms-3">
        <?php
// Define the function in this file directly
function maskName($name) {
    $length = strlen($name);
    if ($length <= 2) {
        return $name; // Don't mask if the name is too short
    }
    $first = $name[0];
    $last = $name[$length - 1];
    $middle = substr($name, 1, $length - 2);

    // Mask the middle characters, keeping the first and last character
    $maskedMiddle = str_repeat('*', strlen($middle));
    return $first . $maskedMiddle . $last;
}
?>

<h5><?php echo htmlspecialchars(maskName($fname)); ?></h5>

            <p class="text-muted mb-0"><?php echo $course; ?></p>
        </div>
    </div>
    <p><?php echo $loan_description; ?></p>
    
    <!-- Tags -->
    <div class="d-flex mt-auto">
        <span class="badge bg-light text-dark me-2" style="padding: 10px; border-radius: 20px;">
            <i class="fas fa-graduation-cap"></i> <?php echo $course; ?>
        </span>
        <span class="badge bg-light text-dark" style="padding: 10px; border-radius: 20px;">
            Expenses
        </span>
    </div>
</div>


    </div>

    <!-- Help Fund Section -->
  
    <div class="col-12 col-md-4">
    <div class="help-fund card p-4" style="background-color: #fff; border-radius: 10px; font-weight:bolder;">
        <h5>Help fund this loan</h5>
        
        <!-- Open Confirmation Box Button -->
        <div class="input-group mt-3">
            <input type="text" class="form-control" value="<?php echo $loan_amount; ?>" readonly>
            <button type="button" class="btn" style="background-color: #dbbf94; color: #323246; border: none; margin-left: 10px;" onclick="showConfirmationBox()">
                Lend now
            </button>
        </div>
        
        <button class="btn mt-3" style="background-color: #192a4d; color: white; width: 100%;">Invest funds</button>

        <!-- Borrower Profile and Loan Details -->
        <div class="d-flex justify-content-between align-items-center mt-4" style="color: #dbbf94;">
            <span data-bs-toggle="modal" data-bs-target="#borrowerProfileModal" style="cursor: pointer;">
                <i class="fas fa-user" style="color: black;"></i> Borrower Profile
            </span>
            <span data-bs-toggle="modal" data-bs-target="#loanDetailsModal" style="cursor: pointer;">
                <i class="fas fa-bars" style="color: black;"></i> Loan details
            </span>
        </div>
    </div>
</div>

<!-- Custom Confirmation Dialog with Larger Size -->
<div id="confirmationBox" style="display: none; background-color: rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; align-items: center; justify-content: center; z-index: 9999;">
    <div style="background-color: white; padding: 40px; border-radius: 10px; width: 500px; text-align: center;">
        <h5 style="font-size: 24px; font-weight: bold; color: #131e3d;">Confirm Payment</h5>
        <p style="font-size: 18px; color: #333; margin: 10px 0;">Are you sure you want to proceed with the payment?</p>
        <!-- GCash QR Code Image -->
        <img src="https://businessmaker-academy.com/cms/wp-content/uploads/2022/04/Gcash-BMA-QRcode.jpg" alt="GCash QR Code" class="gcash-qr mb-3" style="max-width: 65%; height: auto; border-radius: 10px; max-height: 350px;">
        
        <!-- Form inside the confirmation box -->
        <form id="lendForm" method="post" action="process_lend.php" enctype="multipart/form-data">
            <!-- Hidden input fields for loan_amount and transaction_id -->
            <input type="hidden" name="loan_amount" value="<?php echo $loan_amount; ?>">
            <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
            
            <div>
                <button type="submit" id="confirmBtn" name="lendNow" style="background-color: #131e3d; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; margin: 10px;">Confirm</button>
                <button type="button" onclick="hideConfirmationBox()" style="background-color: #cdad7d; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; margin: 10px;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript to handle the custom confirmation box -->
<script>
    function showConfirmationBox() {
        document.getElementById("confirmationBox").style.display = "flex";
    }

    function hideConfirmationBox() {
        document.getElementById("confirmationBox").style.display = "none";
    }
</script>

<!-- Borrower Profile Modal -->
<div class="modal fade" id="borrowerProfileModal" tabindex="-1" aria-labelledby="borrowerProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="borrowerProfileModalLabel">Borrower Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5><?php echo htmlspecialchars($fname); ?> <?php echo htmlspecialchars($lname); ?></h5>
        <p class="text-muted"><?php echo htmlspecialchars($course); ?></p>

        <h6>Career goals and plans</h6>
        <p><?php echo htmlspecialchars($career_goals); ?></p>
        
        <h6>Access documents here:</h6>
        <ul>
          <li><a href="#" data-bs-toggle="modal" data-bs-target="#creditScoreModal">Credit Score Breakdown</a></li>
          <li><a href="#">Academic Transcript</a></li>
        </ul>
      </div>
     
    </div>
  </div>
</div>
<style>
  /* Style for the credit score modal */
  #creditScoreModal p {
    font-size: 1.2rem; /* Slightly larger font for better readability */
    font-weight: 500;  /* Semi-bold text for emphasis */
    margin-bottom: 10px; /* Space between paragraphs */
    color: #333; /* Neutral text color */
  }

  #creditScoreModal #score-value {
    font-weight: bold; /* Highlight the credit score value */
    color: #0056b3; /* Matches the active card background color */
  }

  #creditScoreModal canvas {
    margin-top: 20px; /* Add space above the bar chart */
  }
</style>

<div class="modal fade" id="creditScoreModal" tabindex="-1" aria-labelledby="creditScoreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creditScoreModalLabel">Credit Score Breakdown</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Total Credit Score: <span id="score-value"><?php echo $credit_score; ?></span></p>
        <p>Credit Score Category: <?php echo $credit_category; ?></p>

        <!-- Bar Chart Container -->
        <canvas id="creditScoreBarChart" width="200" height="100"></canvas>
      </div>
     
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("creditScoreBarChart").getContext("2d");
    const score = <?php echo $credit_score; ?>;

    // Determine color based on score
    let color;
    if (score >= 90) {
      color = "#50C878"; // Green for Excellent
    } else if (score >= 80) {
      color = "#50C878"; // Green for Very Good
    } else if (score >= 70) {
      color = "#f9ca24"; // Yellow for Good
    } else if (score >= 51) {
      color = "#f0932b"; // Orange for Fair
    } else {
      color = "#eb4d4b"; // Red for Poor
    }

    // Initialize the chart
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Credit Score"],
        datasets: [{
          label: "Score",
          data: [score],
          backgroundColor: color,
          borderWidth: 1
        }]
      },
      options: {
        indexAxis: 'y', // Makes the bar horizontal
        scales: {
          x: {
            min: 0,
            max: 100
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  });
</script>


<!-- Loan Details Modal -->
<div class="modal fade" id="loanDetailsModal" tabindex="-1" aria-labelledby="loanDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
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
                  $frequency = strtolower($loan['payment_frequency']);
                  $days_to_next_deadline = $loan['days_to_next_deadline'];
                  switch ($frequency) {
                      case 'daily': $label = 'Days'; break;
                      case 'weekly': $label = 'Weeks'; break;
                      case 'monthly': $label = 'Months'; break;
                      default: $label = 'Days';
                  }
                  echo $days_to_next_deadline . ' ' . $label;
              ?>
            </span>
          </li>
          <li><strong>Frequency of payment</strong> <span style="float: right;"><?php echo ucfirst($loan['payment_frequency']); ?></span></li>
          <li><strong>Amount paid per installment</strong> <span style="float: right;">₱<?php echo number_format($loan['total_amount'], 2); ?></span></li>
          <li><strong>Is the borrower paying interest?</strong> <span style="float: right;">Yes</span></li>
        </ul>
        <!-- Repayment Schedule Link -->
        <div style="margin-top: 20px;">
        <a href="#" id="detailedRepaymentSchedule" style="color: #dbbf94; font-weight: bold; text-decoration: none;">
  DETAILED REPAYMENT SCHEDULE
  <i class="bi bi-chevron-right" style="margin-left: 0px; font-weight: bold; font-size: 1.0rem;"></i>
</a>

        </div>
      </div>
     
    </div>
  </div>
</div>

<div class="modal fade" id="repaymentScheduleModal" tabindex="-1" aria-labelledby="repaymentScheduleLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="repaymentScheduleLabel">Detailed Repayment Schedule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Total Amount</th>
              <th>Next Deadline</th>
            </tr>
          </thead>
          <tbody id="repaymentScheduleTableBody">
            <!-- Rows will be dynamically inserted here via JavaScript -->
          </tbody>
        </table>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

   <script>
document.addEventListener("DOMContentLoaded", function () {
  const repaymentLink = document.querySelector("#detailedRepaymentSchedule");
  const repaymentTableBody = document.querySelector("#repaymentScheduleTableBody");

  repaymentLink.addEventListener("click", function (event) {
    event.preventDefault();

    // Show the modal
    const repaymentModal = new bootstrap.Modal(document.querySelector("#repaymentScheduleModal"));
    repaymentModal.show();

    // Make AJAX request to fetch the repayment schedule and total amount
    const transactionId = <?php echo json_encode($transaction_id); ?>;

    fetch(`fetch_repayment_schedule.php?transaction_id=${transactionId}`)
      .then((response) => response.json())
      .then((data) => {
        // Clear existing rows
        repaymentTableBody.innerHTML = "";

        if (data.next_deadlines) {
          // Split next_deadlines into an array of dates
          const deadlines = data.next_deadlines.split(", ");

          // Generate table rows
          deadlines.forEach((deadline) => {
            const row = document.createElement("tr");

            // Format the date into text format
            const dateObj = new Date(deadline);
            const formattedDate = new Intl.DateTimeFormat('en-US', {
              month: 'long',
              day: 'numeric',
              year: 'numeric',
            }).format(dateObj);

            // Add Total Amount column
            const totalAmountCell = document.createElement("td");
            totalAmountCell.textContent = data.total_amount ?? "N/A";
            row.appendChild(totalAmountCell);

            // Add Next Deadline column
            const nextDeadlineCell = document.createElement("td");
            nextDeadlineCell.textContent = formattedDate;
            row.appendChild(nextDeadlineCell);

            // Append row to the table body
            repaymentTableBody.appendChild(row);
          });
        } else {
          // Handle case where no deadlines exist
          const row = document.createElement("tr");
          const cell = document.createElement("td");
          cell.setAttribute("colspan", 2);
          cell.className = "text-center";
          cell.textContent = "No repayment schedule available.";
          row.appendChild(cell);
          repaymentTableBody.appendChild(row);
        }
      })
      .catch((error) => {
        repaymentTableBody.innerHTML = `<tr><td colspan="2" class="text-danger text-center">Failed to load repayment schedule. Please try again later.</td></tr>`;
        console.error("Error fetching repayment schedule:", error);
      });
  });
});

function redirectToLender() {
    window.location.href = "lenderdashboard.php";
}

   </script>
</body>

</html>