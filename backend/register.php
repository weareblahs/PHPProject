<?php
// connect to SQL
require_once 'sql_init.php';
// get variables
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirmpass'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// generated variables
$userid = uniqid();
session_start();
// run checks
// bootstrap properties:
// register_bs_scheme = Bootstrap badge scheme
// register_bs_notice = Bootstrap badge message
if(strlen($firstname) > 0 && strlen($lastname) > 0 && strlen($email) > 0 && strlen($username) > 0 && strlen($password)) {
    if(strlen($firstname) > 0 || strlen($lastname) > 0) {
        if(strlen($username) >= 8) {
            if(strlen($password) >= 8) {
                if($password == $confirm_password) {
                    $register_query = "INSERT INTO users (userUniqID, firstName, lastName, username, email, password, isAdmin) VALUES ('$userid', '$firstname', '$lastname', '$username', '$email', '$hashed_password', 0);";
                    mysqli_query($cn, $register_query);
                    mysqli_close($cn);
                    $_SESSION['welcomeMsg']['firstName'] = $firstname;
                    header('Location: /login/welcome.php');
                } else {
                    $_SESSION['register_bs_scheme'] = "danger";
                    $_SESSION['register_bs_notice'] = "Both passwords did not match";       
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }
            } else {
                $_SESSION['register_bs_scheme'] = "danger";
                $_SESSION['register_bs_notice'] = "Password must be at least 8 characters";       
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        } else {
            $_SESSION['register_bs_scheme'] = "danger";
            $_SESSION['register_bs_notice'] = "Username must be at least 8 characters";       
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    } else {
        $_SESSION['register_bs_scheme'] = "danger";
        $_SESSION['register_bs_notice'] = "Please check if you have filled in your first name or your last name";       
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
} else {
    $_SESSION['register_bs_scheme'] = "danger";
    $_SESSION['register_bs_notice'] = "All fields must not be blank";       
    header('Location: '.$_SERVER['HTTP_REFERER']);
};
?>