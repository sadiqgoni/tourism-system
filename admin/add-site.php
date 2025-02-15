<?php
ob_start(); // Start output buffering
$pageTitle = "Sites";
include "header.php";
include "sidebar.php";

$pageTitle = "Add New Tourist Site";

$adminId = (int)$_SESSION['admin'];

$errors = [];
$success = false;

// Define upload directory with absolute path
$uploadsDir = __DIR__ . '/assets/uploads/';
if (!file_exists($uploadsDir)) {
    // Create directory with proper permissions
    if (!mkdir($uploadsDir, 0777, true)) {
        $errors['general'] = "Failed to create uploads directory. Please check permissions.";
    } else {
        // Ensure proper permissions after creation
        chmod($uploadsDir, 0777);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $amount = trim($_POST['amount']);
    $availability = isset($_POST['availability']) ? 1 : 0;
    $images = $_FILES['images'];

    // Validate fields
    if (empty($name)) {
        $errors['name'] = "Site name is required.";
    }
    if (empty($description)) {
        $errors['description'] = "Description is required.";
    }
    if (empty($location)) {
        $errors['location'] = "Location is required.";
    }
    if (empty($amount)) {
        $errors['amount'] = "Amount is required.";
    }

    if (empty($images['name'][0])) {
        $errors['images'] = "At least one image is required.";
    }

    // Check if site already exists
    $existingSite = $db->read("sites", "WHERE name = '$name'");
    if ($existingSite) {
        $errors['general'] = "A site with this name already exists.";
    }

    // If no errors, proceed with inserting the site
    if (empty($errors)) {
        // Handle image uploads
        $uploadedImages = [];
        foreach ($images['name'] as $key => $imageName) {
            if ($images['error'][$key] === UPLOAD_ERR_OK) {
                $tmp_name = $images['tmp_name'][$key];
                
                // Generate unique filename
                $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                $newFilename = uniqid() . '_' . time() . '.' . $extension;
                $uploadPath = $uploadsDir . $newFilename;
                
                // Only allow certain image types
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($extension, $allowedTypes)) {
                    if (move_uploaded_file($tmp_name, $uploadPath)) {
                        // Store relative path in database
                        $uploadedImages[] = 'assets/uploads/' . $newFilename;
                    } else {
                        $errors['images'] = "Failed to upload image: " . $imageName . ". Please check directory permissions.";
                        break;
                    }
                } else {
                    $errors['images'] = "Invalid file type. Allowed types: " . implode(', ', $allowedTypes);
                    break;
                }
            }
        }

        if (empty($errors)) {
            $imagesSerialized = serialize($uploadedImages);

            $siteData = [
                'name' => $name,
                'description' => $description,
                'location' => $location,
                'amount' => $amount,
                'availability' => $availability,
                'images' => $imagesSerialized,
                'status' => 'active'
            ];

            try {
                $db->create("sites", $siteData);
                $success = true;
                $_SESSION['success'] = 'Site added successfully';
                header("Location: sites.php");
                exit();
            } catch (Exception $e) {
                $errors['general'] = "Failed to add site. Please try again.";
            }
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Add New Tourist Site</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">Site added successfully.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Site Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                            <?php if (!empty($errors['name'])): ?>
                                <span class="text-danger"><?php echo $errors['name']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                            <?php if (!empty($errors['description'])): ?>
                                <span class="text-danger"><?php echo $errors['description']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($location ?? ''); ?>" required>
                            <?php if (!empty($errors['location'])): ?>
                                <span class="text-danger"><?php echo $errors['location']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount to Book</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="<?php echo htmlspecialchars($amount ?? ''); ?>" required>
                            <?php if (!empty($errors['amount'])): ?>
                                <span class="text-danger"><?php echo $errors['amount']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="availability" class="form-label">Availability</label>
                            <select class="form-control" id="availability" name="availability" required>
                                <option value="1" <?php echo (isset($availability) && $availability == 1) ? 'selected' : ''; ?>>Yes</option>
                                <option value="0" <?php echo (isset($availability) && $availability == 0) ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple required>
                            <?php if (!empty($errors['images'])): ?>
                                <span class="text-danger"><?php echo $errors['images']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Site</button>
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