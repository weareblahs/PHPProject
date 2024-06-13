<?php
$title = "Home";
require_once 'elements/layout.php';
require_once 'backend/sql_init.php';
function get_content()
{
    require_once 'backend/sql_init.php';
    require_once 'elements/carousel.php';
    // check if user is admin. if so, then show alert
    if (isset($_COOKIE['userID'])) {
        $userID = $_COOKIE['userID'];
        $is_admin_query = "SELECT isAdmin FROM users where userUniqID = '$userID'";
        $is_admin_property = mysqli_fetch_assoc(mysqli_query($cn, $is_admin_query));
    } else {
        $is_admin_property = 0;
    }

    // get movies list
    $get_available_query = "SELECT * FROM films WHERE isAvailable = 1 AND releaseDate <= CURDATE()";
    $availableFilms = mysqli_fetch_all(mysqli_query($cn, $get_available_query));
    // get upcoming movies list
    $get_upcoming_query = "SELECT * FROM films WHERE isAvailable = 1 AND releaseDate > CURDATE()";
    $upcomingFilms = mysqli_fetch_all(mysqli_query($cn, $get_upcoming_query));
?>

    <?php if (isset($_COOKIE['userID'])) : ?>
        <?php if ($is_admin_property['isAdmin'] == 1) : ?>
            <div class="alert alert-primary" role="alert">
                It seems like you're an admin. If you want to purchase tickets, please use an user account. To access the admin dashboard, <a href="/admin">click here</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- main content -->

    <?php view_carousel($cn) ?>

    <div class="container py-4">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-nowShowing-tab" data-bs-toggle="pill" data-bs-target="#pills-nowShowing" type="button" role="tab" aria-controls="pills-nowShowing" aria-selected="true">Now showing</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-comingSoon-tab" data-bs-toggle="pill" data-bs-target="#pills-comingSoon" type="button" role="tab" aria-controls="pills-comingSoon" aria-selected="false">Coming soon</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane show active" id="pills-nowShowing" role="tabpanel" aria-labelledby="pills-nowShowing-tab" tabindex="0">
                <div class="">
                    <div class="row">
                        <?php foreach ($availableFilms as $film) : ?>
                            <div class="col-lg-2 col-sm-6 col-md-4">
                                <a href="/filmDetails?id=<?php echo $film[0] ?>"><img src="<?php echo $film[13] ?>" alt="" class="img-responsive" width="100%"></a>
                                <div class="row">
                                    <div class="col-9">
                                        <h6 style="margin-top: auto; margin-bottom: auto"><?php echo $film[2] ?></h6>
                                        <?php
                                        $get_experience_query = "SELECT * FROM cinemaexperiences WHERE uniqID = '$film[1]';";
                                        $experience = mysqli_fetch_assoc(mysqli_query($cn, $get_experience_query));
                                        ?>
                                        <div><span class="badge text-bg-primary"><?php echo $experience['name'] ?></span></div>
                                    </div>
                                    <div class="col-3"><img src="/assets_public/images/filmRatings/<?php echo $film[5] ?>.png" alt="" class="img-responsive" width="100%"></div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="pills-comingSoon" role="tabpanel" aria-labelledby="pills-comingSoon-tab" tabindex="0">
                <div class="">
                    <div class="row">
                        <?php foreach ($upcomingFilms as $film) : ?>
                            <div class="col-lg-2 col-sm-6 col-md-4">
                                <a href="/filmDetails?id=<?php echo $film[0] ?>"><img src="<?php echo $film[13] ?>" alt="" class="img-responsive" width="100%"></a>
                                <div class="row">
                                    <div class="col-9">
                                        <h6 style="margin-top: auto; margin-bottom: auto"><?php echo $film[2] ?></h6>
                                        <?php
                                        $get_experience_query = "SELECT * FROM cinemaexperiences WHERE uniqID = '$film[1]';";
                                        $experience = mysqli_fetch_all(mysqli_query($cn, $get_experience_query), MYSQLI_ASSOC)[0];
                                        ?>
                                        <div><span class="badge text-bg-primary"><?php echo $experience['name'] ?></span>
                                            <?php
                                            if ($film['15'] !== "none") {
                                                echo '<span class="badge text-bg-primary">Advance booking</span>';
                                            } else {
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-3"><img src="/assets_public/images/filmRatings/<?php echo $film[5] ?>.png" alt="" class="img-responsive" width="100%"></div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>


<?php
}
?>