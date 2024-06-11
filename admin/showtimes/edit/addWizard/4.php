<?php

require_once '../../../../elements/layout_lite.php';
require_once '../../../../backend/sql_init.php';

$filmID = $_POST['filmID'];
$hallID = $_POST['hallID'];
head();
// get film info
$filmName = mysqli_fetch_all(mysqli_query($cn, "SELECT name FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0]['name'];
// get hall info
$hallName = mysqli_fetch_all(mysqli_query($cn, "SELECT hallName FROM halls WHERE hallUniqID = '$hallID'"), MYSQLI_ASSOC)[0]['hallName'];
$showtimes = $_POST['showtimes'];
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
            <h4><i class="bi bi-3-circle-fill"></i></h4>
        </div>
        <div class="col-3">
            <h4><span style="color: green;"><i class="bi bi-4-circle-fill"></i></span></h4>
        </div>
    </div>

    <div class="container">
        <h1 class="text-center">
            Finalize showtime creation
        </h1>
        <h4 class="text-center">Please check if the selections are correct before submitting to the database.</h4>
    </div>
    <table class="table table-striped-columns container">
        <tbody>
            <tr>
                <td>Movie name</td>
                <td><?php echo $filmName ?></td>
            </tr>
            <tr>
                <td>Hall name</td>
                <td><?php echo $hallName ?></td>
            </tr>
            <tr>
                <td>Selected times</td>
                <td>
                    <ul>
                        <?php foreach ($showtimes as $showtime) : ?>
                            <li><?php
                                $showtimeInt = intval($showtime);
                                echo date('M d Y h:i A', $showtimeInt) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    <form action="/admin/admin_backend/submitShowtimes.php" method="POST">
        <input type="hidden" name="showtimeID" value="<?php echo uniqid() ?>">
        <input type="hidden" name="filmID" value="<?php echo $filmID ?>">
        <input type="hidden" name="hallID" value="<?php echo $hallID ?>">
        <?php foreach ($showtimes as $showtime) : ?>
            <input type="hidden" name="showtimes[]" value="<?php echo $showtime ?>">
        <?php endforeach; ?>
        <button class="w-100 btn btn-success">Complete addition</button>
    </form>
</body>