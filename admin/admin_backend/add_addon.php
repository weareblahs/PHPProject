<?php

require_once '../../backend/sql_init.php';
$addon_name = $_POST['addonName'];
$addon_image = $_FILES['addonImage'];
$addon_description = $_POST['addonDescription'];
$addon_pricing = $_POST['addonPrice'];

//image properties
$path = '../../assets_public/images/addons/';
$web_path = '/assets_public/images/addons/';
$file_name = uniqid();
$target_filename = $path . $file_name . "." . pathinfo(basename($_FILES["addonImage"]["name"]), PATHINFO_EXTENSION);
$web_target_filename = $web_path . $file_name . "." . pathinfo(basename($_FILES["addonImage"]["name"]), PATHINFO_EXTENSION);
$addon_id = uniqid();

if (isset($_POST["submit"])) {
    $check = getimagesize($addon_image["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        echo "<br>";
        echo "Starting upload...";
        if (move_uploaded_file($_FILES["addonImage"]["tmp_name"], $target_filename)) {
            echo "The file " . htmlspecialchars(basename($_FILES["addonImage"]["name"])) . " has been uploaded.";
            // begin database query
            $add_addon_query = "INSERT INTO addon (addonUniqID, addonName, addonPrice, addonImage, addonDescription) VALUES ('$addon_id', '$addon_name', $addon_pricing, '$web_target_filename', '$addon_description')";
            mysqli_query($cn, $add_addon_query);
            mysqli_close($cn);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "The file you uploaded is not an image";
        die();
    }
}
