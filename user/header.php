<!DOCTYPE html>
<html lang="en">

<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Database class only if not already included
require_once __DIR__ . '/../Database.php';
$db = new Database();
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

//Logout user
if (array_key_exists('logout', $_GET)) {
  if ($_GET['logout']) {
    unset($_SESSION['user']);
  }
  header('location: login.php');
  exit();
}

$site_setting = $db->read("setting", "WHERE id=1") ?: [];
$pageTitle = isset($pageTitle) ? $pageTitle : "Dashboard";
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $site_setting['site_name']; ?> - <?php echo $pageTitle ?></title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  Main wrapper -->