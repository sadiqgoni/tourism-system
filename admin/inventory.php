<?php
$pageTitle = "Inventory List";
include "header.php";
include "sidebar.php";

$adminId = (int)$_SESSION['admin'];
$errors = [];
$success = false;

// Handle deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $itemId = (int)$_GET['id'];
    try {
        $db->delete("inventory", "itemID = '$itemId'");
        $success = true;
    } catch (Exception $e) {
        $errors[] = "Failed to delete inventory item.";
    }
}

// Fetch all inventory items with site names using readWithJoin
$inventoryItems = $db->readWithJoin(
    "inventory",
    "sites",
    "inventory.siteID = sites.siteID"
);

?>

<link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
                Inventory List
                <a href="add-inventory.php" class="btn btn-primary btn-sm float-end">Add New Item</a>
            </h5>

            <?php if (array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
            <?php endif;
            unset($_SESSION['success']) ?>

            <?php if ($success): ?>
                <div class="alert alert-success">Inventory item deleted successfully.</div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="inventoryTable" class="table text-nowrap align-middle mb-0">
                    <thead>
                        <tr class="border-2 border-bottom border-primary border-0">
                            <th scope="col" class="ps-0">S/N</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Site Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Availability</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $sn = 1; ?>
                        <?php foreach ($inventoryItems as $item): ?>
                            <tr>
                                <td class="ps-0 fw-medium"><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($item['itemName']); ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo $item['availability'] == '1' ? 'Yes' : 'No'; ?></td>
                                <td class="text-center">
                                    <a href="view-inventory.php?id=<?php echo $item['itemID']; ?>" class="btn btn-info btn-sm">View</a>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $item['itemID']; ?>)">Delete</button>
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
        $('#inventoryTable').DataTable({
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
        if (confirm('Are you sure you want to delete this inventory item?')) {
            window.location.href = '?delete&id=' + id;
        }
    }
</script>