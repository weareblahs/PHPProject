<?php
$title = '';
require_once '../../../elements/layout.php';

function get_content()
{
    require_once '../../../backend/sql_init.php';
    // parse films
    $get_films_query = "SELECT * FROM films";
    $films = mysqli_fetch_all(mysqli_query($cn, $get_films_query), MYSQLI_ASSOC);

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
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($films as $film) : ?>
                    <tr>
                        <td><?php echo $film['name'] ?>
                            <?php if ($film['name'] != 'none') : ?>
                                <br>
                                <i><?php echo $film['altName'] ?>
                                <?php endif; ?>
                                </i>
                        </td>
                        <td><?php echo $film['releaseDate'] ?></td>
                        <td><img src="/assets_public/images/filmRatings/<?php echo $film['filmRating'] ?>.png" alt="" width="50px" height="50px"></td>
                        <td>
                            <?php if ($film['isAvailable'] == 1) : ?>
                                <span class="badge text-bg-primary"> <i class="fa fa-ticket" aria-hidden="true"></i> Available for booking</span>
                                <br>
                            <?php else : ?>
                            <?php endif; ?>

                            <?php if ($film['isFeatured'] == 1) : ?>
                                <span class="badge text-bg-primary"><i class="fa fa-star" aria-hidden="true"></i> Shown in home page</span>
                                <br>
                            <?php else : ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeVisibility">
                                <i class="fa fa-exchange" aria-hidden="true"></i>
                            </button>
                            <div class="modal fade" id="changeVisibility" tabindex="-1" aria-labelledby="changeVisibility" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Change visibility of <?php echo $film['name'] ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/admin/admin_backend/changeVisibility.php" method="POST" class="form">
                                                <?php
                                                if ($film['isAvailable'] == 1) {
                                                    echo '<input type="checkbox" name="isAvailable" id="isAvailable" value="1" checked>';
                                                } else {
                                                    echo '<input type="checkbox" name="isAvailable" id="isAvailable" value="1">';
                                                }
                                                ?>
                                                <label for="isAvailable">Available for booking</label>
                                                <br>
                                                <i>(Make this movie available for booking and ticketing purposes)</i>


                                                <?php
                                                if ($film['isFeatured'] == 1) {
                                                    echo '<input type="checkbox" name="isFeatured" id="isFeatured" value="1" checked>';
                                                } else {
                                                    echo '<input type="checkbox" name="isFeatured" id="isFeatured" value="1">';
                                                }
                                                ?>
                                                <label for="isFeatured">Featured movie</label>
                                                <br>
                                                <i>(Display this movie at the "Featured" section (carousel) at the home page)</i>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="hidden" name="filmID" value="<?php echo $film['filmID'] ?>">
                                            <input type="submit" value="Save changes" class="btn btn-success">
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-success" href="/filmDetails?id=<?php echo $film['filmID'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-danger" href="/admin/admin_backend/delete_film.php?id=<?php echo $film['filmID'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
}
?>