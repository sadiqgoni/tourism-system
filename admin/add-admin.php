<?php
$pageTitle = "Administrators";
ob_start(); // Start output buffering
include "header.php";
include "sidebar.php";

$pageTitle = "Add New Admin";

$adminId = (int)$_SESSION['admin'];

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
 
    // Validate fields
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }
   

    // Check if admin already exists
    $existingAdmin = $db->read("admins", "WHERE username = '$username'");
    if ($existingAdmin) {
        $errors['general'] = "An admin with this username already exists.";
    }

    // If no errors, proceed with inserting the admin
    if (empty($errors)) {
        $adminData = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => 'subadmin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $db->create("admins", $adminData);
            $success = true;
            $_SESSION['success'] = 'Admin added successfully';
            header("Location: admins.php");
            exit();
        } catch (Exception $e) {
            $errors['general'] = "Failed to add admin. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Add New Admin</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">Admin added successfully.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                            <?php if (!empty($errors['username'])): ?>
                                <span class="text-danger"><?php echo $errors['username']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <?php if (!empty($errors['password'])): ?>
                                <span class="text-danger"><?php echo $errors['password']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Admin</button>
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