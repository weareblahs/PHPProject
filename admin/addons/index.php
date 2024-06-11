<?php

$title = '';

require_once '../../elements/layout.php';

function get_content()
{
    require_once '../../backend/sql_init.php';
    $get_addon = "SELECT * FROM addon";
    $addons = mysqli_fetch_all(mysqli_query($cn, $get_addon), MYSQLI_ASSOC);
?>

    <div class="row p-4">
        <div class="col-6">
            <h4>Addons</h4>
        </div>
        <div class="col-6 text-end"><a href="/admin/addons/add" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add addon</a></div>
        <?php foreach ($addons as $addon) : ?>
            <div class="card ms-2 me-2" style="width: 18rem;">
                <img src="<?php echo $addon['addonImage'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><b><?php echo $addon['addonName'] ?></b></h5>
                    <p class="card-text"><?php echo $addon['addonDescription'] ?></p>
                    <p><i>Pricing for this ticket has been set to <?php echo 'RM' . number_format($addon['addonPrice'], 2) ?></i></p>
                    <a href="/admin/addons/edit?id=<?php echo $addon['addonUniqID'] ?>" class="btn btn-primary" style="width: 49%;">Edit</a>
                    <a href="/admin/addons/delete_addon.php?id=<?php echo $addon['addonUniqID'] ?>" class="btn btn-danger" style="width: 49%;">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


<?php
}
?>