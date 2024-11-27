<?php
ob_start(); // Start output buffering
$pageTitle = "Users";

include "header.php";
include "sidebar.php";

$pageTitle = "Edit User";

$adminId = (int)$_SESSION['admin'];

$errors = [];
$success = false;

// Get user ID from query parameter
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch user data
$user = $db->read("users", "WHERE id = '$userId'");
if (!$user) {
    $errors['general'] = "User not found.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
    $status = trim($_POST['status']);

    // Validate fields
    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Valid email is required.";
    }
    if (empty($phone)) {
        $errors['phone'] = "Phone number is required.";
    }
    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }
    if (empty($state)) {
        $errors['state'] = "State is required.";
    }
    if (empty($country)) {
        $errors['country'] = "Country is required.";
    }
    if (empty($status)) {
        $errors['status'] = "Status is required.";
    }

    // Check if email already exists for another user
    $existingUser = $db->read("users", "WHERE email = '$email' AND id != '$userId'");
    if ($existingUser) {
        $errors['general'] = "A user with this email already exists.";
    }

    // If no errors, proceed with updating the user
    if (empty($errors)) {
        $userData = [
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'gender' => $gender,
            'state' => $state,
            'country' => $country,
            'status' => $status
        ];

        try {
            $db->update("users", $userData, "WHERE id = '$userId'");
            $success = true;
            $_SESSION['success'] = 'User updated successfully';
            header("Location: users.php");
            exit();
        } catch (Exception $e) {
            $errors['general'] = "Failed to update user. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit User</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">User updated successfully.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $userId; ?>">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" required>
                            <?php if (!empty($errors['fullname'])): ?>
                                <span class="text-danger"><?php echo $errors['fullname']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                            <?php if (!empty($errors['email'])): ?>
                                <span class="text-danger"><?php echo $errors['email']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                            <?php if (!empty($errors['phone'])): ?>
                                <span class="text-danger"><?php echo $errors['phone']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" <?php echo (isset($user['gender']) && $user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo (isset($user['gender']) && $user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                <option value="other" <?php echo (isset($user['gender']) && $user['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <?php if (!empty($errors['gender'])): ?>
                                <span class="text-danger"><?php echo $errors['gender']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($user['state'] ?? ''); ?>" required>
                            <?php if (!empty($errors['state'])): ?>
                                <span class="text-danger"><?php echo $errors['state']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="<?php echo htmlspecialchars($user['country'] ?? ''); ?>" required>
                            <?php if (!empty($errors['country'])): ?>
                                <span class="text-danger"><?php echo $errors['country']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($user['status'] ?? ''); ?>" required>
                            <?php if (!empty($errors['status'])): ?>
                                <span class="text-danger"><?php echo $errors['status']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
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