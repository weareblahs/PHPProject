<?php
$title = '';
require_once '../../elements/layout.php';

function get_content()
{
    require_once '../../backend/sql_init.php';
    // get movies list
    $get_films = "SELECT * FROM films";
    $films = mysqli_fetch_all(mysqli_query($cn, $get_films), MYSQLI_ASSOC);
?>
    <div class="p-2 container">
        <h1>Select a movie</h1>
    </div>
    <table class="table container">
        <thead>
            <tr>
                <th>ID</th>
                <th>Movie name</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($films as $film) : ?>
                <tr>
                    <td style="margin-top: auto; margin-bottom: auto"><?php echo $film['filmID'] ?></td>
                    <td style="margin-top: auto; margin-bottom: auto"><?php echo $film['name'] ?></td>
                    <td>
                        <?php if ($film['associatedShowtimeID'] == "none") : ?>
                            <a href="/admin/showtimes/edit?id=<?php echo $film['filmID'] ?>" class="btn btn-outline-success" style="margin-top: auto; margin-bottom: auto"><i class="fa fa-plus" aria-hidden="true"></i> Add</a>
                        <?php else : ?>
                            <a href="/admin/showtimes/manage?id=<?php echo $film['filmID'] ?>" class="btn btn-outline-success" style="margin-top: auto; margin-bottom: auto"><i class="fa fa-cog" aria-hidden="true"></i> Manage</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
<?php
}
?>