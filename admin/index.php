<?php
$pageTitle = "Dashboard";
include "header.php";
include "sidebar.php";
?>
<!--  Header End -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex align-items-center gap-2 mb-4">
            Complaint Traffic Overview
            <span>
              <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
            </span>
          </h5>
          <div id="traffic-overview">
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="assets/images/backgrounds/product-tip.png" alt="image" class="img-fluid" width="205">
          <h4 class="mt-7">Stay Informed!</h4>
          <p class="card-subtitle mt-2 mb-3">Keep up with the latest updates and announcements. Check out our news section for more information.</p>
        </div>
      </div>
    </div>

    <?php include "footer.php"; ?>