<!-- Sidebar Start -->
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./index.php" class="text-nowrap logo-img">
        <img src="../assets/images/logo.png" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
          <span class="hide-menu">Main</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'Dashboard' ? 'active' : ''; ?>" href="./index.php" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">PAGES</span>
            </li>

        <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'Sites' || $pageTitle == 'Tourist Sites List' ? 'active' : ''; ?>" href="sites.php" aria-expanded="false">
            <span>
              <iconify-icon icon="hugeicons:book-edit" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Tourist Sites</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'Users' ? 'active' : ''; ?>" href="users.php" aria-expanded="false">
            <span>
              <iconify-icon icon="dashicons:admin-users" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Users</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'Inventory' ? 'active' : ''; ?>" href="inventory.php" aria-expanded="false">
            <span>
              <iconify-icon icon="tabler:receipt-filled" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Inventory</span>
          </a>
        </li>
        
        <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'Booking' ? 'active' : ''; ?>" href="bookings.php" aria-expanded="false">
            <span>
              <iconify-icon icon="gis:map-book" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Bookings</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'My Profile' ? 'active' : ''; ?>" href="./my-profile.php" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:user-circle-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">My Profile</span>
          </a>
        </li>

        <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">OTHERS</span>
            </li>

            <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'Administrators' ? 'active' : ''; ?>" href="admins.php" aria-expanded="false">
            <span>
              <iconify-icon icon="ri:admin-fill" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Administrators</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link <?php echo $pageTitle == 'Settings' ? 'active' : ''; ?>" href="settings.php" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:settings-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Settings</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="?logout=true" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:logout-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Logout</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!-- Sidebar End -->
<?php include 'navbar.php'; ?>