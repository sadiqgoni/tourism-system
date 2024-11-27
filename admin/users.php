<?php
$pageTitle = "Users";
include "header.php";
include "sidebar.php";

$pageTitle = "Users List";
$adminId = (int)$_SESSION['admin'];
$errors = [];
$success = false;

// Handle deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
    try {
        $db->delete("users", "id = '$userId'");
        $success = true;
    } catch (Exception $e) {
        $errors[] = "Failed to delete user.";
    }
}

// Fetch all users
$users = $db->readAll("users");
?>

<link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
                Users List
                <a href="add-user.php" class="btn btn-primary btn-sm float-end">Add New User</a>
            </h5>

            <?php if (array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
            <?php endif; unset($_SESSION['success']) ?>

            <?php if ($success): ?>
                <div class="alert alert-success">User deleted successfully.</div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="usersTable" class="table text-nowrap align-middle mb-0">
                    <thead>
                        <tr class="border-2 border-bottom border-primary border-0">
                            <th scope="col" class="ps-0">S/N</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Gender</th>
                            <th scope="col">State</th>
                            <th scope="col">Country</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $sn = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="ps-0 fw-medium"><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td><?php echo htmlspecialchars($user['gender']); ?></td>
                                <td><?php echo htmlspecialchars($user['state']); ?></td>
                                <td><?php echo htmlspecialchars($user['country']); ?></td>
                                <td><?php echo htmlspecialchars($user['status']); ?></td>
                                <td class="text-center">
                                    <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-info btn-sm">View</a>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $user['id']; ?>)">Delete</button>
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
    $('#usersTable').DataTable({
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
    if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = '?delete&id=' + id;
    }
}
</script>