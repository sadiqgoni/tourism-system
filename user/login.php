<?php
include('../Database.php');
$db = new Database();

session_start();
$site_setting = $db->read("setting", "WHERE id=1");

if (isset($_SESSION['user'])) {
  header('location: index.php');
  exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $remember = isset($_POST['remember']);

  // Validate fields
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Valid Email is required.";
  }
  if (empty($password)) {
    $errors['password'] = "Password is required.";
  }

  if (empty($errors)) {
    $user = $db->read("users", "WHERE email = '$email'");
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user['id'];

      // Remember this device
      if ($remember) {
        setcookie("user", $user['id'], time() + (86400 * 30), "/"); // 30 days
      }

      header("Location: index.php");
      exit();
    } else {
      $errors['general'] = "Invalid email or password.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $site_setting['site_name']; ?> - Login</title>
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
                <a href="../index.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logo.png" alt="">
                </a>
                <p class="text-center"><?php echo $site_setting['site_name']; ?></p>
                <?php if (!empty($errors['general'])): ?>
                  <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
                <?php endif; ?>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
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
                  <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember this device</label>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">New to <?php echo $site_setting['site_name']; ?>?</p>
                    <a class="text-primary fw-bold ms-2" href="register.php">Create an account</a>
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