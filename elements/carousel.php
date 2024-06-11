<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>


<?php


require_once 'backend/sql_init.php';
function view_carousel($cn)
{
    $view_film_query = "SELECT * FROM films WHERE isFeatured = 1";
    $featuredFilms = mysqli_fetch_all(mysqli_query($cn, $view_film_query), MYSQLI_ASSOC);

?>
    <div class="d-lg-none d-md-none d-sm-block" style="background-color: black;">
        <div class="single-item container">
            <?php
            foreach ($featuredFilms as $film) : ?>
                <!-- mobile / tablet carousel -->
                <div class="">
                    <div>
                        <div class="p-4 container">
                            <div class="row" style="margin-top: auto; margin-bottom: auto">
                                <div class="col-lg-6 col-sm-12 col-md-12 text-dark-bg" style="margin-top: auto; margin-bottom: auto">
                                    <img src="<?php echo $film['artwork'] ?>" alt="" class="img-responsive" width="100%">
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-12 text-dark-bg" style="margin-top: auto; margin-bottom: auto">
                                    <?php
                                    if ($film['logoAvailable'] == true) : ?>
                                        <img src="<?php echo $film['logoPath'] ?>" alt="" class="img-responsive py-4" width="80%">
                                    <?php else : ?>
                                        <h1 style="font-size: 5em; line-height: 1em"><?php echo $film['name'] ?></h1>
                                        <h3><i><?php echo $film['altName'] ?></i></h3>
                                    <?php endif; ?>
                                    <a href="/filmDetails?id=<?php echo $film['filmID'] ?>" class="btn btn-success"><i class="fa fa-film" aria-hidden="true"></i> View details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- pc carousel -->
            <?php endforeach; ?>
        </div>
    </div>
    <div class="pc-carousel">
        <?php foreach ($featuredFilms as $film) : ?>
            <div class="d-lg-block d-md-block d-sm-none">
                <div id="parent-div" style="background: url('<?php echo $film['artwork'] ?>'); height: 30em; background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                    <div class="preChildDiv">
                        <div class="row container child-div">
                            <div class="col-10">
                                <?php
                                if ($film['logoAvailable'] == true) : ?>
                                    <img src="<?php echo $film['logoPath'] ?>" alt="" class="img-responsive" width="25%">
                                <?php else : ?>
                                    <h1><?php echo $film['name'] ?></h1>
                                    <h3><i><?php echo $film['altName'] ?></i></h3>
                                <?php endif; ?>
                            </div>
                            <div class="col-2" style="margin-top: auto; margin-bottom: auto"><a href="/filmDetails?id=<?php echo $film['filmID'] ?>" class="btn btn-success"><i class="fa fa-film" aria-hidden="true"></i> View details</a></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('.single-item').slick({
            variableWidth: true,
            mobileFirst: true,
            autoplay: true,
            autoplaySpeed: 5000,
        });
        $('.pc-carousel').slick({
            autoplay: true,
            autoplaySpeed: 5000
        });
    </script>

</html>
<?php
}
?>