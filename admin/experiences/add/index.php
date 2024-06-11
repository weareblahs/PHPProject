<?php

$title = '';
require_once '../../../elements/layout.php';

function get_content()
{
?>

    <div class="center-div p-4">
        <h2>Add experience</h2>
    </div>
    <div class="center-div-mw-50 p-4 container">
        <form method="POST" action="../../admin/admin_backend/add_experience.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="experienceName" class="form-label">Experience name</label>
                <input type="text" class="form-control" id="experienceName" name="experienceName">
                <br>
                <label for="experienceName" class="form-label">Experience image / icon</label>
                <input type="file" class="form-control" id="experienceImage" name="experienceImage">
                <br>
                <label for="experienceName" class="form-label">Experience description</label>
                <input type="textbox" class="form-control" id="experienceDescription" name="experienceDescription">
                <br>
                <label for="experienceName" class="form-label">Experience ticket pricing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">RM</span>
                    </div>
                    <input type="number" class="form-control" id="experiencePrice" name="experiencePrice">
                </div>
                <input class="btn btn-success w-100" type="submit" id="submit" name="submit" value="Add">
            </div>
        </form>
    </div>
<?php
}
?>