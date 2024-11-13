<div class="list-group list-group-flush my-3">
    <a href="admindashboard.php" class="list-group-item list-group-item-action">
        <i class="lnr lnr-home me-2"></i> Home
    </a>
    <?php
include'condb.php';

// SQL query to count 'pending' statuses in the loan-deadlines table
$sql = "SELECT COUNT(*) AS pending_count FROM borrower_info WHERE status = 'pending'";
$results = $conn->query($sql);

// Fetch the count
$pending_count = 0;
if ($results->num_rows > 0) {
    $row = $results->fetch_assoc();
    $pending_count = $row['pending_count'];
}

$conn->close();
?>
    <a href="admin_applications.php" class="list-group-item active">
        <i class="lnr lnr-file-empty me-2"></i>Applications
        <?php if ($pending_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $pending_count; ?></span>
    <?php endif; ?>
    </a>
    <a href="admin_lenders.php" class="list-group-item">
        <i class="lnr lnr-briefcase me-2"></i>Lenders
    </a>
    <?php
include'condb.php';

// SQL query to count 'pending' statuses in the loan-deadlines table
$sql = "SELECT COUNT(*) AS pending_count FROM loan_deadlines WHERE status = 'pending'";
$results = $conn->query($sql);

// Fetch the count
$pending_count = 0;
if ($results->num_rows > 0) {
    $row = $results->fetch_assoc();
    $pending_count = $row['pending_count'];
}

$conn->close();
?>

<a href="admin_borrowers.php" class="list-group-item position-relative">
    <i class="lnr lnr-users me-2"></i>Borrowers
    <?php if ($pending_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $pending_count; ?></span>
    <?php endif; ?>
</a>
    <a href="admin_loans.php" class="list-group-item">
        <i class="lnr lnr-book me-2"></i>Loans
    </a>
    <a href="admin_messages.php" class="list-group-item">
        <i class="lnr lnr-envelope me-2"></i>Messages
    </a>
    <a href="admin_reports.php" class="list-group-item">
        <i class="lnr lnr-chart-bars me-2"></i>Reports
    </a>
    <a href="admin_settings.php" class="list-group-item">
        <i class="lnr lnr-cog me-2"></i>Settings
    </a>
    <a href="/butterfly/index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="lnr lnr-power-switch me-2"></i>Logout
    </a>
</div>
