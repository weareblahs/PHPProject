<?php
$title = "Admin Dashboard";
require '../elements/layout.php';
function get_content()
{
    // check if admin
    require_once '../backend/sql_init.php';
    $userID = $_COOKIE['userID'];
    $isAdmin = mysqli_fetch_all(mysqli_query($cn, "SELECT isAdmin FROM users WHERE userUniqID = '$userID'"), MYSQLI_ASSOC)[0]['isAdmin'];

?>

    <?php if ($isAdmin == 0 || !isset($isAdmin)) : ?>
        <?php http_response_code(403); ?>
        <h1 class="text-center">This is an administrator-only page</h1>
        <h4 class="text-center">You are not allowed to access this page</h4>
        <h4><a href="/">Back to home page</a></h4>
    <?php else : ?>
        <div class="container">
            <h1 class="text-center">Administrator Dashboard</h1>
            <div class="row">
                <div class="col-2" style="display: flex; align-items: center; justify-content: center; background: #0000ff; color: #ffffff">
                    <div class="link-white">
                        <a href="/admin/validate">
                            <h1 class="text-center link-white"><i class="fa fa-ticket" aria-hidden="true"></i><br>Ticket Validation</h1>
                        </a>
                    </div>
                </div>
                <div class="col-2" style="display: flex; align-items: center; justify-content: center; background: #ff0000; color: #ffffff">
                    <div class="link-white">
                        <a href="/admin/cleanup">
                            <h1 class="text-center link-white"><i class="fa-solid fa-broom"></i><br>Cleanup</h1>
                        </a>
                    </div>
                </div>
                <div class="col-8" style="margin-top: auto; margin-bottom: auto">
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/add">
                            <h1>Add movie</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/experiences">
                            <h1>Manage experiences</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/view">
                            <h1>View currently showing movies</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/showtimes">
                            <h1>Add or change showtimes</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/halls">
                            <h1>Manage halls</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/masterview">
                            <h1>View issued tickets</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/addons">
                            <h1>Manage addons</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/admin/globalSettings">
                            <h1>Global settings</h1>
                        </a>
                    </div>
                    <div class="d-flex align-center justify-content-center mb-2 link-white" style="background: #0000ff; color: #ffffff">
                        <a href="/">
                            <h1>Go to live page</h1>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php

}

?>