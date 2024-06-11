<?php
$title = 'Movie adding successful';
require_once '../../../elements/layout.php';
function get_content()
{
    $filmID = $_GET['id'];
?>
    <div class="container p-5 text-center">
        <h1 style="font-size: 5em"><i class="fa fa-check-circle" aria-hidden="true"></i></h1>
        <h1>Successfully added movie</h1>
        <h4>This movie is now available on the home page. To add showtimes and assign halls, click on the button below.</h4>
        <a href="/admin/showtimes/edit?id=<?php echo $filmID ?>" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add showtimes</a>
    </div>
<?php
}
?>