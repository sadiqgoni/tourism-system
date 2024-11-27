<?php
ob_start(); // Start output buffering
$pageTitle = "Add New User";
include "header.php";
include "sidebar.php";

$adminId = (int)$_SESSION['admin'];

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
  
    // Validate fields
    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Valid email is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
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
   
    // Check if user already exists
    $existingUser = $db->read("users", "WHERE email = '$email'");
    if ($existingUser) {
        $errors['general'] = "A user with this email already exists.";
    }

    // If no errors, proceed with inserting the user
    if (empty($errors)) {
        $userData = [
            'fullname' => $fullname,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'phone' => $phone,
            'gender' => $gender,
            'state' => $state,
            'country' => $country,
            'status' => 'active'
        ];

        try {
            $db->create("users", $userData);
            $success = true;
            $_SESSION['success'] = 'User added successfully';
            header("Location: users.php");
            exit();
        } catch (Exception $e) {
            $errors['general'] = "Failed to add user. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Add New User</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">User added successfully.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname ?? ''); ?>" required>
                            <?php if (!empty($errors['fullname'])): ?>
                                <span class="text-danger"><?php echo $errors['fullname']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                            <?php if (!empty($errors['email'])): ?>
                                <span class="text-danger"><?php echo $errors['email']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <?php if (!empty($errors['password'])): ?>
                                <span class="text-danger"><?php echo $errors['password']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
                            <?php if (!empty($errors['phone'])): ?>
                                <span class="text-danger"><?php echo $errors['phone']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" <?php echo (isset($gender) && $gender == 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo (isset($gender) && $gender == 'female') ? 'selected' : ''; ?>>Female</option>
                                <option value="other" <?php echo (isset($gender) && $gender == 'other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <?php if (!empty($errors['gender'])): ?>
                                <span class="text-danger"><?php echo $errors['gender']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($state ?? ''); ?>" required>
                            <?php if (!empty($errors['state'])): ?>
                                <span class="text-danger"><?php echo $errors['state']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="<?php echo htmlspecialchars($country ?? ''); ?>" required>
                            <?php if (!empty($errors['country'])): ?>
                                <span class="text-danger"><?php echo $errors['country']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
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