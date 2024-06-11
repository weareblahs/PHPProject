<?php
require_once '../../backend/sql_init.php';

$intervalTime = $_POST['intervalTime'];
$showStart = $_POST['showStart'];
$showEnd = $_POST['showEnd'];
$dayValue = $_POST['dayValue'];
mysqli_query($cn, "UPDATE globalsettings SET intervalTime = $intervalTime, showStart = '$showStart', showEnd = '$showEnd', dayValue = '$dayValue' WHERE currentGlobalSetting = 1");
mysqli_close($cn);


header('Location: ' . $_SERVER['HTTP_REFERER']);
