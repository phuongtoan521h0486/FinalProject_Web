<?php
    require_once('add_director_image.php');
    $personName = $_POST['new_director_name'] ?? '';
    $gender = $_POST['new_director_gender'] ?? '';
    $dateOfBirth = $_POST['new_director_dob'] ?? '';
    $nationality = $_POST['new_director_nationality'] ?? '';
    $bio = $_POST['new_director_bio'] ?? '';

    $test =  addDirector($personName, $gender, $dateOfBirth, $nationality, $bio);
    print_r($test);
    header('Location: add.php');
?>