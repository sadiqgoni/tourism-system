<?php
$pageTitle = "Home";
include "header.php";
$sites = $db->readAll("sites");
$users = $db->readAll("users");
$admins = $db->readAll("admins");

?>

<div class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="intro-wrap">
                    <h1 class="mb-5"><span class="d-block">Let's Enjoy Your</span> Trip In <span
                            class="typed-words"></span></h1>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="slides">
                    <img src="assets/images/hero-slider-1.jpg" alt="Image" class="img-fluid active">
                    <img src="assets/images/hero-slider-2.jpg" alt="Image" class="img-fluid">
                    <img src="assets/images/hero-slider-3.jpg" alt="Image" class="img-fluid">
                    <img src="assets/images/hero-slider-4.jpg" alt="Image" class="img-fluid">
                    <img src="assets/images/hero-slider-5.jpg" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section" id="services">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="section-title text-center mb-3">Our Services</h2>
                <p>Explore the world with our comprehensive tourism management system, offering seamless travel
                    experiences and unforgettable adventures.</p>
            </div>
        </div>
        <div class="row align-items-stretch">
            <div class="col-lg-4 order-lg-1">
                <div class="h-100">
                    <div class="frame h-100">
                        <div class="feature-img-bg h-100"
                            style="background-image: url('assets/images/hero-slider-1.jpg');"></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-1">
                <div class="feature-1 d-md-flex">
                    <div class="align-self-center">
                        <span class="flaticon-plane display-4 text-primary"></span>
                        <h3>Flight Booking</h3>
                        <p class="mb-0">Book flights to your favorite destinations with ease and convenience.</p>
                    </div>
                </div>

                <div class="feature-1">
                    <div class="align-self-center">
                        <span class="flaticon-hotel display-4 text-primary"></span>
                        <h3>Hotel Reservations</h3>
                        <p class="mb-0">Find and reserve the best accommodations for your stay.</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-3">
                <div class="feature-1 d-md-flex">
                    <div class="align-self-center">
                        <span class="flaticon-tour-guide display-4 text-primary"></span>
                        <h3>Guided Tours</h3>
                        <p class="mb-0">Experience guided tours with expert local guides.</p>
                    </div>
                </div>

                <div class="feature-1 d-md-flex">
                    <div class="align-self-center">
                        <span class="flaticon-support display-4 text-primary"></span>
                        <h3>24/7 Customer Support</h3>
                        <p class="mb-0">Our support team is available around the clock to assist you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section count-numbers py-5">
    <div class="container">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="<?php echo count($sites) ?>">0</span>
                    </div>
                    <span class="caption">No. of Tourism Sites</span>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="100">100+</span>

                    </div>
                    <span class="caption">No. of Clients</span>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="30">30+</span>

                    </div>
                    <span class="caption">No. of Partners</span>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="6">6</span>
                    </div>
                    <span class="caption">No. of Certifications</span>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Featured Destinations -->
<div class="untree_co-section">
    <div class="container">
        <div class="row text-center justify-content-center mb-5">
            <div class="col-lg-7">
                <h2 class="section-title text-center">Featured Destinations</h2>
                <p>Explore our hand-picked destinations for your next adventure</p>

            </div>
        </div>
        <div class="row">
            <?php
            if ($sites && is_array($sites)) {
                foreach ($sites as $site) {
                    // Safely handle image data
                    $imageData = @unserialize($site['images']);
                    $imagePath = '';

                    if ($imageData && is_array($imageData) && !empty($imageData)) {
                        $imagePath = 'admin/' . $imageData[0];
                    } else {
                        // Use a default image if no image is available
                        $imagePath = 'assets/images/hero-slider-1.jpg';
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="destination-card">
                            <img src="<?php echo htmlspecialchars($imagePath); ?>"
                                alt="<?php echo htmlspecialchars($site['name']); ?>" class="img-fluid">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($site['name']); ?></h5>
                                <p class="card-text">
                                    <?php echo htmlspecialchars(substr($site['description'], 0, 100)) . '...'; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">From $<?php echo number_format($site['amount'], 2); ?></span>
                                    <a href="view-site.php?siteID=<?php echo urlencode($site['siteID']); ?>"
                                        class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

    </div>
</div>
<!-- Popular Destinations Slider -->
<div class="untree_co-section">
    <div class="container">
        <div class="row text-center justify-content-center mb-5">
            <div class="col-lg-7">
                <h2 class="section-title text-center">Popular Destinations</h2>
                <p>Discover our most visited and highly rated destinations</p>
            </div>
        </div>

        <div class="owl-carousel owl-3-slider">
            <?php
            if ($sites && is_array($sites)) {
                foreach ($sites as $site) {
                    // Safely handle image data
                    $imageData = @unserialize($site['images']);
                    $imagePath = '';

                    if ($imageData && is_array($imageData) && !empty($imageData)) {
                        $imagePath = 'admin/' . $imageData[0];
                    } else {
                        // Use a default image if no image is available
                        $imagePath = 'assets/images/hero-slider-1.jpg';
                    }

                    // Ensure siteID is properly sanitized
                    $siteID = isset($site['siteID']) ? (int)$site['siteID'] : 0;
                    if ($siteID === 0) continue;
                    ?>
                    <div class="item">

                        <a class="media-thumb" href="view-site.php?siteID=<?php echo (int) $site['siteID']; ?>">
                            <div class="media-text">
                                <h3><?php echo htmlspecialchars($site['name']); ?></h3>
                                <span class="location"><?php echo htmlspecialchars($site['location']); ?></span>
                            </div>
                            <img src="<?php echo htmlspecialchars($imagePath); ?>"
                                alt="<?php echo htmlspecialchars($site['name']); ?>" class="img-fluid">
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p>No destinations available at the moment.</p></div>';
            }
            ?>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-between align-items-center">

            <div class="col-lg-6">
                <figure class="img-play-video">
                    <a id="play-video" class="video-play-button" href="https://www.youtube.com/watch?v=mwtbEGNABWU"
                        data-fancybox>
                        <span></span>
                    </a>
                    <img src="assets/images/hero-slider-2.jpg" alt="Image" class="img-fluid rounded-20">
                </figure>
            </div>

            <div class="col-lg-5">
                <h2 class="section-title text-left mb-4">Discover Our Tourism Management System</h2>
                <p>Embark on a journey with our state-of-the-art tourism management system, designed to enhance your
                    travel experience from start to finish.</p>

                <p class="mb-4">Our platform offers seamless integration of travel services, ensuring a smooth and
                    enjoyable adventure for every traveler.</p>

                <ul class="list-unstyled two-col clearfix">
                    <li>Comprehensive Travel Planning</li>
                    <li>Flight and Hotel Bookings</li>
                    <li>Car Rentals and Transfers</li>
                    <li>Cruise and Rail Options</li>
                    <li>Exclusive Travel Packages</li>
                    <li>Travel Insurance Solutions</li>
                    <li>Expert Travel Guides</li>
                    <li>24/7 Customer Support</li>
                    <li>Personalized Itineraries</li>
                    <li>Travel Resources and Tips</li>
                </ul>

                <p><a href="#" class="btn btn-primary">Get Started</a></p>
            </div>
        </div>
    </div>
</div>

<div class="py-5 cta-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <h2 class="mb-2 text-white">Explore the World with Us. Contact Us Today</h2>
                <p class="mb-4 lead text-white text-white-opacity">Join us for an unforgettable travel experience. Our
                    team is ready to assist you with all your travel needs.</p>
                <p class="mb-0"><a href="user/" class="btn btn-outline-white text-white btn-md font-weight-bold">Get in
                        touch</a></p>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>