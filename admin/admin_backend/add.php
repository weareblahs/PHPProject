<?php

// SQL Guidelines
// filmID = generated unique ID for movie
// experienceID = links to a unique ID for the experience
// name = movie name
// altName = name of movie in native language (for this example, english and malay movie names does not require
//           this to be available, so this is optional with the default value set to "none"). example:
//           "TWILIGHT OF THE WARRIORS: WALLED IN" (name) = "九龍城寨之圍城" (altName)
// logoPath = path to movie logo. will show this instead of the movie name when the value of this property is "none"
// filmGenre = genre of the movie shown
// releaseDate = movie release date
// isAvailable = Movie is available for booking
// isFeatured = Movie is shown in the "Featured" category of the homepage
// filmDescription = movie description (mediumtext)
// cast = used for casts of the movie itself (also known as "starring")
// director = the director of the movie
// imagePosterPath = path to movie poster
// artwork = path to vertical artwork shown at the home page and info page
// trailerURL = YouTube URL of the trailer (used as a button at the movie detail page)
// associatedShowtimeID = generated unique ID to link to another table called "showtimes" which stores the date and
//                        time this movie will be shown

require_once '../../backend/sql_init.php';

$filmID = $_POST['filmID'];
$name = $_POST['filmName'];
$altName = $_POST['altFilmName'];
$filmGenre = $_POST['filmGenre'];
$releaseDate = $_POST['releaseDate'];

$isAvailablePostResponse = $_POST['isAvailable'];
if (!is_null($isAvailablePostResponse)) {
    $isAvailable = 1;
} else {
    $isAvailable = "0";
}

$isFeaturedPostResponse = $_POST['isFeatured'];
if (!is_null($isFeaturedPostResponse)) {
    $isFeatured = "1";
} else {
    $isFeatured = "0";
}

$filmDescription = $_POST['filmDescription'];
$logoImage = $_FILES['logoImage'];
$posterImage = $_FILES['posterImage'];
$artworkImage = $_FILES['filmArtwork'];
$releaseDate = $_POST['releaseDate'];
$cast = $_POST['filmCast'];
$director = $_POST['filmDirector'];
$subtitles = $_POST['filmSubtitles'];
$trailerURL = $_POST['filmTrailerURL'];
$experienceID = $_POST['experienceID'];
$filmRating = $_POST['filmRating'];
$language = $_POST['filmLanguage'];
$runningTime = $_POST['runningTime'];


// image path
$path = '../../assets_public/images/movieID/' . $filmID . '/';
$web_path = '/assets_public/images/movieID/' . $filmID . '/';

// create image path
mkdir($path);
$poster_filename = $path . "poster" . "." . pathinfo(basename($posterImage["name"]), PATHINFO_EXTENSION);
$poster_web_filename = $web_path . "poster" . "." . pathinfo(basename($posterImage["name"]), PATHINFO_EXTENSION);
$artwork_filename = $path . "artwork" . "." . pathinfo(basename($artworkImage["name"]), PATHINFO_EXTENSION);
$artwork_web_filename = $web_path . "artwork" . "." . pathinfo(basename($artworkImage["name"]), PATHINFO_EXTENSION);
$logo_filename = $path . "logo" . ".png";
$logo_web_filename = $web_path . "logo" . ".png";

if (isset($_POST["submit"])) {
    if (!empty($_FILES["logoImage"]["name"])) {
        echo "logo exists";
        $logoAvailable = "1";
        move_uploaded_file($logoImage["tmp_name"], $logo_filename);
    } else {
        echo "no logo";
        $logoAvailable = "0";
    }
    $check = getimagesize($posterImage["tmp_name"]);
    $check = getimagesize($artworkImage["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        echo "<br>";
        echo "Starting upload...";
        // logo check + upload logo

        if (move_uploaded_file($posterImage["tmp_name"], $poster_filename) && move_uploaded_file($artworkImage["tmp_name"], $artwork_filename)) {
            echo "The files with ID " . $filmID . " has been uploaded.";
            // begin database query

            $add_film_query = "INSERT INTO films
            (
            filmID, experienceID, name, altName, 
            logoPath, filmRating, filmGenre, releaseDate, 
            isAvailable, isFeatured, filmDescription, cast, 
            director, imagePosterPath, artwork, trailerURL,
            associatedShowtimeID, subtitle, language, length, logoAvailable
            ) VALUES (
            '$filmID', '$experienceID', '$name', '$altName',
            '$logo_web_filename', '$filmRating', '$filmGenre', '$releaseDate',
            $isAvailable, $isFeatured, '$filmDescription', '$cast',
            '$director', '$poster_web_filename', '$artwork_web_filename', '$trailerURL',
            'none', '$subtitles', '$language', '$runningTime', '$logoAvailable'
            )";
            mysqli_query($cn, $add_film_query);
            mysqli_close($cn);
            header('Location: /admin/add/success?id=' . $filmID);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "The file you uploaded is not an image";
        die();
    }
}
