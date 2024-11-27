<?php 
session_start();
$email = $_SESSION['email'];
$otp = $_SESSION['otp'];


// Use the values as needed


// Display the form
?>

<!DOCTYPE html>
<!-- Coding by CodingLab || www.codinglabweb.com -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OTP Verification Form</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <style>
      /* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #c0cae6;
}
:where(.container, form, .input-field, header) {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.container {
  background: #fff;
  padding: 30px 65px;
  border-radius: 12px;
  row-gap: 20px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}
.container header {
  height: 65px;
  width: 65px;
  background: #caac82;
  color: #fff;
  font-size: 2.5rem;
  border-radius: 50%;
}
.container h4 {
  font-size: 1.25rem;
  color: #333;
  font-weight: 500;
}
form .input-field {
  flex-direction: row;
  column-gap: 10px;
}
.input-field input {
  height: 45px;
  width: 42px;
  border-radius: 6px;
  outline: none;
  font-size: 1.125rem;
  text-align: center;
  border: 1px solid #ddd;
}
.input-field input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}
.input-field input::-webkit-inner-spin-button,
.input-field input::-webkit-outer-spin-button {
  display: none;
}
form button {
  margin-top: 25px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  border: none;
  padding: 9px 0;
  cursor: pointer;
  border-radius: 6px;
  pointer-events: none;
  background: #caac82;
  transition: all 0.2s ease;
}
form button.active {
  background: #61c554;
  pointer-events: auto;
}
form button:hover {
  background: #caac82;
}

    </style>
  </head>
  <body>
    <div class="container">
      <header>
        <i class="bx bxs-check-shield"></i>
      </header>
      <h4>Enter OTP Code</h4>
      <form action="forgot_password_verify.php" method="POST">
    <div class="input-field">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" /> <!-- Hidden field to send email -->
        <input type="number" name="otp_digit_1" maxlength="1" required />
        <input type="number" name="otp_digit_2" maxlength="1" required />
        <input type="number" name="otp_digit_3" maxlength="1" required />
        <input type="number" name="otp_digit_4" maxlength="1" required />
        <input type="number" name="otp_digit_5" maxlength="1" required />
        <input type="number" name="otp_digit_6" maxlength="1" required />
    </div>
    <button type="submit">Verify OTP</button>
</form>
    </div>
  </body>
  <script>
   const inputs = document.querySelectorAll("input[type='number']"),
        button = document.querySelector("button");

    // Iterate over all inputs
    inputs.forEach((input, index) => {
        input.addEventListener("keyup", (e) => {
            // Get the current, next, and previous input elements
            const currentInput = input;
            const nextInput = inputs[index + 1];
            const prevInput = inputs[index - 1];

            // If the value has more than one character, clear it
            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }

            // If the input is filled, move to the next input
            if (currentInput.value !== "" && nextInput) {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }

            // Handle backspace key
            if (e.key === "Backspace") {
                currentInput.value = "";
                if (prevInput) {
                    prevInput.focus();
                }
            }

            // Check if all inputs are filled to toggle button active state
            const allFilled = Array.from(inputs).every(input => input.value !== "");
            button.classList.toggle("active", allFilled);
        });
    });

    // Focus the first input on window load
    window.addEventListener("load", () => inputs[0].focus());

  </script>
</html>
