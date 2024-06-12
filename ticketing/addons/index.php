<?php

$title = 'Select addons';
require_once '../../elements/layout.php';
function get_content()
{
    $date = $_POST['date'];
    $filmID = $_POST['filmID'];
    $showtimeID = $_POST['showtimeID'];
    $seats = $_POST['seats'];
    $time = $_POST['time'];
    // get required stuff
    require_once '../../backend/sql_init.php';
    $filmInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0];
    $hallID = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC)[0]['hallID'];
    $addons = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM addon"), MYSQLI_ASSOC);

?>

    <div class="bg-dark">
        <div class="container" style="color: #ffffff;">
            <div class="text-center center-div d-flex">
                <h1 class="text-center">
                    <i class="previous-fill bi bi-1-circle-fill"></i>
                    <i class="previous-fill bi bi-caret-right-fill"></i>
                    <i class="previous-fill bi bi-2-circle-fill"></i>
                    <i class="previous-fill bi bi-caret-right-fill"></i>
                    <i class="current-fill bi bi-3-circle-fill"></i>
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

    <!-- addons -->
    <form action="/ticketing/payment" method="POST">
        <div class="container p-4">
            <h1>Select addons</h1>
            <!-- addon selection start -->
            <?php foreach ($addons as $addon) : ?>
                <div class="card mb-3" style=" max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo $addon['addonImage'] ?>" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $addon['addonName'] ?></h5>
                                <p class="card-text"><?php echo $addon['addonDescription'] ?> </p>
                                <h5 class="card-title">RM <?php echo $addon['addonPrice'] ?></h5>
                                <div class="container row">
                                    <div class="col-12">
                                        <input type="hidden" name="productProperties['property']['name']" value="<?php echo $addon['addonUniqID'] ?>">
                                        <input type="hidden" name="stepFinished" value="1">
                                        <input type="number" name="productProperties['property']['quantity']" id="product['<?php $addon['addonUniqID'] ?>']['value']" value="0" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    <?php endforeach ?>
    <div class="container">
        <input type="hidden" name="date" value="<?php echo $date ?>">
        <input type="hidden" name="filmID" value="<?php echo $filmID ?>">
        <input type="hidden" name="showtimeID" value="<?php echo $showtimeID ?>">
        <?php foreach ($seats as $seat) : ?>
            <input type="hidden" name="seats[]" value="<?php echo $seat ?>">
        <?php endforeach; ?>
        <input type="hidden" name="time" value="<?php echo $time ?>">
        <button type="submit" value="" class="btn btn-success w-100">Next</button>
    </div>
    </div>
    </form>
<?php
}
?>