<?php
require_once '../../backend/sql_init.php';
$content = $_POST['checkbox'];
// pre-init: get date
$currentTime = strtotime(date('Y-m-d H:i:s', strtotime('+6 hours', strtotime(date("Y-m-d h:i:s", time())))));

foreach ($content as $selectedOption) {
    if ($selectedOption == "showtimesBeyondCurrent") {
        mysqli_query($cn, "DELETE FROM showtimes WHERE time < $currentTime");
    }
    if ($selectedOption == "ticketsBeyondCurrent") {
        $ticketID = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM assignedseats WHERE time < $currentTime"), MYSQLI_ASSOC);
        foreach ($ticketID as $expiredTickets) {
            $ticketToDelete = $expiredTickets['ticketID'];
            mysqli_query($cn, "DELETE FROM tickets WHERE ticketID = $ticketToDelete");
        }
        mysqli_query($cn, "DELETE FROM assignedseats WHERE time < $currentTime");
    }
    if ($selectedOption == "deleteAllShowtimes") {
        mysqli_query($cn, "DELETE FROM showtimes");
    }
}
mysqli_close($cn);
header('Location: /admin/cleanup?done=1');
