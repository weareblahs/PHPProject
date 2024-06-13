<?php
require_once '../../backend/sql_init.php';
require_once '../../elements/layout_lite.php';

$showtimeID = $_POST['showtimeID'];
$filmID = $_POST['filmID'];
$showtimes = $_POST['showtimes'];
$hallID = $_POST['hallID'];

$addShowtimeID =  "UPDATE films SET associatedShowtimeID = '$showtimeID' WHERE filmID = '$filmID'";
mysqli_query($cn, $addShowtimeID);
$showtimeCounter = 0;
foreach ($showtimes as $showtime) {
    $addShowtime =  "INSERT INTO showtimes (filmID, time, showtimeID, hallID) VALUES ('$filmID', $showtime, '$showtimeID', '$hallID')";
    mysqli_query($cn, $addShowtime);
    $showtimeCounter += 1;
}
mysqli_close($cn);
head();
?>
<div class="container" bs-data-theme="dark">
    <div class="center-div m-5">
        <h1 class="text-center"><?php echo $showtimeCounter ?> showtimes added</h1>
        <h4 class="text-center">These showtimes are now live in the ticketing page</h4>
        <a href="/admin/showtimes" target="_blank" class="btn btn-success w-100">Go back to showtimes page</a>
    </div>
</div>

<?php
endofpage();
?>