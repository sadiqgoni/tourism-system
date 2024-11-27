<?php
$pageTitle = "My Profile";
include "header.php";
include "sidebar.php";

// Assuming the user ID is stored in the session
$userId = $_SESSION['user'];

// Fetch user information from the database
$user = $db->read("users", "WHERE id = '$userId'");

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
                            <input type="text" class="form-control" id="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" value="<?php echo htmlspecialchars($user['state']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" value="<?php echo htmlspecialchars($user['country']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" value="<?php echo htmlspecialchars($user['status']); ?>" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>