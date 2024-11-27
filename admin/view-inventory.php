<?php
ob_start(); // Start output buffering
$pageTitle = "Inventory";
include "header.php";
include "sidebar.php";

$adminId = (int)$_SESSION['admin'];

$errors = [];
$success = false;

// Get item ID from query parameter
$itemID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch inventory item data
$item = $db->read("inventory", "WHERE itemID = '$itemID'");
if (!$item) {
    $errors['general'] = "Inventory item not found.";
}

// Fetch all sites to populate the dropdown
$sites = $db->readAll("sites");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemname = trim($_POST['itemname']);
    $siteID = trim($_POST['siteID']);
    $description = trim($_POST['description']);
    $quantity = trim($_POST['quantity']);
    $availability = $_POST['availability'];

    // Validate fields
    if (empty($itemname)) {
        $errors['itemname'] = "Item Name is required.";
    }
    if (empty($siteID)) {
        $errors['siteID'] = "Site ID is required.";
    }
    if (empty($description)) {
        $errors['description'] = "Description is required.";
    }
    if (empty($quantity) || !is_numeric($quantity)) {
        $errors['quantity'] = "Valid quantity is required.";
    }

    // If no errors, proceed with updating the inventory item
    if (empty($errors)) {
        $inventoryData = [
            'itemName' => $itemname,
            'siteID' => $siteID,
            'description' => $description,
            'quantity' => $quantity,
            'availability' => $availability
        ];

        try {
            $db->update("inventory", $inventoryData, "itemID = '$itemID'");
            $success = true;
            $_SESSION['success'] = 'Inventory item updated successfully';
            header("Location: inventory.php");
            exit();
        } catch (Exception $e) {
            $errors['general'] = "Failed to update inventory item. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Inventory Item</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">Inventory item updated successfully.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $itemID; ?>">
                        <div class="mb-3">
                            <label for="itemname" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="itemname" name="itemname" value="<?php echo htmlspecialchars($item['itemName'] ?? ''); ?>" required>
                            <?php if (!empty($errors['itemname'])): ?>
                                <span class="text-danger"><?php echo $errors['itemname']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="siteID" class="form-label">Site</label>
                            <select class="form-control" id="siteID" name="siteID" required>
                                <option value="">Select a site</option>
                                <?php foreach ($sites as $site): ?>
                                    <option value="<?php echo htmlspecialchars($site['siteID']); ?>" <?php echo (isset($item['siteID']) && $item['siteID'] == $site['siteID']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($site['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (!empty($errors['siteID'])): ?>
                                <span class="text-danger"><?php echo $errors['siteID']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($item['description'] ?? ''); ?></textarea>
                            <?php if (!empty($errors['description'])): ?>
                                <span class="text-danger"><?php echo $errors['description']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($item['quantity'] ?? ''); ?>" required>
                            <?php if (!empty($errors['quantity'])): ?>
                                <span class="text-danger"><?php echo $errors['quantity']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="availability" class="form-label">Availability</label>
                            <select class="form-control" id="availability" name="availability" required>
                                <option value="1" <?php echo (isset($item['availability']) && $item['availability'] == 1) ? 'selected' : ''; ?>>Yes</option>
                                <option value="0" <?php echo (isset($item['availability']) && $item['availability'] == 0) ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Inventory Item</button>
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