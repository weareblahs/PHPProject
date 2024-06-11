<?php

$title = 'Movie details';

require_once '../elements/layout.php';


function get_content()
{
    require_once '../backend/sql_init.php';

    // get movie details
    $filmID = $_GET['id'];
    $get_film_details_query = "SELECT * FROM films WHERE filmID = '$filmID'";
    $film = mysqli_fetch_assoc(mysqli_query($cn, $get_film_details_query));
    $film_date = strtotime($film['releaseDate']);
    $runningTimePre = $film['length'];
    $runningTime = intdiv($runningTimePre, 60) . 'hr ' . ($runningTimePre % 60) . 'min';
    // get showtime details
    $showtimeID = mysqli_fetch_all(mysqli_query($cn, "SELECT associatedShowtimeID FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0]['associatedShowtimeID'];
    $showtimes = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC);
    // showtime pre-processing
    if ($showtimes !== []) {
        foreach ($showtimes as $showtime) {
            $epoch = $showtime['time'];
            $dt = new DateTime("@$epoch");
            $showtimeDate[] = $dt->format('Y-m-d');
        }
        $dateYesterday = date("Y-m-d", strtotime("yesterday"));
        $preFSD = array_unique($showtimeDate);
        $filteredShowtimeDates = array_diff($preFSD, [$dateYesterday]);
    }

?>
    <div>

    </div>
    <?php if (isset($filmID)) : ?>
        <div class="bg-dark">
            <div class="p-4 container">
                <div class="row">
                    <div class="col-6 text-dark-bg" style="margin-top: auto; margin-bottom: auto">
                        <img src="<?php echo $film['artwork'] ?>" alt="" class="img-responsive" width="100%">
                    </div>
                    <div class="col-6 text-dark-bg">
                        <h1><?php echo $film['name'] ?></h1>
                        <?php if ($film['altName'] != "none") : ?>
                            <h3><i><?php echo $film['altName'] ?></i></h3>
                        <?php else : ?>
                        <?php endif; ?>
                        <p><?php echo getdate($film_date)['year'] ?> | <?php echo $film['filmGenre'] ?> | <?php echo $film['language'] ?> | <?php echo $runningTime ?></p>
                        <p><?php echo $film['filmDescription'] ?></p>
                        <?php if ($film['trailerURL'] != '') : ?>
                            <a href="<?php echo $film['trailerURL'] ?>" class="btn btn-danger"><i class="fa fa-play" aria-hidden="true"></i> View Trailer</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="row p-4 container mx-auto">
                <div class="col-3 mx-auto">
                    <h6><i class="fa fa-film" aria-hidden="true"></i> Rating</h6>
                    <?php if ($film['filmRating'] == "U") : ?>
                        <div class="row">
                            <div class="col-2">
                                <img src="/assets_public/images/filmRatings/<?php echo $film['filmRating'] ?>.png" alt="" class="img-responsive" height="40px">
                            </div>
                            <div class="col-10">
                                General viewing for all ages
                            </div>
                        </div>
                    <?php elseif ($film['filmRating'] == "P12") : ?>
                        <div class="row">
                            <div class="col-2" style="margin-top: auto; margin-bottom: auto">
                                <img src="/assets_public/images/filmRatings/<?php echo $film['filmRating'] ?>.png" alt="" class="img-responsive" height="40px">
                            </div>
                            <div class="col-10">
                                Parental guidance required for audiences under the age of 12
                            </div>
                        </div>
                    <?php elseif ($film['filmRating'] == "13") : ?>
                        <div class="row">
                            <div class="col-2" style="margin-top: auto; margin-bottom: auto">
                                <img src="/assets_public/images/filmRatings/<?php echo $film['filmRating'] ?>.png" alt="" class="img-responsive" height="40px">
                            </div>
                            <div class="col-10">
                                For audiences aged 13 years old and above
                            </div>
                        </div>
                    <?php elseif ($film['filmRating'] == "16") : ?>
                        <div class="row">
                            <div class="col-2" style="margin-top: auto; margin-bottom: auto">
                                <img src="/assets_public/images/filmRatings/<?php echo $film['filmRating'] ?>.png" alt="" class="img-responsive" height="40px">
                            </div>
                            <div class="col-10">
                                For audiences aged 16 years old and above
                            </div>
                        </div>
                    <?php elseif ($film['filmRating'] == "18") : ?>
                        <div class="row">
                            <div class="col-2" style="margin-top: auto; margin-bottom: auto">
                                <img src="/assets_public/images/filmRatings/<?php echo $film['filmRating'] ?>.png" alt="" class="img-responsive" height="40px">
                            </div>
                            <div class="col-10">
                                For audience aged 18 years old or above with elements for mature audiences
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-3 mx-auto">
                    <h6><i class="fa fa-user" aria-hidden="true"></i> Cast</h6>
                    <h5><?php echo $film['cast'] ?></h5>
                </div>
                <div class="col-3 mx-auto">
                    <h6><i class="fa fa-video-camera" aria-hidden="true"></i> Director</h6>
                    <h5><?php echo $film['director'] ?></h5>
                </div>

                <div class="col-3 mx-auto">
                    <h6><i class="fa-solid fa-closed-captioning" aria-hidden="true"></i> Subtitles</h6>
                    <h5><?php echo $film['subtitle'] ?></h5>
                </div>
            </div>
        </div>

        <?php if (isset($showtimeDate)) : ?>
            <div class="container">
                <h1 class="text-center">Select a date to continue booking:</h1>
                <div class="row container">
                    <?php foreach ($filteredShowtimeDates as $filteredShowtimeDate) : ?>
                        <?php
                        $currentDate = time();
                        $timeFSD = strtotime($filteredShowtimeDate) + 86400;
                        if ($timeFSD <= $currentDate) : ?>
                        <?php else : ?>
                            <div class="col-3 ticketingDate"><a href="/ticketing/time?date=<?php echo $filteredShowtimeDate ?>&filmID=<?php echo $filmID ?>&showtimeID=<?php echo $showtimeID ?>"><?php
                                                                                                                                                                                                    $timestamp = strtotime($filteredShowtimeDate);
                                                                                                                                                                                                    $formattedDate = date('j F', $timestamp);
                                                                                                                                                                                                    echo $formattedDate;
                                                                                                                                                                                                    ?></a></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="container">
                <h1 class="text-center">There are no showtimes available. Check back soon.</h1>
            </div>
        <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="p-5">
            <h1>Movie not found</h1>
        </div>
    <?php endif; ?>
<?php
}

?>