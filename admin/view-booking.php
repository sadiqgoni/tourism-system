<?php
ob_start(); // Start output buffering
$pageTitle = "Booking";
include "header.php";
include "sidebar.php";

$adminId = (int)$_SESSION['admin'];

$errors = [];
$success = false;

// Get booking ID from query parameter
$bookingID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch booking data
$booking = $db->read("booking", "WHERE id = '$bookingID'");
if (!$booking) {
    $errors['general'] = "Booking not found.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    $paymentStatus = $_POST['paymentStatus'];
    $totalAmount = trim($_POST['totalAmount']);

    // Validate fields
    if (empty($status)) {
        $errors['status'] = "Status is required.";
    }
    if (empty($paymentStatus)) {
        $errors['paymentStatus'] = "Payment Status is required.";
    }
    if (empty($totalAmount) || !is_numeric($totalAmount)) {
        $errors['totalAmount'] = "Valid total amount is required.";
    }

    // If no errors, proceed with updating the booking
    if (empty($errors)) {
        $bookingData = [
            'status' => $status,
            'paymentStatus' => $paymentStatus,
            'totalAmount' => $totalAmount,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $db->update("booking", $bookingData, "id = '$bookingID'");
            $success = true;
            $_SESSION['success'] = 'Booking updated successfully';
            header("Location: bookings.php");
            exit();
        } catch (Exception $e) {
            $errors['general'] = "Failed to update booking. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Booking</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">Booking updated successfully.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $bookingID; ?>">
                        <div class="mb-3">
                            <label for="id" class="form-label">Booking ID</label>
                            <input type="text" class="form-control" id="id" value="<?php echo htmlspecialchars($booking['id']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userId" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="userId" value="<?php echo htmlspecialchars($booking['userId']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="siteId" class="form-label">Site ID</label>
                            <input type="text" class="form-control" id="siteId" value="<?php echo htmlspecialchars($booking['siteId']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" readonly><?php echo htmlspecialchars($booking['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="bookingDate" class="form-label">Booking Date</label>
                            <input type="text" class="form-control" id="bookingDate" value="<?php echo htmlspecialchars($booking['bookingDate']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" <?php echo ($booking['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo ($booking['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="cancelled" <?php echo ($booking['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <?php if (!empty($errors['status'])): ?>
                                <span class="text-danger"><?php echo $errors['status']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="paymentStatus" class="form-label">Payment Status</label>
                            <select class="form-control" id="paymentStatus" name="paymentStatus" required>
                                <option value="unpaid" <?php echo ($booking['paymentStatus'] == 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                                <option value="paid" <?php echo ($booking['paymentStatus'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                                <option value="refunded" <?php echo ($booking['paymentStatus'] == 'refunded') ? 'selected' : ''; ?>>Refunded</option>
                            </select>
                            <?php if (!empty($errors['paymentStatus'])): ?>
                                <span class="text-danger"><?php echo $errors['paymentStatus']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Total Amount</label>
                            <input type="number" class="form-control" id="totalAmount" name="totalAmount" value="<?php echo htmlspecialchars($booking['totalAmount'] ?? ''); ?>" required>
                            <?php if (!empty($errors['totalAmount'])): ?>
                                <span class="text-danger"><?php echo $errors['totalAmount']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
ob_end_flush(); // End output buffering and flush the output
?>