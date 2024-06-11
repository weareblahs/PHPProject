<?php

require_once 'sql_init.php';

$username = $_POST['username'];
$password = $_POST['password'];

session_start();

$get_password_hash_query = "SELECT password FROM users WHERE username = '$username';";
$get_password_hash = mysqli_fetch_assoc(mysqli_query($cn, $get_password_hash_query));


// user id

if (strlen($username) > 0 && strlen($password) > 0) {
    if (password_verify($password, $get_password_hash['password'])) {
        $get_user_id_query = "SELECT userUniqID FROM users WHERE username = '$username';";
        $get_user_id = mysqli_fetch_assoc(mysqli_query($cn, $get_user_id_query));
        $get_admin_property_query = "SELECT isAdmin FROM users WHERE username = '$username';";
        $get_admin_property = mysqli_fetch_assoc(mysqli_query($cn, $get_admin_property_query));
        var_dump($get_user_id);
        echo 'Success';
        $get_first_name_query = "SELECT firstName FROM users WHERE username = '$username';";
        $get_first_name = mysqli_fetch_assoc(mysqli_query($cn, $get_first_name_query));
        setcookie('userID', $get_user_id['userUniqID'], time() + (10 * 365 * 24 * 60 * 60), "/");
        setcookie('firstName', $get_first_name['firstName'], time() + (10 * 365 * 24 * 60 * 60), "/");

        if ($get_admin_property['isAdmin'] == 1) {
            header('Location: /admin');
        } else {
            header('Location: /');
        }
    }
} else {
    echo 'Wrong password';
}
