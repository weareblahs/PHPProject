<?php

$title = 'Global Settings';
require_once '../../elements/layout.php';
function get_content()
{
    require_once '../../backend/sql_init.php';
    // get global settings value
    $value = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM globalsettings"), MYSQLI_ASSOC)[0];
?>
    <div class="container p-4">
        <h1>Global settings</h1>
        <form action="/admin/globalSettings/modifySettings.php" method="POST">
            <div>
                <h4><b>Showtimes</b></h4>
                <div class="row">
                    <div class="col-6">
                        <h2>Interval time</h2>
                    </div>
                    <div class="col-6">
                        <input type="number" class="form-control" id="intervalTime" name="intervalTime" value="<?php echo $value['intervalTime'] ?>">
                        <label for="">Set interval time after movie (in minutes).</label>
                    </div>

                    <div class="col-6">
                        <h2>First showtime</h2>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="showStart" name="showStart" value="<?php echo $value['showStart'] ?>">

                    </div>

                    <div class="col-6">
                        <h2>Last showtime</h2>

                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="showEnd" name="showEnd" value="<?php echo $value['showEnd'] ?>">
                        <div>

                            <input type="radio" name="dayValue" id="dayValue" value="+0 day">
                            <label for="">This day</label>
                            <input type="radio" name="dayValue" id="dayValue" value="+1 day">
                            <label for="">Next day </label>
                            <label for=""><i>(Day value currently set to <?php echo $value['dayValue'] ?>)</i></label>
                        </div>
                    </div>
                    <div class="container"><button class="w-100 btn btn-success">Save</button></div>
                </div>
            </div>
        </form>
    </div>
<?php
}
?>