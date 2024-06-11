<?php

$title = "My tickets";
require_once '../elements/layout.php';

function get_content()
{
    require_once '../backend/sql_init.php';
    $userID = $_COOKIE['userID'];
    $ticketTest = mysqli_fetch_all(mysqli_query($cn, "SELECT ticketID FROM tickets WHERE userID = '$userID'"), MYSQLI_ASSOC);
?>

    <?php if ($ticketTest === []) : ?>
        <div class="container" style="padding: 2em; display: flex; align-items: center; justify-content: center">
            <h1>No tickets ordered</h1>
        </div>
    <?php else : ?>
        <div class="container">
            <div class="p-4">
                <h3>Recent ticket</h3>
                <div class="row p-2 latestTicketBorder">
                    <div class="col-lg-6 col-sm-12" style="margin-top: auto; margin-bottom: auto">
                        <div>
                            <?php
                            // expand the horizons?
                            $userID = $_COOKIE['userID'];
                            $latestTicketInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM tickets WHERE userID = '$userID' ORDER BY ticketID DESC LIMIT 1;"), MYSQLI_ASSOC)[0];
                            $latestTicketTID = $latestTicketInfo['ticketID'];
                            ?>
                            <h3 class="QR" style="text-align: left !important; margin-top: auto; margin-bottom: auto"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $latestTicketInfo['ticketID'] ?></h3>
                            <h2><?php
                                $preLFID = mysqli_fetch_all(mysqli_query($cn, "SELECT filmID FROM tickets WHERE ticketID = '$latestTicketTID'"), MYSQLI_ASSOC)[0]['filmID'];
                                echo mysqli_fetch_all(mysqli_query($cn, "SELECT name FROM films WHERE filmid = '$preLFID'"), MYSQLI_ASSOC)[0]['name'];
                                ?></h2>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12" style="margin-top: auto; margin-bottom: auto">
                        <i class="fa-solid fa-couch"></i><?php echo " " ?>
                        <?php
                        $recentSeats = mysqli_fetch_all(mysqli_query($cn, "SELECT seat FROM assignedseats WHERE ticketID = '$latestTicketTID'"), MYSQLI_ASSOC);
                        foreach ($recentSeats as $recentSeat) {
                            echo $recentSeat['seat'] . " ";
                        }
                        ?>
                        <br>
                        <i class="fa fa-clock" aria-hidden="true"></i><?php echo " " ?>
                        <?php
                        $recentDT = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM assignedseats WHERE ticketID = '$latestTicketTID'"), MYSQLI_ASSOC)[0];
                        echo date('m/d/Y h:i A', $recentDT['time']);
                        ?>
                        <br>
                        <i class="bi bi-film"></i></i><?php echo " " ?>
                        <?php
                        // locate hall name
                        // logic:
                        // time from assignedseats where ticketid match latestticketid
                        // hallid from showtimes where filmid match latestfilmid and time match time
                        // hallname from halls where halluniqid match hallid
                        $preRecentHall1 = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM assignedseats WHERE ticketID = '$latestTicketTID'"), MYSQLI_ASSOC)[0]['time'];
                        $preRecentHall2a = $recentDT['time'];
                        $preRecentHall2 = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE filmID = '$preLFID' AND time = $preRecentHall2a"), MYSQLI_ASSOC)[0]['hallID'];
                        echo mysqli_fetch_all(mysqli_query($cn, "SELECT hallName FROM halls WHERE hallUniqID = '$preRecentHall2'"), MYSQLI_ASSOC)[0]['hallName'];
                        ?>
                    </div>
                    <div class="col-lg-2 col-sm-12 p-2">
                        <!-- qr modal start -->
                        <button type="button" class="btn btn-primary w-100" style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;" data-bs-toggle="modal" data-bs-target="#viewRecentQR">
                            <i class="fa fa-qrcode" aria-hidden="true"></i> View QR code
                        </button>
                        <div class="modal fade" id="viewRecentQR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="https://quickchart.io/qr?&light=0000&dark=ffffff&size=800&text=<?php echo $latestTicketTID ?>" alt="" class="img-responsive p-5" width="100%">
                                        <br>
                                        <h2 class="QR"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $latestTicketTID ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- qr modal end -->
                        <a href="/tickets/info?tid=<?php echo $latestTicketTID ?>" style="border-top-left-radius: 0px; border-top-right-radius: 0px;" class="w-100 btn btn-success"><i class="fa fa-info-circle" aria-hidden="true"></i> View info</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Movie name</th>
                        <th>Time</th>
                        <th>Seats</th>
                        <th>Hall</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // get all ticket id
                    $TID = mysqli_fetch_all(mysqli_query($cn, "SELECT ticketID FROM tickets WHERE userID = '$userID'"), MYSQLI_ASSOC);
                    $preTicketID = [];
                    foreach ($TID as $TIDS) {
                        array_push($preTicketID, $TIDS['ticketID']);
                    }
                    $ticketID = array_unique($preTicketID);
                    ?>
                    <?php foreach ($ticketID as $ticket) : ?>
                        <tr>
                            <td class="QR"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $ticket ?></td>
                            <td><?php
                                // movie name logic:
                                // get filmid from tickets where ticketid = $ticket
                                // get name from films where filmid = $filmid
                                $preFilmName = mysqli_fetch_all(mysqli_query($cn, "SELECT filmID FROM tickets WHERE ticketID = '$ticket'"), MYSQLI_ASSOC)[0]['filmID'];
                                echo mysqli_fetch_all(mysqli_query($cn, "SELECT name FROM films WHERE filmID = '$preFilmName'"), MYSQLI_ASSOC)[0]['name'];
                                ?></td>
                            <td><?php
                                $DT = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM assignedseats WHERE ticketID = '$ticket'"), MYSQLI_ASSOC)[0];
                                echo date('m/d/Y h:i A', $DT['time']);
                                ?></td>

                            <td><?php
                                $seats = mysqli_fetch_all(mysqli_query($cn, "SELECT seat FROM assignedseats WHERE ticketID = '$ticket'"), MYSQLI_ASSOC);
                                foreach ($seats as $seat) {
                                    echo $seat['seat'] . " ";
                                }
                                ?></td>

                            <td><?php
                                // locate hall name
                                // logic:
                                // time from assignedseats where ticketid match latestticketid
                                // hallid from showtimes where filmid match latestfilmid and time match time
                                // hallname from halls where halluniqid match hallid
                                $preHall1 = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM assignedseats WHERE ticketID = '$ticket'"), MYSQLI_ASSOC)[0]['time'];
                                $preHall2a = $recentDT['time'];
                                $preHall2 = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE filmID = '$preLFID' AND time = $preHall2a"), MYSQLI_ASSOC)[0]['hallID'];
                                echo mysqli_fetch_all(mysqli_query($cn, "SELECT hallName FROM halls WHERE hallUniqID = '$preHall2'"), MYSQLI_ASSOC)[0]['hallName'];
                                ?></td>
                            <td class="d-flex">
                                <!-- qr modal start -->
                                <button type="button" class="btn btn-primary w-50" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px;" data-bs-toggle="modal" data-bs-target="#viewQR-<?php echo $ticket ?>">
                                    <i class="fa fa-qrcode" aria-hidden="true"></i>
                                </button>
                                <div class="modal fade" id="viewQR-<?php echo $ticket ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="https://quickchart.io/qr?&light=0000&dark=ffffff&size=800&text=<?php echo $ticket ?>" alt="" class="img-responsive p-5" width="100%">
                                                <br>
                                                <h2 class="QR"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $ticket ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- qr modal end -->
                                <a href="/tickets/info?tid=<?php echo $ticket ?>" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;" class="w-50 btn btn-success"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php
}
?>