<?php

$cn = mysqli_connect('127.0.0.1', "root", "", "mts");


// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
} else {
}
