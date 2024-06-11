<?php

require_once '../../backend/sql_init.php';
$experience_name = $_POST['experienceName'];
$experience_description = $_POST['experienceDescription'];
$experience_pricing = $_POST['experiencePrice'];
$experience_id = $_POST['experienceID'];
if (!file_exists($_FILES['experienceImage']['tmp_name']) || !is_uploaded_file($_FILES['experienceImage']['tmp_name'])) {
    $add_experience_query = "UPDATE cinemaexperiences SET name='$experience_name', description='$experience_description', ticketPrice='$experience_pricing' WHERE uniqID='$experience_id';";
    mysqli_query($cn, $add_experience_query);
    mysqli_close($cn);
    header('Location: /admin/experiences');
} else {
    //image properties
    $experience_image = $_FILES['experienceImage'];
    $path = '../../assets_public/images/experiences/';
    $web_path = '/assets_public/images/experiences/';
    $file_name = uniqid();
    $target_filename = $path . $file_name . "." . pathinfo(basename($_FILES["experienceImage"]["name"]), PATHINFO_EXTENSION);
    $web_target_filename = $web_path . $file_name . "." . pathinfo(basename($_FILES["experienceImage"]["name"]), PATHINFO_EXTENSION);

    if (isset($_POST["submit"])) {
        $check = getimagesize($experience_image["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            echo "<br>";
            echo "Starting upload...";
            if (move_uploaded_file($_FILES["experienceImage"]["tmp_name"], $target_filename)) {
                echo "The file " . htmlspecialchars(basename($_FILES["experienceImage"]["name"])) . " has been uploaded.";
                // begin database query
                $add_experience_query = "UPDATE cinemaexperiences SET name='$experience_name', iconPath='$experience_image', description='$experience_description', ticketPrice='$experience_pricing' WHERE uniqID='$experience_id';";
                mysqli_query($cn, $add_experience_query);
                mysqli_close($cn);
                header('Location: /admin/experiences');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "The file you uploaded is not an image";
            die();
        }
    }
}
