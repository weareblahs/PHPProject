<?php
require_once '../../backend/sql_init.php';


$addonID = $_POST['addonID'];
$addonName = $_POST['addonName'];
$addonDescription = $_POST['addonDescription'];
$addonPricing = $_POST['addonPricing'];
$query = "UPDATE addon SET 
addonUniqID = '$addonID',
addonName = '$addonName',
addonPrice = '$addonPricing',
addonDescription = '$addonDescription' WHERE addonUniqID = '$uniqID'";
mysqli_query($cn, $query);
mysqli_close($cn);
header('Location: ' . $_SERVER['HTTP_REFERER']);
