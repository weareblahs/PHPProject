<?php
require_once '../../../../elements/layout_lite.php';
require_once '../../../../backend/sql_init.php';
// previous form data start
$filmID = $_POST['filmID'];
$hallID = $_POST['hallID'];
$filmDates = $_POST['filmDate'];
// previous form data end

// get showtimes
$showtime = mysqli_fetch_all(mysqli_query($cn, "SELECT length FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0]['length'];
// get interval time
$intervalTime = mysqli_fetch_all(mysqli_query($cn, "SELECT intervalTime FROM globalsettings"), MYSQLI_ASSOC)[0]['intervalTime'];

//generate final film time
$fft = $showtime + intval($intervalTime);
$min = round(date("i") / 15) * 15;
$start = strtotime('06:00');
$end = strtotime('+1 day', strtotime('05:00'));
$range = array();
while ($start <= $end) {
    $tempTime = date('h:ia', $start);
    array_push($range, $tempTime);
    $start = strtotime('+' . $fft . ' minutes', $start);
}
head();
?>

<body data-bs-theme="dark">
    <div class="row center-div">
        <div class="col-3">
            <h4><i class="bi bi-1-circle-fill"></i></h4>
        </div>
        <div class="col-3">
            <h4><i class="bi bi-2-circle-fill"></i></h4>
        </div>
        <div class="col-3">
            <h4><span style="color: green;"><i class="bi bi-3-circle-fill"></i></span></h4>
        </div>
        <div class="col-3">
            <h4><i class="bi bi-4-circle"></i></h4>
        </div>
    </div>
    <h1 class="text-center">Select time for selected dates</h1>
    <p class="text-center container"><i>Do note that these times are generated using the movie length and the interval time set at the "Global Settings" page at the Admin portal, which can be accessed <a href="/admin/globalSettings" target="_blank">here</a>.</i></p>
    <div class="row container center-div">


        <form action="4.php" method="POST">
            <!-- previous form data start -->
            <input type="hidden" name="filmID" value="<?php echo $filmID ?>">
            <input type="hidden" name="hallID" value="<?php echo $hallID ?>">
            <!-- previous form data end -->
            <div class="container center-div">
                <input type="checkbox" onclick="toggle(this);" /> Select all times listed below<br />
            </div>
            <?php foreach ($filmDates as $filmDate) : ?>
                <?php $timeYMD = $filmDate;
                $timestamp = strtotime($timeYMD);
                $timeText = date(' dS F Y \(l\)', $timestamp);
                ?>
                <div class="col-6" style="margin-left: auto; margin-right: auto;">
                    <h4 class="align-end"><?php echo $timeText ?></h4>
                    <div class="row center-div">
                        <?php foreach ($range as $time) : ?>
                            <div class="col-6">
                                <?php
                                $timeString = strtotime($filmDate . " " . $time);
                                ?>
                                <input type="checkbox" name="showtimes[]" id="showtimes[]" value="<?php echo $timeString ?>">
                                <label for="" style="font-size: medium"><?php echo $time ?></label>
                                <br>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endforeach; ?>
    </div>
    <div class="container">
        <button class="btn btn-success w-100 m-2"><i class="fa-solid fa-check" aria-hidden="true"></i> Next: Finalize</button>
    </div>
    </div>
    </form>
</body>

<script>
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
</script>