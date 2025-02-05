<?php
$pageTitle = "My Profile";
include "header.php";
include "sidebar.php";

// Assuming the admin ID is stored in the session
$adminId = $_SESSION['admin'];

// Fetch admin information from the database
$admin = $db->read("admins", "WHERE id = '$adminId'");

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">My Profile</h5>
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">UserName</label>
                            <input type="text" class="form-control" id="fullname" value="<?php echo htmlspecialchars($admin['username']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Role</label>
                            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($admin['role']); ?>" readonly>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>