<?php
    ?>
    <nav id="head" class="navbar navbar-expand-xl fixed-top justify-content-between navbar-transparent"
        color-on-scroll="30">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php">
            <img style="width: 70px; height: 50px; padding-right:20px;"
            src="images/logo/GTVlogoOfficial.png"
            alt="">
        </a>
        

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Genre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">New Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Service</a>
                </li>
            </ul>
            <?php
                if (!isset($_SESSION['user'])) {
                    ?>
                        <ul class="navbar-nav ml-auto">
                        <li id="si" class="nav-item">
                            <a href="login.php" role="button" class=" e8zpj0e1 default-ltr-cache-v9h1tk" data-uia="header-login-link">Sign In</a>
                        </li>
                        </ul>
                    <?php
                }
                else {
                    ?>
                        <ul class="navbar-nav ml-auto">
                        <li id="si" class="nav-item">
                            <a href="logout.php" role="button" class=" e8zpj0e1 default-ltr-cache-v9h1tk" data-uia="header-login-link">Log out</a>
                        </li>
                        </ul>
                    <?php
                }
                
            ?>
        </div>
    </nav>
    <?php
?>