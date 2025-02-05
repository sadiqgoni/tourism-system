<?php
$pageTitle = "Booking";
include "header.php";
include "sidebar.php";

$userId = (int)$_SESSION['user'];
$errors = [];
$success = false;

// Fetch active sites
$sites = $db->readAll("sites", "WHERE availability = 1 AND status = 'active'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteId = (int)$_POST['site'];
    $selectedItems = $_POST['items'] ?? [];

    // Validate fields
    if (empty($siteId)) {
        $errors['site'] = "Please select a site.";
    }
    if (empty($selectedItems)) {
        $errors['items'] = "Please select at least one item.";
    }

    // If no errors, proceed with booking
    if (empty($errors)) {
        try {
            // Fetch site details
            $site = $db->readAll("sites", "WHERE siteID = $siteId")[0];
            $siteAmount = $site['amount'];
            $description = "Site: " . $site['name'];

            // Calculate total amount and append item details to description
            $totalAmount = $siteAmount;
            foreach ($selectedItems as $itemId) {
                $item = $db->readAll("inventory", "WHERE itemID = $itemId")[0];
                $totalAmount += $item['amount'];
                $description .= ", Item: " . $item['itemName'] . " (₦" . number_format($item['amount'], 2) . ")";
            }

            // Book the site with items
            $bookingData = [
                'userId' => $userId,
                'siteId' => $siteId,
                'description' => $description,
                'bookingDate' => date('Y-m-d H:i:s'),
                'status' => 'Pending',
                'paymentStatus' => 'Unpaid',
                'totalAmount' => $totalAmount,
            ];
            $db->create("booking", $bookingData);

            $success = true;
        } catch (Exception $e) {
            $errors['general'] = "Failed to book site and items. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Book Site</h5>
            <?php if ($success): ?>
                <div class="alert alert-success">Booking successful.</div>
            <?php endif; ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="site" class="form-label">Select Site</label>
                            <select class="form-control" id="site" name="site" required>
                                <option value="">Choose a site</option>
                                <?php foreach ($sites as $site): ?>
                                    <option value="<?php echo $site['siteID']; ?>"><?php echo htmlspecialchars($site['name']); ?> - ₦<?php echo htmlspecialchars(number_format($site['amount'], 2)); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (!empty($errors['site'])): ?>
                                <span class="text-danger"><?php echo $errors['site']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="items" class="form-label">Select Items</label>
                            <select class="form-control" id="items" name="items[]" multiple required>
                                <!-- Items will be populated based on selected site using JavaScript -->
                            </select>
                            <?php if (!empty($errors['items'])): ?>
                                <span class="text-danger"><?php echo $errors['items']; ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Book Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#site').change(function() {
        var siteId = $(this).val();
        if (siteId) {
            $.ajax({
                url: 'fetch-items.php',
                type: 'GET',
                data: { siteId: siteId },
                dataType: 'json',
                success: function(data) {
                    var itemsSelect = $('#items');
                    itemsSelect.empty(); // Clear previous items
                    $.each(data, function(index, item) {
                        itemsSelect.append(
                            $('<option>', {
                                value: item.itemID,
                                text: item.itemName + ' - ₦' + parseFloat(item.amount).toFixed(2)
                            })
                        );
                    });
                },
                error: function() {
                    alert('Failed to fetch items. Please try again.');
                }
            });
        } else {
            $('#items').empty(); // Clear items if no site is selected
        }
    });
});
</script>

<?php include "footer.php"; ?>