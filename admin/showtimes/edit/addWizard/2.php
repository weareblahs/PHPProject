<?php
$title = 'Edit showtimes';
require_once '../../../../elements/layout_lite.php';
head();
?>

<?php
require_once '../../../../backend/sql_init.php';
// get movie data from id submitted via GET
$dateToday = date("Y-m-d");
$dateCount = array("0", "1", "2", "3", "4", "5", "6");
// previous step data start
$filmID = $_POST['id'];
$hallID = $_POST['hallID'];
// previous step data end
$get_film_query = "SELECT * FROM films WHERE filmID = '$filmID'";
$film_properties = mysqli_fetch_all(mysqli_query($cn, $get_film_query), MYSQLI_ASSOC)[0]; ?>

<body data-bs-theme="dark">
    <h1 class="text-center"></h1>
    <div class="row center-div">
        <div class="col-3">
            <h4><i class="bi bi-1-circle-fill"></i></h4>
        </div>
        <div class="col-3">
            <h4><span style="color: green;"><i class="bi bi-2-circle-fill"></i></span></h4>
        </div>
        <div class="col-3">
            <h4><i class="bi bi-3-circle"></i></h4>
        </div>
        <div class="col-3">
            <h4><i class="bi bi-4-circle"></i></h4>
        </div>
    </div>
    <div class="center-div">
        <h3 class="text-center">Select date</h3>
        <h3 class="text-center">These are the valid dates that you can select for ticketing purposes.</h3>
    </div>
    <div class="center-div p-2">
        <form action="3.php" method="POST">
            <!-- previous step data -->
            <input type="hidden" name="filmID" id="filmID" value="<?php echo $filmID ?>">
            <input type="hidden" name="hallID" id="hallID" value="<?php echo $hallID ?>">
            <div>
                <input type="checkbox" onclick="toggle(this);" /> Select all dates listed below<br />
            </div>
            <?php foreach ($dateCount as $dateFuture) : ?>
                <div class="">
                    <?php $timeYMD = date('Y-m-d', strtotime($dateToday . ' + ' . $dateFuture . 'days'));
                    $timestamp = strtotime($timeYMD);
                    $timeText = date(' dS F Y \(l\)', $timestamp);  ?>
                    <input type="checkbox" name="filmDate[]" id="filmDate[]" value="<?php echo $timeYMD ?>">
                    <label for=""><?php echo $timeText ?></label>
                </div>
            <?php endforeach; ?>
    </div>
    <div class="container">
        <button class="btn btn-success w-100 m-2"><i class="fa fa-angle-right" aria-hidden="true"></i> Next: Select Time</button>
    </div>
    </form>
</body>
<?php

endofpage();
?>

<script>
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
</script>