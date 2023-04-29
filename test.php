<?php
    // require_once("getMovie.php");
    // require_once("comment.php");
    require_once("favorite.php");
    // $test = getProduct();
    $test = addFavorite("admin", "M004");

    print_r($test);
?>