<?php
require_once '../../../backend/sql_init.php';

$showtimeID = $_GET['showtimeID'];
$filmID = $_GET['filmID'];

mysqli_query($cn, "DELETE FROM showtimes WHERE showtimeID = '$showtimeID';");
mysqli_query($cn, "UPDATE films SET associatedShowtimeID = 'none' WHERE associatedShowtimeID = '$showtimeID';");

header('Location: /admin/showtimes');
