<?php
$title = 'Edit showtimes';
require_once '../../../../elements/layout_lite.php';
head();
?>

<?php
require_once '../../../../backend/sql_init.php';
// get movie data from id submitted via GET
$filmID = $_GET['id'];
$get_film_query = "SELECT * FROM films WHERE filmID = '$filmID'";
$film_properties = mysqli_fetch_all(mysqli_query($cn, $get_film_query), MYSQLI_ASSOC)[0]; ?>

<body data-bs-theme="dark">
    <h1 class="text-center"></h1>
    <div class="row center-div">
        <div class="col-3">
            <h4><span style="color: green;">
                    <i class="bi bi-1-circle-fill"></i>
                </span></h4>
        </div>
        <div class="col-3">
            <h4><i class="bi bi-2-circle"></i></h4>
        </div>
        <div class="col-3">
            <h4><i class="bi bi-3-circle"></i></h4>
        </div>
        <div class="col-3">
            <h4><i class="bi bi-4-circle"></i></h4>
        </div>
    </div>

    <div class="center-div">
        <h3 class="text-center">Select hall type</h3>
        <div class="container">
            <h5 class="text-center container">Limited to <b>one experience per movie</b>. If you want to change an experience, please use the "Edit" menu to change experience</h5>
        </div>
    </div>
    <form action="2.php" method="POST">
        <!-- pass previous table data (GET/ID) -->
        <input type="hidden" name="id" value="<?php echo $filmID ?>">
        <table class="table container">
            <thead>
                <tr>
                    <th></th>
                    <th>Hall name</th>
                    <th>Hall ID</th>
                    <th>Experience name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // get halls data
                $currentExperienceID = $film_properties['experienceID'];
                $get_halls_query = "SELECT * FROM halls WHERE experienceID = '$currentExperienceID';";
                $get_experience_name = mysqli_fetch_all(mysqli_query($cn, "SELECT name FROM cinemaexperiences WHERE uniqID = '$currentExperienceID'"), MYSQLI_ASSOC)[0]["name"];
                $halls = mysqli_fetch_all(mysqli_query($cn, $get_halls_query), MYSQLI_ASSOC);
                foreach ($halls as $hall) : ?>
                    <tr>
                        <td><input type="radio" name="hallID" id="hallID" value="<?php echo $hall['hallUniqID'] ?>"></td>
                        <td><?php echo $hall['hallName'] ?></td>
                        <td><?php echo $hall['hallUniqID'] ?></td>
                        <td><?php echo $get_experience_name ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="container">
            <button class="btn btn-success w-100"><i class="fa fa-angle-right" aria-hidden="true"></i> Next: Select Date</button>
        </div>
    </form>
</body>
<?php

endofpage();
?>