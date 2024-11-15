<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Loan Application Submitted</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f7f4ef;
        font-family: Arial, sans-serif;
        margin: 0;
    }

    .container {
        text-align: center;
    }

    .thank-you-circle {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 8px solid #d1a775;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 40px;
    }

    .thank-you-text {
        font-size: 48px;
        color: #d1a775;
        font-family: 'Pacifico', cursive;
    }

    .message-box {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px 40px;
        font-size: 20px;
        color: #333;
        max-width: 600px;
        margin: 0 auto 20px;
        line-height: 1.5;
    }

    .continue-button {
        display: inline-block;
        background-color: #d1a775;
        color: #fff;
        padding: 12px 25px;
        font-size: 18px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .continue-button:hover {
        background-color: #b8955e;
    }
</style>
</head>
<body>

<div class="container">
    <div class="thank-you-circle">
        <span class="thank-you-text">Thank you</span>
    </div>
    <div class="message-box">
    You've already completed the payment!
    </div>
    <a href="borrower_applicationform.php" class="continue-button">Continue</a>
</div>

</body>
</html>
