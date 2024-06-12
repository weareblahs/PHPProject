<?php

$title = 'Select seat';
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

    <div class="bg-dark" data-bs-theme="dark">
        <div class="container" style="color: #ffffff;">
            <div class="text-center center-div d-flex">
                <h1 class="text-center">
                    <i class="previous-fill bi bi-1-circle-fill"></i>
                    <i class="previous-fill bi bi-caret-right-fill"></i>
                    <i class="current-fill bi bi-2-circle-fill"></i>
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


    <!-- select seat -->
    <div class="container p-4">
        <?php
        $seatmapDir = '../../admin/halls/seatmap/' . $hallID . '.php';
        require_once $seatmapDir;
        ?>
        <form method="POST" action="/ticketing/addons" style="margin-left: auto !important; margin-right: auto !important">
            <input type="hidden" name="date" value="<?php echo $date ?>">
            <input type="hidden" name="filmID" value="<?php echo $filmID ?>">
            <input type="hidden" name="showtimeID" value="<?php echo $showtimeID ?>">
            <input type="hidden" name="time" value="<?php echo $_GET['time'] ?>">
            <input type="hidden" name="stepFinished" value="1">
            <?php getSeatmap() ?>
            <center>
                <div class="row container w-100 d-flex">
                    <div class="col-4"><i class="fa fa-square" aria-hidden="true"></i> Available</div>
                    <div class="col-4"><i class="fa fa-square" style="color: green;" aria-hidden="true"></i> Selected</div>
                    <div class="col-4"><i class="fa fa-square" style="color: red;" aria-hidden="true"></i> Reserved</div>
                </div>
            </center>
            <button class="w-100 btn btn-success m-3">Next</button>
        </form>

    </div>

<?php
}
?>