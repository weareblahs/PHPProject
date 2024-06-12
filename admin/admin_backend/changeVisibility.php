<?php
$ia = $_POST['isAvailable'];
$if = $_POST['isFeatured'];
$filmID = $_POST['filmID'];

require_once '../../backend/sql_init.php';

if (isset($ia) && $ia == "1") {
    mysqli_query($cn, "UPDATE films SET isAvailable = 1 WHERE filmID = '$filmID'");
} else {
    mysqli_query($cn, "UPDATE films SET isAvailable = 0 WHERE filmID = '$filmID'");
}

if (isset($if) && $if == "1") {
    mysqli_query($cn, "UPDATE films SET isFeatured = 1 WHERE filmID = '$filmID'");
} else {
    mysqli_query($cn, "UPDATE films SET isFeatured = 0 WHERE filmID = '$filmID'");
}
