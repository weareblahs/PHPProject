<?php
require_once '../../backend/sql_init.php';
$id = $_GET['id'];
$add_experience_query = "DELETE FROM cinemaexperiences WHERE uniqID = '$id' ";
mysqli_query($cn, $add_experience_query);
mysqli_close($cn);

header('Location: ' . $_SERVER['HTTP_REFERER']);
