<?php
session_start();
include 'condb.php';

$user_id = $_GET['user_id'];
$sql = "SELECT created_at, transaction_id, loan_amount, status FROM borrower_info WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$loansHtml = ''; // Initialize a variable to hold the HTML

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = ($row['status'] == 'Invested' || $row['status'] == 'Fund Transferred') ? 'Ongoing' : htmlspecialchars($row['status']);
        $loansHtml .= "<tr style='text-align: center;'>
                          <td>" . date("m/d/Y", strtotime($row['created_at'])) . "</td>
                          <td>" . htmlspecialchars($row['transaction_id']) . "</td>
                          <td>₱" . number_format($row['loan_amount'], 2) . "</td>
                          <td>" . $status . "</td>
                       </tr>";
    }
} else {
    $loansHtml = "<tr>
                    <td colspan='4' class='text-center'>No loans found</td>
                  </tr>";
}

$stmt->close();
$conn->close();

// Return the HTML for loans
echo $loansHtml;
?>
