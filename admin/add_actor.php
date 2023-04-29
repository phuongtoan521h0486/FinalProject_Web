<?php
    require_once('add_actor_image.php');
    $personName = $_POST['new_actor_name'] ?? '';
    $gender = $_POST['new_actor_gender'] ?? '';
    $dateOfBirth = $_POST['new_actor_dob'] ?? '';
    $nationality = $_POST['new_actor_nationality'] ?? '';
    $bio = $_POST['new_actor_bio'] ?? '';

        
    $test =  addActor($personName, $gender, $dateOfBirth, $nationality, $bio);
    print_r($test);
    
    header('Location: add.php');
?>
