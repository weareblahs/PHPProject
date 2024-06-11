<?php
require_once '../../backend/sql_init.php';

$id = $_GET['hallID'];

$deleteQuery = "DELETE FROM halls WHERE hallUniqID = '$id'";
mysqli_query($cn, $deleteQuery);
mysqli_close($cn);

header('Location: ' . $_SERVER['HTTP_REFERER']);
