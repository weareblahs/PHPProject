<?php

$title = "Welcome";

require_once '../elements/layout.php';

function get_content() {
    
?>

<div class="m-5 text-center">
    <h1 class="welcome-font-size">Welcome, <?php echo $_SESSION['welcomeMsg']['firstName']?></h1>
    <h4>Your account has been successfully registered.</h4>
    <a href="/login" class="text-center btn btn-success">Log in</a>
</div>
<?php
}
?>