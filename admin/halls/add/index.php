<?php
$title = 'Add hall';
require_once '../../../elements/layout.php';

function get_content()
{
    require_once '../../../backend/sql_init.php';
    $uniqID = uniqid();
    // get experience
    $get_experience = "SELECT * FROM cinemaexperiences";
    $experiences = mysqli_fetch_all(mysqli_query($cn, $get_experience), MYSQLI_ASSOC);

?>
    <div class="container p-2 w-50" class="align-content: center;">
        <center>
            <h1 class="">Add hall</h1>
        </center>
    </div>
    <form action="/admin/admin_backend/add_hall.php" method="POST" class="form-group container w-50">
        <input type="hidden" name="uniqID" id="uniqID" value="<?php echo $uniqID ?>">
        <label for="">Name</label>
        <input type="text" class="form-control" id="hallName" name="hallName">

        <label for="">Associated hall experience</label>

        <select class="form-select" aria-label="Default select example" name="experienceID" id="experienceID">
            <option selected disabled>Select hall experience</option>
            <?php foreach ($experiences as $experience) : ?>
                <option value="<?php echo $experience['uniqID'] ?>"><?php echo $experience['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for=""><i>For seatmap, this form will create a PHP file under /admin/halls/seatmap/<?php echo $uniqID ?>.php. Do note that you can edit using an HTML editor.</i></label>
        <button class="btn w-100 btn-success">Add</button>
    </form>
<?php } ?>