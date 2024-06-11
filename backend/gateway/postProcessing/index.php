<!-- billplz[id]: eidwxijr
billplz[paid]: true
billplz[paid_at]: 2024-06-02 00:31:38 +0800
billplz[x_signature]: b373f35fb74c0760dd8a5d2143d77afdcbacb5e581dae6cec1fbdab257ce740f -->

<?php
session_start();
$billplz = $_GET['billplz'];
$ticketing = $_SESSION['filmTicketing'];

require_once '../../../backend/sql_init.php';

if ($isUser == 1) {
    //assignedseats
    $ticketID = $ticketing['ticketID'];
    $seats = $ticketing['seats'];
    $showtimeID = $ticketing['showtimeID'];
    $time = $ticketing['time'];
    foreach ($seats as $seat) {
        mysqli_query($cn, "INSERT INTO assignedSeats (ticketID, seat, assignedShowtimeID, time) VALUES ($ticketID, '$seat', '$showtimeID', $time)");
    }
    //tickets
    $userID = $_COOKIE['userID'];
    $paymentID = $billplz['x_signature'];
    $filmID = $ticketing['filmID'];
    $totalPrice = $ticketing['totalAmount'];
    mysqli_query($cn, "INSERT INTO tickets (userID, paymentID, ticketID, filmID, totalPrice) VALUES ('$userID', '$paymentID', '$ticketID', '$filmID', '$totalPrice');");

    if (strlen($_SESSION['filmTicketing']['addons']["'property'"]["'name'"]) > 0) {
        foreach ($_SESSION['filmTicketing']['addons'] as $addon) {
            $addonID = uniqid();
            $addonName = $addon["'name'"];
            $addonQuantity = $addon["'quantity'"];
            mysqli_query($cn, "INSERT INTO addonorders (addonOrderID, addonID, addonQuantity) VALUES ('$addonID', '$addonName', '$addonQuantity')");
            mysqli_query($cn, "UPDATE tickets SET addonID = '$addonID' WHERE ticketID = $ticketID");
        }
    } else {
        echo 'Addon not ordered. Skipping addon step.';
    }
} else {
    //assignedseats
    $ticketID = $ticketing['ticketID'];
    $seats = $ticketing['seats'];
    $showtimeID = $ticketing['showtimeID'];
    $time = $ticketing['time'];
    foreach ($seats as $seat) {
        mysqli_query($cn, "INSERT INTO assignedSeats (ticketID, seat, assignedShowtimeID, time) VALUES ($ticketID, '$seat', '$showtimeID', $time)");
    }
    //tickets
    $userID = $_COOKIE['userID'];
    $paymentID = $billplz['x_signature'];
    $filmID = $ticketing['filmID'];
    $totalPrice = $ticketing['totalAmount'];
    mysqli_query($cn, "INSERT INTO tickets (userID, paymentID, ticketID, filmID, totalPrice) VALUES ('guest', '$paymentID', '$ticketID', '$filmID', '$totalPrice');");

    if (strlen($_SESSION['filmTicketing']['addons']["'property'"]["'name'"]) > 0) {
        foreach ($_SESSION['filmTicketing']['addons'] as $addon) {
            $addonID = uniqid();
            $addonName = $addon["'name'"];
            $addonQuantity = $addon["'quantity'"];
            mysqli_query($cn, "INSERT INTO addonorders (addonOrderID, addonID, addonQuantity) VALUES ('$addonID', '$addonName', '$addonQuantity')");
            mysqli_query($cn, "UPDATE tickets SET addonID = '$addonID' WHERE ticketID = $ticketID");
        }
    } else {
        echo 'Addon not ordered. Skipping addon step.';
    }
}

header('Location: /ticketing/success?tid=' . $ticketID);
