<?php

require_once '../../backend/sql_init.php';
$experience_name = $_POST['experienceName'];
$experience_image = $_FILES['experienceImage'];
$experience_description = $_POST['experienceDescription'];
$experience_pricing = $_POST['experiencePrice'];

//image properties
$path = '../../assets_public/images/experiences/';
$web_path = '/assets_public/images/experiences/';
$file_name = uniqid();
$target_filename = $path . $file_name . "." . pathinfo(basename($_FILES["experienceImage"]["name"]), PATHINFO_EXTENSION);
$web_target_filename = $web_path . $file_name . "." . pathinfo(basename($_FILES["experienceImage"]["name"]), PATHINFO_EXTENSION);
$experience_id = uniqid();

if (isset($_POST["submit"])) {
    $check = getimagesize($experience_image["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        echo "<br>";
        echo "Starting upload...";
        if (move_uploaded_file($_FILES["experienceImage"]["tmp_name"], $target_filename)) {
            echo "The file " . htmlspecialchars(basename($_FILES["experienceImage"]["name"])) . " has been uploaded.";
            // begin database query
            $add_experience_query = "INSERT INTO cinemaexperiences (uniqID, name, iconPath, description, ticketPrice) VALUES ('$experience_id', '$experience_name', '$web_target_filename', '$experience_description', $experience_pricing)";
            mysqli_query($cn, $add_experience_query);
            mysqli_close($cn);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "The file you uploaded is not an image";
        die();
    }
}
