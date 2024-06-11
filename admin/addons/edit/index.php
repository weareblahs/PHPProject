<?php

$title = 'Edit experience';

require_once '../../../elements/layout.php';

function get_content()
{
    require_once '../../../backend/sql_init.php';
    $get_id = $_GET['id'];
    $id_query = "SELECT * FROM addon WHERE addonUniqID = '$get_id';";
    $addon = mysqli_fetch_all(mysqli_query($cn, $id_query), MYSQLI_ASSOC)[0];
?>

    <div class="center-div p-4">
        <h2>Edit addon</h2>
    </div>
    <div class="center-div-mw-50 p-4 container">
        <form method="POST" action="../../admin/admin_backend/update_addon.php" enctype="multipart/form-data">
            <input type="hidden" name="addonID" value="<?php echo $addon['addonUniqID'] ?>">
            <div class="mb-3">
                <label for="experienceName" class="form-label">Experience name</label>
                <input type="text" class="form-control" id="addonName" name="addonName" value="<?php echo $addon['addonName'] ?>">
                <br>
                <div class="row">
                    <div class="col-5"><label for="experienceName" class="form-label">Experience image / icon</label></div>
                    <div class="col-7"><label for="experienceName" class="form-label"><a href="<?php echo $addon['addonImage'] ?>">Click here to view currently set icon for this experience</a></label></div>
                </div>
                <input type="file" class="form-control" id="addonImage" name="addonImage">
                <br>
                <label for="experienceName" class="form-label">Addon description</label>
                <input type="textbox" class="form-control" id="addonDescription" name="addonDescription" value="<?php echo $addon['addonDescription'] ?>">
                <br>
                <label for="experienceName" class="form-label">Addon pricing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">RM</span>
                    </div>
                    <input type="number" class="form-control" id="addonPrice" name="addonPrice" value="<?php echo $addon['addonPrice'] ?>">
                </div>
                <input class="btn btn-success w-100" type="submit" id="submit" name="submit" value="Update">
            </div>
        </form>
    </div>
<?php
}
?>