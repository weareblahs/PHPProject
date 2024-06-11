<?php
require_once '../../backend/sql_init.php';


$uniqID = $_POST['uniqID'];
$hallName = $_POST['hallName'];
$experienceID = $_POST['experienceID'];

$query = "UPDATE halls SET hallName = '$hallName', experienceID = '$experienceID' WHERE hallUniqID = '$uniqID'";
mysqli_query($cn, $query);
mysqli_close($cn);
header('Location: ' . $_SERVER['HTTP_REFERER']);
