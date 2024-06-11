<?php
$seatmapFilename = $_GET['hallID'] . ".php";
require_once '../../admin/halls/seatmap/' . $seatmapFilename;
require_once '../../elements/layout_lite.php';
head();
require_once '../../backend/sql_init.php';
?>
<link rel="stylesheet" href="style.css">
<div class="w-50 container">
    <h1 style="text-align: center">Seatmap of <?php echo $_GET['hallID'] ?></h1>
    <?php getSeatmap() ?>
    <a href="../" class="btn btn-danger container w-100">Back to previous page</a>
</div>
<?php endofpage(); ?>