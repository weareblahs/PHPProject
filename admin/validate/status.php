<?php
require_once '../../elements/layout_lite.php';
head();
$ticketID = $_GET['tid'];
require_once '../../backend/sql_init.php';
?>

<!-- set status -->
<?php
if (strlen($ticketID) < 8 || strlen($ticketID) > 8) {
    $status = "invalidCode";
} else if (strlen($ticketID) == 8) {
    if (mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM tickets WHERE ticketID = '$ticketID'"), MYSQLI_ASSOC)[0]['isValidated'] == 0) {
        mysqli_query($cn, "UPDATE tickets SET isValidated = 1 WHERE ticketID = '$ticketID'");
        $status = "success";
    } else if (mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM tickets WHERE ticketID = '$ticketID'"), MYSQLI_ASSOC)[0]['isValidated'] == 1) {
        $status = "scannedTicket";
    } else {
        $status = "invalidCode";
    }
}
?>

<?php if ($status == "scannedTicket") : ?>
    <div style="margin-top: 4em">
        <div class="p-5">
            <h1 class="text-center"><i class="fas fa-3x fa-times-circle" style="color: red"></i></h1>
            <h1 class="text-center">Ticket error</h1>
        </div>
        <div class="container w-75">
            <h1 class="text-center p-5"><i>Your ticket was scanned before</i></h1>
        </div>
        <div class="center-div">
            <i>
                <h4 class="text-center">Next ticket will be available for scanning in 3 seconds</h4>
            </i>
        </div>
    </div>
<?php elseif ($status == "invalidCode") : ?>
    <div style="margin-top: 4em">
        <div class="p-5">
            <h1 class="text-center"><i class="fas fa-3x fa-times-circle" style="color: red"></i></h1>
            <h1 class="text-center">Ticket error</h1>
        </div>
        <div class="container w-75">
            <h1 class="text-center p-5"><i>Invalid Ticket ID. Please try again</i></h1>
        </div>
        <div class="center-div">
            <i>
                <h4 class="text-center">Next ticket will be available for scanning in 3 seconds</h4>
            </i>
        </div>
    </div>
<?php elseif ($status == "success") : ?>
    <div style="margin-top: 4em">
        <div class="p-5">
            <h1 class="text-center"><i class="fa fa-3x fa-check-circle" aria-hidden="true" style="color: green"></i></h1>
            <h1 class="text-center">Validation successful</h1>
        </div>
        <div class="container w-75">
            <div class="row">
                <div class="col-4 text-center">
                    <h3><i class="fa fa-film" aria-hidden="true"></i> Film name</h3>
                    <h1><?php
                        require_once '../../backend/sql_init.php';
                        $fid = mysqli_fetch_all(mysqli_query($cn, "SELECT filmID FROM tickets WHERE ticketID = '$ticketID'"), MYSQLI_ASSOC)[0]['filmID'];
                        echo mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM films WHERE filmID = '$fid'"), MYSQLI_ASSOC)[0]['name'];
                        ?></h1>
                </div>
                <div class="col-4 text-center">
                    <h3><i class="fas fa-couch"></i> Seats</h3>
                    <h1>
                        <?php
                        $seats = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM assignedseats WHERE ticketID = '$ticketID'"), MYSQLI_ASSOC);
                        foreach ($seats as $seat) {
                            echo $seat['seat'] . " ";
                        }
                        ?>
                    </h1>
                </div>
                <div class="col-4 text-center">
                    <h3><i class="fa fa-clock-o" aria-hidden="true"></i> Time</h3>
                    <h1><?php
                        $time = intval($seats[0]['time']);
                        echo date("h:i A", $time);
                        ?></h1>
                </div>
            </div>
        </div>
        <div class="container" style="background-color: black; color: white">
            <h3 class="text-center">Your hall is <?php
                                                    $asid = $seats[0]['assignedShowtimeID'];
                                                    $preHall = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$asid'"), MYSQLI_ASSOC)[0]['hallID'];
                                                    echo mysqli_fetch_all(mysqli_query($cn, "SELECT hallName FROM halls WHERE hallUniqID = '$preHall'"), MYSQLI_ASSOC)[0]['hallName'];
                                                    ?></h3>
        </div>
        <div class="center-div">
            <i>
                <h4 class="text-center">Next ticket will be available for scanning in 3 seconds</h4>
            </i>
        </div>
    </div>
<?php endif; ?>
<?php
endofpage_withotherscripts();
?>
<script>
    var timer = setTimeout(function() {
        window.location = '/admin/validate'
    }, 3000);
</script>
<?php
endofpage_withotherscripts_closing();
?>