<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Signature Document</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
  <style>
    body {
  font-family: Arial, sans-serif;
  margin: 20px;
}

.signature-canvas {
  border: 1px solid #ccc;
  width: 100%;
  max-width: 500px;
  height: 150px;
  display: block;
  margin: 10px 0;
}

button {
  margin: 10px 0;
}

  </style>
</head>
<body>
  <h1>Signature Form</h1>

  <!-- Form to capture signatures -->
  <form id="signatureForm" method="post" action="save_signature.php">
    <div>
      <label for="lenderSignature">Lender Signature</label>
      <canvas id="lenderSignature" class="signature-canvas"></canvas>
      <button type="button" onclick="clearSignature('lenderSignature')">Clear</button>
    </div>
    
    <div>
      <label for="borrowerSignature">Borrower Signature</label>
      <canvas id="borrowerSignature" class="signature-canvas"></canvas>
      <button type="button" onclick="clearSignature('borrowerSignature')">Clear</button>
    </div>
    
    <div>
      <label for="managerSignature">General Manager Signature</label>
      <canvas id="managerSignature" class="signature-canvas"></canvas>
      <button type="button" onclick="clearSignature('managerSignature')">Clear</button>
    </div>

    <button type="submit">Submit Signatures</button>
  </form>

  <hr>

  <h2>In Witness Whereof</h2>
  <p>We hereunto affix our signatures this ___ day of _______, 20__.</p>

  <!-- Signatories Section -->
  <div>
    <p>_______________________     _______________________       _______________________</p>
    <p>Signature over Printed Name    Signature over Printed Name    Signature over Printed Name</p>
    <p>Lender                       Borrower                       General Manager, ScholarLend</p>
  </div>

  <div>
    <h3>Signatures:</h3>
    <p>Lender's Signature:</p>
    <img id="lenderImg" src="" alt="Lender Signature" style="max-width: 200px;"/>

    <p>Borrower's Signature:</p>
    <img id="borrowerImg" src="" alt="Borrower Signature" style="max-width: 200px;"/>

    <p>General Manager's Signature:</p>
    <img id="managerImg" src="" alt="Manager Signature" style="max-width: 200px;"/>
  </div>

  <script src="script.js"></script>
<script>

    // script.js

// Initialize signature pads
const canvases = {
  lenderSignature: new SignaturePad(document.getElementById("lenderSignature")),
  borrowerSignature: new SignaturePad(document.getElementById("borrowerSignature")),
  managerSignature: new SignaturePad(document.getElementById("managerSignature")),
};

// Clear specific signature pad
function clearSignature(canvasId) {
  canvases[canvasId].clear();
}

// Handle form submission
document.getElementById("signatureForm").addEventListener("submit", (e) => {
  e.preventDefault();

  // Get data URLs for each signature
  const lenderDataURL = canvases["lenderSignature"].toDataURL();
  const borrowerDataURL = canvases["borrowerSignature"].toDataURL();
  const managerDataURL = canvases["managerSignature"].toDataURL();

  // Send data to the server (this is just an example, you may want to use AJAX)
  fetch("save_signature.php", {
    method: "POST",
    body: JSON.stringify({
      lenderSignature: lenderDataURL,
      borrowerSignature: borrowerDataURL,
      managerSignature: managerDataURL,
    }),
    headers: { "Content-Type": "application/json" },
  })
  .then((response) => response.json())
  .then((data) => {
    if (data.status === "success") {
      // On success, display the signature images in the document
      document.getElementById("lenderImg").src = lenderDataURL;
      document.getElementById("borrowerImg").src = borrowerDataURL;
      document.getElementById("managerImg").src = managerDataURL;
    } else {
      alert("Failed to submit signatures.");
    }
  });
});

</script>
</body>
</html>
