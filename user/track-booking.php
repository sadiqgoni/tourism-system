<?php
$pageTitle = "Track Booking";
include "header.php";
include "sidebar.php";

$userId = $_SESSION['user'];
$errors = [];
$booking = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingId = trim($_POST['booking_id']);

    // Validate booking ID
    if (empty($bookingId)) {
        $errors['booking_id'] = "Booking ID is required.";
    }

    // Fetch booking details
    if (empty($errors)) {
        $booking = $db->read("booking", "WHERE id = '$bookingId' AND userId = '$userId'");
        if (!$booking) {
            $errors['general'] = "No booking found with the provided ID.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Track Booking
            <a href="bookings.php" class="btn btn-primary btn-sm float-end">Booking History</a>
            </h5>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="booking_id" class="form-label">Booking ID</label>
                            <input type="text" class="form-control" id="booking_id" name="booking_id" value="<?php echo htmlspecialchars($bookingId ?? ''); ?>" required>
                            <?php if (!empty($errors['booking_id'])): ?>
                                <span class="text-danger"><?php echo $errors['booking_id']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Search Booking</button>
                    </form>
                </div>
            </div>

            <?php if ($booking): ?>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Booking Details</h5>
                        <p><strong>Site:</strong> <?php echo htmlspecialchars($booking['description']); ?></p>
                        <hr>
                        <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['bookingDate']); ?></p>
                        <hr>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status']); ?></p>
                        <hr>
                        <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($booking['paymentStatus']); ?></p>
                        <hr>
                        <p><strong>Total Amount:</strong> ₦<?php echo number_format($booking['totalAmount'], 2); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>