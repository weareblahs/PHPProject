<?php
require_once '../../backend/sql_init.php';
$id = $_GET['id'];
$delete_query = "DELETE FROM films WHERE filmID = '$id' ";
mysqli_query($cn, $delete_query);
mysqli_close($cn);

header('Location: ' . $_SERVER['HTTP_REFERER']);
