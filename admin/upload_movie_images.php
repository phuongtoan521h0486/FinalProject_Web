<?php
    addImages($titleMovie, "background", "fileupload_background");
    addImages($titleMovie, "poster", "fileupload_poster");
    addImages($titleMovie, "thumbnail", "fileupload_thumbnail");
function addImages($filename, $folder, $key) {
    

    if (!isset($_FILES[$key]))
    {
        die;
    }


    if ($_FILES[$key]['error'] != 0)
    {
        die;
    }


    $target_dir    = __DIR__ . "/images".'/' . $folder . '/' ;
    $target_dir = str_replace("\admin",'', $target_dir);
    $target_dir = str_replace('\\','/', $target_dir);
    $target_file   = $target_dir . basename($_FILES[$key]["name"]);

    $allowUpload   = true;

    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $maxfilesize   = 800000;

    $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES[$key]["tmp_name"]);
        if($check !== false)
        {
            $allowUpload = true;
        }
        else
        {
            $allowUpload = false;
        }
    }

    if (file_exists($target_file))
    {
        $allowUpload = false;
    }
    if ($_FILES[$key]["size"] > $maxfilesize)
    {
        $allowUpload = false;
    }

    if (!in_array($imageFileType,$allowtypes ))
    {
        $allowUpload = false;
    }


    if ($allowUpload)
    {
        move_uploaded_file($_FILES[$key]["tmp_name"], $target_file);
    }
    rename($target_file, $target_dir.$filename . "." .pathinfo($target_file, PATHINFO_EXTENSION));
}

?>