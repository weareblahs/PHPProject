<?php
$title = 'Profile';
require_once '../elements/layout.php';
function get_content()
{
    require_once '../backend/sql_init.php';
    $base = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM users"), MYSQLI_ASSOC)[0];
    $firstName = $base['firstName'];
    $lastName = $base['lastName'];
    $email = $base['email'];
?>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</h1>
                <h6>Modify your user profile here.</h6>
                <form action="/backend/changeUserProfile.php" method="POST">
                    <div class="row">
                        <div class="col-6"><label for="">First Name</label>
                            <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $firstName ?>">
                        </div>
                        <div class="col-6"><label for="">Last Name</label>
                            <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $lastName ?>">
                        </div>
                    </div>
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" class="form-control" name="email" id="email" value="<?php echo $email ?>">
                    <button type="submit" class="btn btn-success w-100 my-2">Update information</button>
                </form>
            </div>
            <div class="col-6">
                <h1><i class="fa fa-mouse-pointer" aria-hidden="true"></i> Quick links</h1>
                <a href="/tickets" class="btn btn-success w-100 text-center"><i class="fa fa-ticket" aria-hidden="true"></i> View booked tickets</a>
            </div>
        </div>
    </div>
<?php

}

?>