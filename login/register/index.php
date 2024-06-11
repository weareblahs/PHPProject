<?php
$title = "Register";
require_once '../../elements/layout.php';
function get_content() {
    require_once '../../backend/sql_init.php';

?>
  <?php
  // resets both register_bs_scheme and register_bs_notice
  ?>
    <?php if(isset($_SESSION['register_bs_scheme'])):?>
    <div class="alert alert-<?php echo $_SESSION['register_bs_scheme']?>" role="alert">
      <?php echo $_SESSION['register_bs_notice']?>
    </div>
    <?php endif;?>
    <h1 class="text-center register-size">Register</h1>
    <h3 class="text-center">If you have an account, login <a href="/login">here</a>.</h3>
    <div class="d-flex justify-content-center">
    <div class="container w-50">
    <form method="POST" action="../../backend/register.php">
    <div class="d-flex justify-content-center">
    <div class="form-floating mb-3" style="width: 50%; margin-right: 5%">
         <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name">
        <label for="floatingInput">First name</label>
        </div>
        <div class="form-floating mb-3" style="width: 50%;">
         <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name">
        <label for="floatingInput">Last name</label>
        </div>
    </div>
    <div class="form-floating mb-3 ">
         <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        <label for="floatingInput">Email</label>
        </div>
    <div class="form-floating mb-3 ">
         <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        <label for="floatingInput">Username</label>
        <small class="form-text text-muted">Username must has at least 8 characters.</small>
        </div>
        <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <label for="floatingPassword">Password</label>
          <small class="form-text text-muted">Password must has at least 8 characters.</small>
        </div>
        <div class="form-floating">
        <input type="password" class="form-control" id="password2" name="confirmpass" placeholder="Password">
          <label for="floatingPassword">Confirm Password</label>
        </div>
        <button class="btn btn-success w-100 my-3">Register Account</button>
    </form>
</div>
</div>
<?php

}

?>