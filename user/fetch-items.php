<?php
include('../Database.php');
$db = new Database();
session_start();
if (isset($_GET['siteId'])) {
    $siteId = (int)$_GET['siteId'];
   
    $items = $db->readAll("inventory", "WHERE siteID = $siteId AND availability = 1");
    echo json_encode($items);

}

?>