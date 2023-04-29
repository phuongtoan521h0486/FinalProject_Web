<?php
    require_once('add_studio_info.php');
    $studioName = $_POST['new_studio_name'] ?? '';
    $location = $_POST['new_director_gender'] ?? '';
    $description = $_POST['new_director_dob'] ?? '';

    $test =  addStudio($studioName, $location, $description);
    print_r($test);
    header('Location: add.php');
?>