<?php
$pageTitle = "Booking List";
include "header.php";
include "sidebar.php";

$adminId = (int)$_SESSION['admin'];
$errors = [];
$success = false;

// Handle deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $bookingId = (int)$_GET['id'];
    try {
        $db->delete("booking", "id = '$bookingId'");
        $success = true;
    } catch (Exception $e) {
        $errors[] = "Failed to delete booking.";
    }
}

// Fetch all bookings with user full names and site names using readWithJoin
$bookings = $db->readWithJoin(
    "booking",
    "users",
    "booking.userId = users.id"
);

?>

<link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
                Booking History
            </h5>

            <?php if (array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
            <?php endif;
            unset($_SESSION['success']) ?>

            <?php if ($success): ?>
                <div class="alert alert-success">Booking deleted successfully.</div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="bookingTable" class="table text-nowrap align-middle mb-0">
                    <thead>
                        <tr class="border-2 border-bottom border-primary border-0">
                            <th scope="col" class="ps-0">S/N</th>
                            <th scope="col">User</th>
                            <th scope="col">Booking Date</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $sn = 1;?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td class="ps-0 fw-medium"><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($booking['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($booking['bookingDate']); ?></td>
                                <td><?php echo htmlspecialchars($booking['paymentStatus']); ?></td>
                                <td><?php echo htmlspecialchars($booking['totalAmount']); ?></td>
                                <td class="text-center">
                                    <a href="view-booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-info btn-sm">View</a>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $booking['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<!-- Include DataTables CDN -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/jszip.min.js"></script>
<script src="assets/js/pdfmake.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#bookingTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv',
                'excel',
                'pdf',
                'print'
            ]
        });
    });

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this booking?')) {
            window.location.href = '?delete&id=' + id;
        }
    }
</script>