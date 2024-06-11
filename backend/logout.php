<?php

// clear cookies
if (isset($_COOKIE['userID'])) {
    unset($_COOKIE['userID']);
    setcookie('userID', '', time() - 3600, '/');
}

if (isset($_COOKIE['firstName'])) {
    unset($_COOKIE['firstName']);
    setcookie('firstName', '', time() - 3600, '/');
}

header('Location: '.$_SERVER['HTTP_REFERER']);

?>