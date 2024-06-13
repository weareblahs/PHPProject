<?php
$ia = $_POST['isAvailable'];
$if = $_POST['isFeatured'];
$filmID = $_POST['filmID'];

require_once '../../backend/sql_init.php';

if (isset($ia)) {
    mysqli_query($cn, "UPDATE films SET isAvailable = '$ia' WHERE filmID = '$filmID'");
} else {
    mysqli_query($cn, "UPDATE films SET isAvailable = 0 WHERE filmID = '$filmID'");
}

if (isset($if)) {
    mysqli_query($cn, "UPDATE films SET isFeatured = '$if' WHERE filmID = '$filmID'");
} else {
    mysqli_query($cn, "UPDATE films SET isFeatured = 0 WHERE filmID = '$filmID'");
}

header('Location: /admin/view/all');
