<?php

$title = 'Select time';
require_once '../../elements/layout.php';
function get_content()
{
    $date = $_GET['date'];
    $filmID = $_GET['filmID'];
    $showtimeID = $_GET['showtimeID'];
    // get required stuff
    require_once '../../backend/sql_init.php';
    $filmInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0];
    $hallID = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC)[0]['hallID'];
?>
    <div class="bg-dark">
        <div class="container" style="color: #ffffff;">
            <div class="text-center center-div d-flex">
                <h1 class="text-center">
                    <i class="current-fill bi bi-1-circle-fill"></i>
                    <i class="bi bi-caret-right-fill"></i>
                    <i class="bi bi-2-circle"></i>
                    <i class="bi bi-caret-right-fill"></i>
                    <i class="bi bi-3-circle"></i>
                    <i class="bi bi-caret-right-fill"></i>
                    <i class="bi bi-4-circle"></i>
            </div>
            </h1>
            <div class="">
                <div class="row">
                    <div class="col-5 text-end"><img src="<?php echo $filmInfo['imagePosterPath'] ?>" alt="" class="img-responsive" width="100px"></div>
                    <div class="col-7 d-block" style="margin-top: auto; margin-bottom: auto">
                        <h1><?php echo $filmInfo['name'] ?></h1>
                        <div class="d-flex">
                            <div style="width:55px;"><img src="/assets_public/images/filmRatings/<?php echo $filmInfo['filmRating'] ?>.png" alt="" style="margin-left: auto; margin-right: auto" class="img-responsive" width="40px"></div>
                            <div style="margin-top: auto; margin-bottom: auto">
                                <h6><?php echo $filmInfo['filmGenre'] ?> | <i class="bi bi-volume-up-fill"></i> <?php echo $filmInfo['language'] ?><br><i class="fa-regular fa-closed-captioning"></i> <?php echo $filmInfo['subtitle'] ?> | <i class="fa fa-clock" aria-hidden="true"></i> <?php echo $filmInfo['length'] ?> minutes</h6>
                            </div>
                        </div>
                        <p class=""><i class="fa fa-calendar" aria-hidden="true"></i> <i>Currently booking tickets for <?php $timeStr = strtotime($date);
                                                                                                                        echo date("d M Y", $timeStr) ?></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- "select time" -->
    <div class="container">
        <div class="row">
            <div class="col-2 p-2">
                <h3>Select time</h3>
                <div class="ticketingTimeIndicator">
                    <?php echo date("d M Y", $timeStr) ?>
                </div>
                <div class="ticketingDate">
                    <a href="/filmDetails?id=<?php echo $filmInfo['filmID'] ?>">Other dates</a>
                </div>
            </div>
            <div class="col-10">
                <h3><br></h3>
                <div class="row">

                    <?php
                    $showtimes = [];
                    $preshowtimes = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC);
                    $startDate = strtotime($date . "00:00:00");
                    $endDate = strtotime("+1 day", $startDate);
                    foreach ($preshowtimes as $preshowtime) {
                        if ($preshowtime["time"] >= $startDate && $preshowtime["time"] <= $endDate) {
                            array_push($showtimes, $preshowtime["time"]);
                        }
                    }
                    foreach ($showtimes as $showtime) : ?>

                        <?php $currentTime = time() + 21600;
                        if ($currentTime > $showtime) : ?>


                        <?php else : ?>
                            <div class="col-3">
                                <div class="ticketingDate">
                                    <a href="/ticketing/seatSelection?filmID=<?php echo $filmID ?>&showtimeID=<?php echo $showtimeID ?>&time=<?php echo $showtime ?>&date=<?php echo $date ?>">

                                        <?php echo date("h:i A", $showtime) ?>
                                        <br>
                                        <?php
                                        $hallName = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM halls WHERE hallUniqID = '$hallID'"), MYSQLI_ASSOC)[0]["hallName"];
                                        echo $hallName ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
<?php
}
?>