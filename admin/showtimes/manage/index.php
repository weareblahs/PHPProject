<?php
$title = 'Manage showtimes';
require_once '../../../elements/layout.php';

function get_content()
{
    require_once '../../../backend/sql_init.php';
    $filmID = $_GET['id'];
    $asi = mysqli_fetch_all(mysqli_query($cn, "SELECT name, associatedShowtimeID FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0];
?>

    <div class="container p-3">
        <h1 class="text-center">Manage showtime</h1>
        <?php if (strlen($asi['associatedShowtimeID']) != "none") : ?>
            <h4 class="text-center">
                <i><?php echo $asi['name'] ?></i> currently has showtimes registered under the showtime ID <?php echo $asi['associatedShowtimeID'] ?>.
                <br>
                To change showtimes, please use the "Re-add" button below to clear all current showtimes and add again.
            </h4>
            <div class="center-div">
                <br>
                <div class="text-center"><a href="/admin/showtimes/edit/readdShowtime.php?showtimeID=<?php echo $asi['associatedShowtimeID'] ?>&filmID=<?php echo $filmID ?>" class="btn btn-success"><i class="fa fa-repeat" aria-hidden="true"></i> Re-add showtimes</a>
                    <br>
                    <label for="" class="text-center"><i>Re-adding a showtime requires deletion of existing showtimes and showtime ID linked to this movie. A new showtime ID will be generated.</i></label>
                </div>
                <br>
                <div class="text-center"><a href="/admin/showtimes/edit/deleteShowtime.php?showtimeID=<?php echo $asi['associatedShowtimeID'] ?>" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete showtimes</a>
                    <br>
                    <label for="" class="text-center"><i>Deletes the showtime and showtime ID. You can add a new one anytime.</i></label>
                </div>

            </div>
        <?php else : ?>
            <?php header('Location: /admin/showtimes'); ?>
        <?php endif; ?>
    </div>

<?php
}
?>