<?php
require_once '../../backend/sql_init.php';
$id = $_GET['id'];
$delete_query = "DELETE FROM films WHERE filmID = '$id' ";
mysqli_query($cn, $delete_query);
mysqli_close($cn);

// delete images
$path = "../../assets_public/images/movieID/" . $id . "/";
$files = glob($path);
foreach ($files as $file) { // iterate files
    if (is_file($file)) {
        unlink($file); // delete file
        if (!rmdir($path)) {
            echo ("Could not remove $path");
            die();
        }
    }
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
