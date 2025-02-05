<?php
$pageTitle = "My Profile";
include "header.php";
include "sidebar.php";

// Ensure session is started
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the logged-in user ID
$userId = $_SESSION['user'];

// Fetch user details securely using prepared statements
$user = $db->read("users", "WHERE id = '$userId'");


// Check if user exists
if (!$user) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>User profile not found.</div></div>";
    include "footer.php";
    exit();
}

// Function to safely get user data
function safeValue($data, $key) {
    return isset($data[$key]) ? htmlspecialchars($data[$key]) : '';
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">My Profile</h5>
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" value="<?php echo safeValue($user, 'fullname'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="<?php echo safeValue($user, 'email'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="gender" value="<?php echo safeValue($user, 'gender'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" value="<?php echo safeValue($user, 'phone'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" value="<?php echo safeValue($user, 'state'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" value="<?php echo safeValue($user, 'country'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" value="<?php echo safeValue($user, 'status'); ?>" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
