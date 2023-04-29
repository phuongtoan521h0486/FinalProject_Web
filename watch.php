<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

    $id = '';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }    
    require_once("getMovie.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleHome.css">
    <link rel="stylesheet" href="css/styleWatch.css">
    <title>GTV Prime</title>
    <style>
        .fa-heart-o {
            color: red;
            cursor: pointer;
            font-size: 50px;
        }

        .fa-heart {
            color: red;
            cursor: pointer;
            font-size: 50px;
        }
    </style>

</head>

<body>
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

        <div id="line" class="col-lg-4 first-item d-none" style="margin-top: 550px; margin-left: 200px">
        </div>
    </nav>

    <div class="container mt-5">
        <?php $info = getInfomation($id);
            $url = "videos/" . $info['titleMovie'] . ".mp4";
            $image = "images/background/" . $info['titleMovie'] . ".jpg";
        ?>
        <div class="row">
            <div class="col-lg-12 video-section mt-4" id="video-container">
                <video controls poster="<?=$image?>">
                    <source type="video/mp4" src="<?=$url?>">
                </video>

            </div>
        </div>

        <div class="video-info">
            <div class="row">
                <div class = "col-lg-8">
                    <h2><?=$info['titleMovie']?></h2>
                </div>  
                
                <div class = "col-lg-4">
                    <h2>Movie Details</h2>
                </div> 
            </div>

            <div class="row">
                <div class = "col-lg-8">
                    <p class="info">
                        <?= $info['description'] ?>
                    </p>
                </div>
                
                <div class="col-lg-4">
                    <div class="box">
                        <p>Director: <?=$info["personName"]?></p>
                        <p>Produced in: United States</p>
                        <p>Release date: <?=$info["releaseDate"]?></p>
                        <p>Genres: <?php
                            $genres = getGenre($id);
                            foreach($genres as $g) {
                                echo $g["genreName"] . " ";
                            }
                        ?></p>
                        <p>Studio: Marvel Studios</p>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-6 col-lg-12">
                    <h2 class="mb-3 mt-5" style="color: aliceblue;">Trailer</h2>

                </div>
            </div>    

            <div id="film" class="row">
                <div class="col-lg-5">
                        <iframe width="100%" height="300px"
                            src="<?= $info['urlTrailer'] ?>">
                        </iframe>
                </div>
            </div>

                
            <div class="row">
                <div class = "col-lg-8">
                    <h2>Actor</h2>
                    <div class="row">
                        <?php
                            $actor = getActor($id);
                            foreach($actor as $a) {
                                ?>
                                    <div class="col-md-4 col-sm-6 col-lg-3">
                                        <div class="cell">
                                            <img src="images/Portrait/<?= $a['personName'] ?>.jpg" class="portrait">
                                            <div class="actor-info">
                                                <p class="name"><?= $a['personName'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>

                    </div>
                </div>  

                <div class = "col-md-12 col-sm-6 col-lg-4">
                    <h2>Rating</h2>
                    <div class="row">
                        <div class="rating mb-5">
                            <input type="radio" name="rating" id="r1">
                            <label for="r1"></label>
                        
                            <input type="radio" name="rating" id="r2">
                            <label for="r2"></label>
                        
                            <input type="radio" name="rating" id="r3">
                            <label for="r3"></label>
                        
                            <input type="radio" name="rating" id="r4">
                            <label for="r4"></label>
                        
                            <input type="radio" name="rating" id="r5">
                            <label for="r5"></label>
                        
                        </div>
                    </div>
                    
                    
                    <div class="row mt-5">
                        <div class="col-lg-6">
                            <div class="favorite">
                                <span id = heart>
                                        <i class="fa fa-heart-o" aria-hidden="true" ></i>
                                        <p class="mx-3">Favorite</p>
                                </span>
                                
                            </div> 
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>

        <div class="row mt-5">
                <div class="col-md-12 col-sm-6 col-lg-3 mt-5">
                    <h2>Comment</h2>
                    <div class="comment-session">
                        <div class="comment-box">
                            <div class="user">
                                <div class="user-image"><i class="fa fa-user mr-2" style="color: #f3f4f7;"></i></div>
                                <div id="user" class="name"><?= $_SESSION['user']?></div>
                            </div>
                            <form onsubmit="return false">
                                <textarea name="comment" id="comment-area" cols="40" rows="1" placeholder="Your Message"></textarea>
                                <button onclick="postComment(`<?=$id?>`)" class="comment-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </form>
                        </div>

                        <div id="comment-result">
                            <?php
                                require_once("comment.php");
                                $comments = getComments($id);

                                foreach ($comments as $c) {
                                    if (!isset($comments['error'])) {
                                        $name = $c['username'];
                                        $text = $c['textComment'];
                                        $commentDate = $c['commentDate'];
                                        ?>
                                            <div class="post-comment">
                                                <div class="list">
                                                    <div class="user">
                                                        <div class="user-meta">
                                                            <div class="name"><?= $name ?></div>
                                                            <div class="day"><?= $commentDate ?></div>
                                                        </div>
                                                    </div>  
                                                    <div class="comment"><?=$text?></div>   
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>

                        
                    </div>
                </div> 
            </div>
        </div>
    </div>   
    <?= require_once("footer.php") ?>

</body>

<script>
    window.onscroll = function () {
            var head = document.getElementById("head");
            if (document.documentElement.scrollTop > 100 || document.body.scrollTop > 50) {
                head = document.getElementById("head");
                line = document.getElementById("line");
                head.style.position = "fixed";
                head.style.left=0;
                head.style.right=0;
                head.style.backgroundColor = "rgba(34,42,66,2)";
                head.style.zIndex = 10;
            }
            else {
                line.style.position = "relative";
                head.style.position = "absolute";
                head.style.backgroundColor = "rgba(34,42,66,0)";

            }

    }


    async function getCommentUsers(idMovie) {
        try {
            let res = await fetch("API/getComments.php?id=" + idMovie, {method:"GET"});
            return await res.json();
        } catch (error) {
            console.log(error);
        }
    }

    async function renderUsers(idMovie) {
        let comments = await getCommentUsers(idMovie);
        console.log(comments["message"]);
        if (comments.code != 0) {
            return null;
        }

        let html = '';
        comments['message'].forEach(comment => {
            let htmlSegment = `<div class="post-comment">
                                    <div class="list">
                                        <div class="user">
                                            <div class="user-meta">
                                                <div class="name">${comment.username}</div>
                                                <div class="day">${comment.commentDate}</div>
                                            </div>
                                        </div>  
                                        <div class="comment">${comment.textComment}</div>   
                                    </div>
                                </div>`;
            html += htmlSegment;
        });

        let commentSession = document.querySelector('#comment-result');

        commentSession.innerHTML = html;
        document.getElementById("comment-area").value = "";
    }

    async function postComment(idMovie) {

        const data = {"id": idMovie,"textComment": document.getElementById("comment-area").value, "username": document.getElementById("user").innerHTML};
        try {
            let res = await fetch("API/addComment.php", {method:"POST",body: JSON.stringify(data)});
            renderUsers(idMovie);  
        } catch (error) {
            console.log(error);
        }
        return false;
    }

    
    $("textarea").each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
    }).on("input", function () {
        this.style.height = 0;
        this.style.height = (this.scrollHeight) + "px";
    });

    $(document).ready(function () {
        $("#heart").click(function () {
            if ($("#heart").hasClass("liked")) {
            $("#heart").html('<i class="fa fa-heart-o" aria-hidden="true"></i><p class="mx-3">Favorite</p>');
            $("#heart").removeClass("liked");
            } else {
            $("#heart").html('<i class="fa fa-heart" aria-hidden="true"></i><p class="mx-3">Favorite</p>');
            $("#heart").addClass("liked");
            }
        });
    });
</script>
</html>