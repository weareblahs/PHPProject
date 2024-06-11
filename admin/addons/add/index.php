<?php

$title = '';
require_once '../../../elements/layout.php';

function get_content()
{
?>

    <div class="center-div p-4">
        <h2>Add addon</h2>
    </div>
    <div class="center-div-mw-50 p-4 container">
        <form method="POST" action="../../admin/admin_backend/add_addon.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="addonName" class="form-label">Addon name</label>
                <input type="text" class="form-control" id="addonName" name="addonName">
                <br>
                <label for="addonName" class="form-label">Addon image / icon</label>
                <input type="file" class="form-control" id="addonImage" name="addonImage">
                <br>
                <label for="addonName" class="form-label">Addon description</label>
                <input type="textbox" class="form-control" id="addonDescription" name="addonDescription">
                <br>
                <label for="addonName" class="form-label">Addon pricing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">RM</span>
                    </div>
                    <input type="number" class="form-control" id="addonPrice" name="addonPrice">
                </div>
                <input class="btn btn-success w-100" type="submit" id="submit" name="submit" value="Add">
            </div>
        </form>
    </div>
<?php
}
?>