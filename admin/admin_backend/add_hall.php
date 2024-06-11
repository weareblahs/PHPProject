<?php
require_once '../../backend/sql_init.php';


$uniqID = $_POST['uniqID'];
$hallName = $_POST['hallName'];
$experienceID = $_POST['experienceID'];

$seatmapDir = '../../admin/halls/seatmap/' . $uniqID . '.php';
$seatmapDir_web = '/admin/halls/seatmap/' . $uniqID . '.php';
$seatmapFile = fopen("$seatmapDir", "w") or die("Unable to open file!");
$txt = "<?php\nfunction get_seatmap_() {";
fwrite($seatmapFile, $txt);
fclose($seatmapFile);

$query = "INSERT INTO halls (hallUniqID, hallName, experienceID, seatmapDir) VALUES ('$uniqID', '$hallName', '$experienceID', '$seatmapDir_web')";
mysqli_query($cn, $query);
mysqli_close($cn);
header('Location: ' . $_SERVER['HTTP_REFERER']);
