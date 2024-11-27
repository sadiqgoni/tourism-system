<?php
$pageTitle = "Settings";
include "header.php";
include "sidebar.php";

$adminId = $_SESSION['admin'];
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate fields
    if (empty($currentPassword)) {
        $errors['current_password'] = "Current password is required.";
    }
    if (empty($newPassword)) {
        $errors['new_password'] = "New password is required.";
    }
    if ($newPassword !== $confirmPassword) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // Check current password
    if (empty($errors)) {
        $admin = $db->read("admins", "WHERE id = '$adminId'");
        if ($admin && password_verify($currentPassword, $admin['password'])) {
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            
            $db->update("admins", ["password" => $hashedPassword], "id = '$adminId'");
            $success = true;
        } else {
            $errors['current_password'] = "Current password is incorrect.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Change Password</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">Password updated successfully.</div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <?php if (!empty($errors['current_password'])): ?>
                                <span class="text-danger"><?php echo $errors['current_password']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <?php if (!empty($errors['new_password'])): ?>
                                <span class="text-danger"><?php echo $errors['new_password']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <?php if (!empty($errors['confirm_password'])): ?>
                                <span class="text-danger"><?php echo $errors['confirm_password']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>