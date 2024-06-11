<?php
require_once '../../elements/layout.php';
function get_content()
{
?>

    <?php
    if (isset($_GET['done'])) {
        if ($_GET['done'] == 1) {
            echo '<div class="alert alert-success container" role="alert">';
            echo '<i class="fa fa-check" aria-hidden="true"></i> Cleanup completed successfully';
            echo "</div>";
        }
    }

    ?>
    <div class="text-center container p-4 form">
        <h1>Select items for cleanup</h1>
        <br>
        <form action="/admin/admin_backend/cleanup.php" method="POST">
            <div class="btn" role="group" aria-label="Basic checkbox toggle button group">
                <input type="checkbox" class="btn-check" name="checkbox[]" id="checkbox1" autocomplete="off" value="showtimesBeyondCurrent">
                <label class="btn btn-outline-primary" for="checkbox1"><i class="fa fa-clock" aria-hidden="true"></i> Clean showtimes beyond current time</label>
                <br>
                <br>
                <input type="checkbox" class="btn-check" name="checkbox[]" id="checkbox2" autocomplete="off" value="ticketsBeyondCurrent">
                <label class="btn btn-outline-primary" for="checkbox2"><i class="fa fa-ticket" aria-hidden="true"></i> Clean tickets beyond current showtime</label>
            </div>
            <br>
            <br>
            <button class="btn btn-primary text-center">Start</button>
        </form>
    </div>
<?php
}
?>