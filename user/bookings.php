<?php
$pageTitle = "Booking";
include "header.php";
include "sidebar.php";

$userId = $_SESSION['user'];
$errors = [];

// Fetch all bookings for the user
$bookings = $db->readAll("booking", "WHERE userId = '$userId' ORDER BY bookingDate DESC");

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">My Bookings
            <a href="track-booking.php" class="btn btn-primary btn-sm float-end">Back</a>
            
            </h5>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Description</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['description']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['bookingDate']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['status']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['paymentStatus']); ?></td>
                                    <td>₦<?php echo number_format($booking['totalAmount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No bookings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>