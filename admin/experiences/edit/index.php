<?php

$title = 'Edit experience';

require_once '../../../elements/layout.php';

function get_content()
{
    require_once '../../../backend/sql_init.php';
    $get_id = $_GET['id'];
    $id_query = "SELECT * FROM cinemaexperiences WHERE uniqID = '$get_id';";
    $experience_values = mysqli_fetch_all(mysqli_query($cn, $id_query));
?>

    <div class="center-div p-4">
        <h2>Edit experience</h2>
    </div>
    <div class="center-div-mw-50 p-4 container">
        <form method="POST" action="../../admin/admin_backend/update_experience.php" enctype="multipart/form-data">
            <input type="hidden" name="experienceID" value="<?php echo $experience_values[0][0] ?>">
            <div class="mb-3">
                <label for="experienceName" class="form-label">Experience name</label>
                <input type="text" class="form-control" id="experienceName" name="experienceName" value="<?php echo $experience_values[0][1] ?>">
                <br>
                <div class="row">
                    <div class="col-5"><label for="experienceName" class="form-label">Experience image / icon</label></div>
                    <div class="col-7"><label for="experienceName" class="form-label"><a href="<?php echo $experience_values[0][2] ?>">Click here to view currently set icon for this experience</a></label></div>
                </div>
                <input type="file" class="form-control" id="experienceImage" name="experienceImage">
                <br>
                <label for="experienceName" class="form-label">Experience description</label>
                <input type="textbox" class="form-control" id="experienceDescription" name="experienceDescription" value="<?php echo $experience_values[0][3] ?>">
                <br>
                <label for="experienceName" class="form-label">Experience ticket pricing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">RM</span>
                    </div>
                    <input type="number" class="form-control" id="experiencePrice" name="experiencePrice" value="<?php echo $experience_values[0][4] ?>">
                </div>
                <input class="btn btn-success w-100" type="submit" id="submit" name="submit" value="Update">
            </div>
        </form>
    </div>
<?php
}
?>