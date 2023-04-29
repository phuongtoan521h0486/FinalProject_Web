<?php
    session_start();
    
    $id = '';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>GTV Prime</title>
    <link rel="stylesheet" href="css/styleHome.css" />
    <script>
        window.onscroll = function () {
            var head = document.getElementById("head");
            var goToTop=document.getElementById("gototop");
            if (
                document.documentElement.scrollTop > 100 ||
                document.body.scrollTop > 100
            ) {
                head = document.getElementById("head");
                line = document.getElementById("line");
                
                head.style.position = "fixed";
                head.style.left = 0;
                head.style.right = 0;
                head.style.backgroundColor = "rgba(34,42,66,2)";
                head.style.zIndex = 10;
                goToTop.style.display="block";
                
                
                
            } else {
                line.style.position = "relative";
                head.style.position = "absolute";
                goToTop.style.display="none";
               
               
                head.style.backgroundColor = "rgba(34,42,66,0)";
               
            }
        };
        function myFunction() {
            window.location = "register.php";
        }
        function goToTop(){
            var timer=setInterval(function(){
                document.documentElement.scrollTop-=20;
                if(document.documentElement.scrollTop<=0)
                {
                    clearInterval(timer);
                }
            },5)

        }
    </script>
    <style>
        #ww {
            color: aliceblue;
        }
        .gototop{
            position: fixed;
            
            right: 20px;
            bottom: 20px;
    
        }
        div.gototop img{
            display: block;
            height: 70px; width: 70px
            
        }
    </style>
</head>

<body>
    <div class="gototop" id="gototop" >
        
        <img href="javascript:;" onclick="goToTop()" src="images/logo/iconbttop.png">
    </div>
    <nav id="head" class="navbar navbar-expand-xl fixed-top justify-content-between navbar-transparent"
        color-on-scroll="30">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php">
            <img style="width: 70px; height: 50px; padding-right: 20px" src="images/logo/GTVlogoOfficial.png" alt="" />
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
                    <a href="login.php" role="button" class="e8zpj0e1 default-ltr-cache-v9h1tk"
                        data-uia="header-login-link">Sign In</a>
                </li>
            </ul>
            <?php
                }
                else {
                    ?>
            <ul class="navbar-nav ml-auto">
                <a style="color: white; padding-right: 20px; padding-top: 5px">Hello @
                    <?php echo $_SESSION['user']?>
                </a>

                <li id="si" class="nav-item">
                    <a href="logout.php" role="button" class="e8zpj0e1 default-ltr-cache-v9h1tk"
                        data-uia="header-login-link">Log out</a>
                </li>
            </ul>
            <?php
                }
                
            ?>
        </div>
    </nav>
    <div>
        <div class="first-item" style="margin-top: 65px;">
            <div id="demo" class="carousel slide" data-ride="carousel" data-interval="2000">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1" class="active"></li>
                    <li data-target="#demo" data-slide-to="2" class="active"></li>
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-block w-100">
                            <img src="images/background/Doctor Strange in the Multiverse of Madness.jpg"
                                alt="Second slide" />
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-block w-100">
                            <img src="https://assets.glxplay.io/web/images/ChiChiEmEm2_1920x1080_S.max-1920x1080.jpg"
                                alt="First slide" />
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-block w-100">
                            <img src="https://assets.glxplay.io/web/images/RebornRich_1920x1080_S.max-1920x1080.jpg"
                                alt="Third slide" />
                        </div>
                    </div>
                    <div id="line" class="col-lg-4 first-item" style="margin-top: 550px; margin-left: 200px">
                        <h2 class="title-landing-page" style="color: aliceblue">
                            Let chill
                        </h2>
                        <button onclick="myFunction()" style="
                  background-color: white;
                  color: black;
                  border-radius: 10% 20px;
                " type="button" class="btn btn-primary">
                            Register Right Now
                        </button>
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <?= require_once("getMovie.php"); 
            $products = getProduct();?>

        <div class="row">
            <div class="col-md-4 col-sm-6 col-lg-3">
                <h3 class="mb-3" style="color: aliceblue">Trending now</h3>
            </div>
        </div>
        <div id="film" class="row">
            <?php
                foreach ($products as $p) {
                    $idMovie = $p['idMovie'];
                    $name = $p['titleMovie'];
                    $image = $name . ".jpg";
            ?>
                <div class="col-md-4 col-sm-6 col-lg-3">
                    <a href="watch.php?id=<?= $idMovie ?>">
                        <div class="card">
                            <img class="card-img-top"
                                src="images/thumbnail/<?= $image ?>"
                                alt="Card image" style="width: 234; height: 130px" />
                        </div>
                    </a>
                    
                </div>
            <?php
                }
            ?>
        </div>
        
    </div>
    <!---->

    <?= require_once("footer.php") ?>
</body>

</html>