<?php
$title = '';
require_once '../../elements/layout.php';
function get_content()
{
  require_once 'properties.php';

  // experience selector part
  require_once '../../backend/sql_init.php';
  $get_experience = "SELECT * FROM cinemaexperiences";
  $experiences = mysqli_fetch_all(mysqli_query($cn, $get_experience));
?>
  <div class="center-div p-4">
    <h1>Add movie</h1>
    <h4 class="text-center">Existing movies are available on the <a href="/admin/view/">"View movies" page</a>.</h4>
  </div>
  <div class="center-div-mw-50 p-4 container">
    <form method="POST" action="/admin/admin_backend/add.php" enctype="multipart/form-data">
      <div class="form-group w-100">
        <input type="hidden" name="filmID" id="filmID" value="<?php echo uniqid() ?>">
        <label for="">Movie name</label>
        <input type="text" class="form-control" id="filmName" name="filmName">
        <label for="">Alternative movie name (optional)</label>
        <input type="text" class="form-control" id="altFilmName" name="altFilmName">
        <div>
          <div class="col-6"><label for="filmGenre">Genre</label></div>
          <input type="text" class="form-control" id="filmGenre" name="filmGenre">
          <div class=""> <label for="">Rating</label>
            <br>
            <div class="d-flex justify-content-between"><?php foreach ($ratings as $rating) : ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="filmRating" name="filmRating" value="<?php echo $rating ?>">
                  <label class="form-check-label" for="filmRating"><?php echo $rating ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="row">
            <div class="col-8">
              <p>To select an experience, click the "Select Experience" button at the right.</p>
            </div>
            <div class="col-4">
              <div class="d-flex m-2">
                <a class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#experienceModal">Select experience</a>

                <!-- experience modal -->
                <div class="modal fade" id="experienceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select experience</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col"></th>
                              <th scope="col">Experience name</th>
                              <th scope="col">Experience description</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($experiences as $experience) : ?>
                              <tr>
                                <th scope="row"><input type="checkbox" name="experienceID" id="experienceID" value="<?php echo $experience[0] ?>"></th>
                                <td><?php echo $experience[1] ?></td>
                                <td><?php echo $experience[3] ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Done</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <label for="">Release date</label>
              <input id="releaseDate" class="form-control" type="date" name="releaseDate" />
              <div class="form-text">If the date is set to the future, do note that it will be automatically moved to "Coming Soon".</div>
            </div>
            <div class="col-6">
              <label for="">Display options</label>
              <br>
              <input class="form-check-input" type="checkbox" id="isFeatured" name="isAvailable" value="1">
              <label class="form-check-label" for="isAvailable">Available for booking</label>
              <br>
              <input class="form-check-input" type="checkbox" id="isFeatured" name="isFeatured" value="1">
              <label class="form-check-label" for="isFeatured">Featured movie</label>
              <div class="form-text">If ticked, this movie will be displayed on the homepage in the "Featured" category.</div>
            </div>

          </div>

          <label for="">Description</label>
          <textarea name="filmDescription" id="filmDescription" class="form-control" rows="6"></textarea>

          <div class="row">
            <div class="col-4"> <label for="">Spoken language</label>
              <input class="form-control" name="filmLanguage" id="filmLanguage" class="form-control">
            </div>
            <div class="col-4"> <label for="">Subtitles</label>
              <input class="form-control" name="filmSubtitles" id="filmSubtitles" class="form-control">
            </div>
            <div class="col-4"> <label for="">Running time</label>
              <div class="d-flex">
                <input type="number" name="runningTime" id="runningTime" class="form-control" style="width: 75%;">
                <span class="input-group-text" style="width: 25%;">min</span>
              </div>
            </div>
          </div>
          <!-- image uploads -->
          <label for="">Logo image (optional)</label>
          <input type="file" name="logoImage" id="logoImage" class="form-control" accept="image/png">
          <div class="row">
            <div class="col-6">
              <label for="">Poster image</label>
              <input type="file" name="posterImage" id="posterImage" class="form-control" accept="image/png, image/jpeg">
              <div class="form-text"></div>
            </div>
            <div class="col-6">
              <label for="">Artwork (optional)</label>
              <input type="file" name="filmArtwork" id="filmArtwork" class="form-control" accept="image/png, image/jpeg">
              <div class="form-text"></div>
            </div>
            <center>
              <div class="row d-flex">
                <div class="col-6">
                  <label for="">Cast</label>
                  <textarea name="filmCast" id="filmCast" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-6">
                  <label for="">Director</label>
                  <textarea name="filmDirector" id="filmDirector" class="form-control" rows="3"></textarea>
                </div>
              </div>
            </center>
          </div>
          <div class="col-6"><label for="filmGenre">Trailer URL</label></div>
          <input type="url" class="form-control" id="filmTrailerURL" name="filmTrailerURL">
        </div>
        <div>

        </div>
        <input class="btn btn-success w-100 mt-4" type="submit" id="submit" name="submit" value="Add">
      </div>
    </form>
  </div>
<?php
}
?>