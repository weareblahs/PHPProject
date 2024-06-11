<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top exclude-from-print" data-toggle="affix">
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarsExample">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <?php if (isset($_COOKIE['userID'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/tickets"><i class="fa fa-ticket" aria-hidden="true"></i> My tickets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile"><i class="fa fa-user" aria-hidden="true"></i> Hi, <?php echo $_COOKIE['firstName'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/backend/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login"><i class="fa fa-sign-in" aria-hidden="true"></i> <b>Log in or Sign Up</b></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>