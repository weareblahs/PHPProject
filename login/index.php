<?php
$title = "Login";
require_once '../elements/layout.php';
function get_content()
{
  require_once '../backend/sql_init.php';
?>
  <?php if (isset($_SESSION['register_bs_scheme'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['register_bs_scheme'] ?>" role="alert">
      <?php echo $_SESSION['register_bs_notice'] ?>
    </div>
  <?php endif; ?>
  <h1 class="register-size text-center">Welcome back</h1>
  <h3 class="text-center">In order to access all the features, including ticket booking,<br>please login below.</h3>
  <div class="d-flex justify-content-center">
    <div class="container w-50">
      <form method="POST" action="../backend/login.php">
        <div class="form-floating mb-3 ">
          <input type="text" class="form-control" id="username" name="username" placeholder="name@example.com">
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating mb-3 ">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
        <button class="btn btn-success w-100 my-3">Log in</button>
        <p class="text-center">Don't have an account? <a href="/login/register">Sign Up</a></p>
      </form>
    </div>
  </div>

<?php
}
?>