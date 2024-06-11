<?php
$title = '';
require_once '../../../elements/layout.php';
function get_content()
{
    require_once '../../../backend/sql_init.php';
    // get movie data from id submitted via GET
    $filmID = $_GET['id'];
    $get_film_query = "SELECT * FROM films WHERE filmID = '$filmID'";
    $film_properties = mysqli_fetch_all(mysqli_query($cn, $get_film_query), MYSQLI_ASSOC)[0];
?>

    <div class="container p-4">
        <h1>Edit showtimes</h1>
        <div class="row">
            <div class="col-2">
                <p>You're currently modifying the showtimes for:</p>
                <img src="<?php echo $film_properties['imagePosterPath'] ?>" alt="" class="img-responsive" width="100%">
                <h3><?php echo $film_properties['name'] ?></h3>
            </div>
            <div class="col-10">
                <iframe src="/admin/showtimes/edit/addWizard/1.php?id=<?php echo $_GET['id'] ?>" frameborder="0" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>

<?php

}
?>