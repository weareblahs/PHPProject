<?php
require_once 'sql_init.php';
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$userID = $_COOKIE['userID'];

mysqli_query($cn, "UPDATE users SET firstName = '$firstName', lastName = '$lastName', email = '$email' WHERE userUniq                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          ID = '$userID'");
mysqli_close($cn);
header('Location: /profile');
