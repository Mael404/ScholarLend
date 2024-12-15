<?php
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    function saveImage($dataURL, $filename) {
        $imageData = explode(",", $dataURL)[1]; // Get base64 part
        $decodedData = base64_decode($imageData);
        file_put_contents($filename, $decodedData);
    }

    // Save each signature as an image file
    saveImage($data["lenderSignature"], "uploads/lender_signature.png");
    saveImage($data["borrowerSignature"], "uploads/borrower_signature.png");
    saveImage($data["managerSignature"], "uploads/manager_signature.png");

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
