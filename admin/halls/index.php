<?php

$title = '';

require_once '../../elements/layout.php';

function get_content()
{
    require_once '../../backend/sql_init.php';
    $get_halls = "SELECT * FROM halls";
    $halls = mysqli_fetch_all(mysqli_query($cn, $get_halls), MYSQLI_ASSOC);
?>

    <div class="row p-4">
        <div class="col-6">
            <h4>Halls</h4>
        </div>
        <div class="col-6 text-end"><a href="/admin/halls/add" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add hall</a></div>
        <table class="table container">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hall name</th>
                    <th>Linked experience ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($halls as $hall) : ?>
                    <tr>
                        <td><?php echo $hall['hallUniqID'] ?></td>
                        <td><?php echo $hall['hallName'] ?></td>
                        <td><?php echo $hall['experienceID'] ?></td>
                        <td><a href="/admin/halls/edit?hallID=<?php echo $hall['hallUniqID'] ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            <a href="/admin/halls/seatmap/showSeatmap.php?hallID=<?php echo $hall['hallUniqID'] ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                            <a href="/admin/halls/delete.php?hallID=<?php echo $hall['hallUniqID'] ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>


<?php
}
?>