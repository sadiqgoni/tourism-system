<?php
ob_start(); // Start output buffering
$pageTitle = "Administrators";
include "header.php";
include "sidebar.php";
$pageTitle = "Edit Admin";


$adminId = (int)$_SESSION['admin'];

$errors = [];
$success = false;

// Get admin ID from query parameter
$adminIdToEdit = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch admin data
$admin = $db->read("admins", "WHERE id = '$adminIdToEdit'");
if (!$admin) {
    $errors['general'] = "Admin not found.";
} else {
    $admin = $admin[0]; // Assuming read returns an array of results
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate fields
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }
  

    // Check if username already exists for another admin
    $existingAdmin = $db->read("admins", "WHERE username = '$username' AND id != '$adminIdToEdit'");
    if ($existingAdmin) {
        $errors['general'] = "An admin with this username already exists.";
    }

    // If no errors, proceed with updating the admin
    if (empty($errors)) {
        $adminData = [
            'username' => $username,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update password only if provided
        if (!empty($password)) {
            $adminData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        try {
            $db->update("admins", $adminData, "id = '$adminIdToEdit'");
            $success = true;
            $_SESSION['success'] = 'Admin record updated successfully';
            header("Location: admins.php");
            exit();
        } catch (Exception $e) {
            $errors['general'] = "Failed to update admin. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Admin</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">Admin updated successfully.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $adminIdToEdit; ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username'] ?? ''); ?>" required>
                            <?php if (!empty($errors['username'])): ?>
                                <span class="text-danger"><?php echo $errors['username']; ?></span>
                            <?php endif; ?>
                        </div>
                       
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <?php if (!empty($errors['password'])): ?>
                                <span class="text-danger"><?php echo $errors['password']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Admin</button>
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