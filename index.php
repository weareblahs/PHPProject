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
    $get_films_query = "SELECT * FROM films";
    $films = mysqli_fetch_all(mysqli_query($cn, $get_films_query));
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
    <div class="container p-2">
        <h2>Movies</h2>
        <div class="row">
            <?php foreach ($films as $film) : ?>
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
<?php
}
?>