<?php
$title = '';
require_once '../../../elements/layout.php';

function get_content()
{
    require_once '../../../backend/sql_init.php';
    // parse films
    $get_films_query = "SELECT * FROM films";
    $films = mysqli_fetch_all(mysqli_query($cn, $get_films_query));
?>
    <div class="center-div p-4">
        <h1>All movies</h1>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Release date</th>
                    <th scope="col">Film rating</th>
                    <th scope="col">Added date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($films as $film) : ?>
                    <tr>
                        <td><?php echo $film[2] ?>
                            <?php if ($film[2] != 'none') : ?>
                                <br>
                                <i><?php echo $film[3] ?>
                                <?php endif; ?>
                                </i>
                        </td>
                        <td><?php echo $film[7] ?></td>
                        <td><img src="/assets_public/images/filmRatings/<?php echo $film[5] ?>.png" alt="" width="50px" height="50px"></td>
                        <td></td>
                        <td>
                            <?php if ($film[8] == 1) : ?>
                                <span class="badge text-bg-primary"> <i class="fa fa-ticket" aria-hidden="true"></i> Available for booking</span>
                                <br>
                            <?php else : ?>
                            <?php endif; ?>

                            <?php if ($film[9] == 1) : ?>
                                <span class="badge text-bg-primary"><i class="fa fa-star" aria-hidden="true"></i> Shown in home page</span>
                                <br>
                            <?php else : ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="btn btn-success" href="/filmDetails?id=<?php echo $film[0] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-danger" href="/admin/admin_backend/delete_film.php?id=<?php echo $film[0] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
}
?>