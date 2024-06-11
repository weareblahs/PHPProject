<?php

$title = '';

require_once '../../elements/layout.php';

function get_content()
{
    require_once '../../backend/sql_init.php';
    $get_experience = "SELECT * FROM cinemaexperiences";
    $experiences = mysqli_fetch_all(mysqli_query($cn, $get_experience));
?>

    <div class="row p-4">
        <div class="col-6">
            <h4>Experiences</h4>
        </div>
        <div class="col-6 text-end"><a href="/admin/experiences/add" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add experience</a></div>
        <?php foreach ($experiences as $experience) : ?>
        <div class="card ms-2 me-2" style="width: 18rem;">
            <img src="<?php echo $experience[2]?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><b><?php echo $experience[1]?></b></h5>
                <p class="card-text"><?php echo $experience[3]?></p>
                <p><i>Pricing for this ticket has been set to <?php echo 'RM'.number_format( $experience[4], 2)?></i></p>
                <a href="/admin/experiences/edit?id=<?php echo $experience[0]?>" class="btn btn-primary" style="width: 49%;">Edit</a>
                <a href="/admin/admin_backend/delete_experience.php?id=<?php echo $experience[0]?>" class="btn btn-danger" style="width: 49%;">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>


<?php
}
?>