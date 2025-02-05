<?php
// Start output buffering before including any files
ob_start();
$pageTitle = "View Site";
include "header.php";

// Get site ID from URL and validate it
$siteId = isset($_GET['siteID']) ? intval($_GET['siteID']) : 0;

// Validate site ID
if ($siteId <= 0) {
    ob_end_clean(); // Clear any output
    header("Location: index.php");
    exit();
}

// Fetch site details
$site = $db->read("sites", "WHERE siteID = $siteId");

if (!$site) {
    ob_end_clean(); // Clear any output
    header("Location: index.php");
    exit();
}

// Unserialize images
$images = @unserialize($site['images']);
if (!is_array($images) || empty($images)) {
    $images = ['assets/images/hero-slider-1.jpg'];
}
$firstImage = 'admin/' . htmlspecialchars($images[0]);
?>
<br>
<div class="hero-wrap">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 text-center">
                <h1 class="mb-3 bread"><?php echo htmlspecialchars($site['name']); ?></h1>
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="index.php">Home</a></span>
                    <span>Site Details</span>
                </p>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Left Column: Images & Description -->
            <div class="col-lg-8">
                <div class="row">
                    <?php foreach ($images as $image): ?>
                        <div class="col-md-6 mb-4">
                            <a href="admin/<?php echo htmlspecialchars($image); ?>" class="image-popup">
                                <img src="admin/<?php echo htmlspecialchars($image); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($site['name']); ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-5">
                    <h2 class="mb-4"><?php echo htmlspecialchars($site['name']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($site['description'])); ?></p>
                </div>
            </div>
            
            <!-- Right Column: Sidebar with Booking & Details -->
            <div class="col-lg-4 sidebar">
                <div class="sidebar-box bg-light p-4">
                    <h3 class="heading-2">Site Details</h3>
                    <div class="price-wrap mb-4">
                        <span class="price">₦<?php echo number_format($site['amount'], 2); ?></span>
                        <span class="per">/person</span>
                    </div>
                    <div class="mb-4">
                        <h4>Location</h4>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($site['location']); ?></p>
                    </div>
                    <div class="mb-4">
                        <h4>Availability</h4>
                        <p>
                            <?php echo $site['availability'] 
                                ? '<span class="badge badge-success">Available</span>' 
                                : '<span class="badge badge-danger">Not Available</span>'; ?>
                        </p>
                    </div>
                    <?php if ($site['availability']): ?>
                        <a href="user/booking.php?siteID=<?php echo $site['siteID']; ?>" class="btn btn-primary btn-block">Book Now</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
ob_end_flush();
include "footer.php"; 
?>
