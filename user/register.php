<?php
include('../Database.php');
$db = new Database();
session_start();
$site_setting = $db->read("setting", "WHERE id=1");

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = trim($_POST['gender']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);

    // Validate fields
    if (empty($fullname)) {
        $errors['fullname'] = "Full Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Valid Email is required.";
    }
    if (empty($phone)) {
        $errors['phone'] = "Phone Number is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
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

    // Check for unique email
    if (empty($errors)) {
        $existingUser = $db->read("users", "WHERE email = '$email'");
        if ($existingUser) {
            $errors['email'] = "Email is already registered.";
        }
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $userData = [
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'gender' => $gender,
            'state' => $state,
            'country' => $country,
            'status' => 'active',
            'password' => $hashedPassword
        ];

        try {
            $userId = $db->create("users", $userData);
            $_SESSION['user'] = $userId;
            $success = true;
            header("Location: login.php");
            exit();
        } catch (Exception $e) {
            $errors['general'] = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $site_setting['site_name']; ?> - Register</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logo.png" alt="">
                </a>
                <p class="text-center"><?php echo $site_setting['site_name']; ?></p>
                <?php if (!empty($errors['general'])): ?>
                  <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
                <?php endif; ?>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname ?? ''); ?>" required>
                    <?php if (!empty($errors['fullname'])): ?>
                      <span class="text-danger"><?php echo $errors['fullname']; ?></span>
                    <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    <?php if (!empty($errors['email'])): ?>
                      <span class="text-danger"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
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
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <?php if (!empty($errors['password'])): ?>
                      <span class="text-danger"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                  </div>
                  <div class="mb-4">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <?php if (!empty($errors['confirm_password'])): ?>
                      <span class="text-danger"><?php echo $errors['confirm_password']; ?></span>
                    <?php endif; ?>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign Up</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="login.php">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>
</html>