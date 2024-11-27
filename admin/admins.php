<?php
$pageTitle = "Administrators";
include "header.php";
include "sidebar.php";
$pageTitle = "Admins List";

$adminId = (int)$_SESSION['admin'];
$errors = [];
$success = false;

// Handle deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $adminIdToDelete = (int)$_GET['id'];
    try {
        $db->delete("admins", "id = '$adminIdToDelete'");
        $success = true;
    } catch (Exception $e) {
        $errors[] = "Failed to delete admin.";
    }
}

// Fetch all admins
$admins = $db->readAll("admins", "WHERE role !='admin'");
?>

<link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
                Admins List
                <a href="add-admin.php" class="btn btn-primary btn-sm float-end">Add New Admin</a>
            </h5>

            <?php if (array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
            <?php endif; unset($_SESSION['success']) ?>

            <?php if ($success): ?>
                <div class="alert alert-success">Admin deleted successfully.</div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="adminsTable" class="table text-nowrap align-middle mb-0">
                    <thead>
                        <tr class="border-2 border-bottom border-primary border-0">
                            <th scope="col" class="ps-0">S/N</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Updated At</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $sn = 1; ?>
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td class="ps-0 fw-medium"><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($admin['username']); ?></td>
                                <td><?php echo htmlspecialchars($admin['role']); ?></td>
                                <td><?php echo htmlspecialchars($admin['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($admin['updated_at']); ?></td>
                                <td class="text-center">
                                    <a href="view-admin.php?id=<?php echo $admin['id']; ?>" class="btn btn-info btn-sm">View</a>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $admin['id']; ?>)">Delete</button>
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
    $('#adminsTable').DataTable({
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
    if (confirm('Are you sure you want to delete this admin?')) {
        window.location.href = '?delete&id=' + id;
    }
}
</script>