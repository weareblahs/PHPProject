<?php
$title = 'Add hall';
require_once '../../../elements/layout.php';

function get_content()
{
    require_once '../../../backend/sql_init.php';
    $hallID = $_GET['hallID'];
    $hallExperience_query = "SELECT * FROM halls WHERE hallUniqID = '$hallID'";
    $uniqID_pre = mysqli_fetch_all(mysqli_query($cn, $hallExperience_query), MYSQLI_ASSOC);
    $uniqID = $uniqID_pre[0]["hallUniqID"];

    // get experience
    $get_experience = "SELECT * FROM cinemaexperiences";
    $experiences = mysqli_fetch_all(mysqli_query($cn, $get_experience), MYSQLI_ASSOC);

    $selected_experience_query = "SELECT * FROM cinemaexperiences WHERE uniqID = '$uniqID'";
    $selected_experience = mysqli_fetch_all(mysqli_query($cn, $selected_experience_query), MYSQLI_ASSOC);

?>
    <div class="container p-2 w-50" class="align-content: center;">
        <center>
            <h1 class="">Edit hall</h1>
        </center>
    </div>
    <form action="/admin/admin_backend/update_hall.php" method="POST" class="form-group container w-50">
        <input type="hidden" name="uniqID" id="uniqID" value="<?php echo $uniqID ?>">
        <label for="">Name</label>
        <input type="text" class="form-control" id="hallName" name="hallName" value="<?php echo $uniqID_pre[0]["hallName"] ?>">

        <label for="">Associated hall experience</label>

        <select class="form-select" aria-label="Default select example" name="experienceID" id="experienceID">
            <option disabled>Select hall experience</option>
            <?php foreach ($experiences as $experience) : ?>
                <?php if ($experience['uniqID'] == $selected_experience['uniqID']) : ?>
                    <option value="<?php echo $experience['uniqID'] ?>" selected><?php echo $experience['name'] ?></option>
                <?php else : ?>
                    <option value="<?php echo $experience['uniqID'] ?>"><?php echo $experience['name'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for=""><i>For seatmap, this form will create a PHP file under /admin/halls/seatmap/<?php echo $hallID ?>.php. Do note that you can edit using an HTML editor.</i></label>
        <button class="btn w-100 btn-success">Update</button>
    </form>
<?php } ?>