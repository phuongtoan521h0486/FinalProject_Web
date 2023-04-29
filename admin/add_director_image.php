<?php
require_once("db_admin.php");
function generateId($code, $idNew, $table) {
    $sql = "SELECT $idNew FROM $table ORDER BY $idNew DESC LIMIT 1";
    $conn = connect();

    $stm = $conn->prepare($sql);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }
    $result = $stm->get_result();
    if ($result->num_rows === 0) {
        return $code . "001";
    }
    else {
        $lastID = $result -> fetch_assoc();
        $lastID = $lastID[$idNew];
        $number = (int)substr($lastID, strlen($code)) + 1;
        $numberOfzeros = strlen($lastID) - strlen($code) - strlen(strval($number));
        
        for( $i = 0 ; $i< $numberOfzeros; ++$i) {
            $code = $code . "0";
        }
        return $code . $number;
    }
}
function addPerson($personName, $gender, $dateOfBirth, $nationality, $bio) {
    $sql = "INSERT INTO Person VALUES(?, ?, ?, ?, ?, ?)";
    $conn = connect();

    $stm = $conn->prepare($sql);
    $thisID = generateId("P", "idPerson", "person");
    $stm->bind_param('ssisss', $thisID, $personName, $gender, $dateOfBirth, $nationality, $bio);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    return array('code' => 1, 'error' => 'Add person success', 'idPerson' => $thisID);
}

function addActor($personName, $gender, $dateOfBirth, $nationality, $bio) {
    $idPerson = addPerson($personName, $gender, $dateOfBirth, $nationality, $bio)['idPerson'];
    $sql = "INSERT INTO actor VALUES(?, ?)";
    $conn = connect();
    $idActor = generateId("A", "idActor", "actor");
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $idActor, $idPerson);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    return array('code' => 1, 'error' => 'Add actor success');
}

function addDirector($personName, $gender, $dateOfBirth, $nationality, $bio) {
    $idPerson = addPerson($personName, $gender, $dateOfBirth, $nationality, $bio)['idPerson'];
    $sql = "INSERT INTO director VALUES(?, ?)";
    $conn = connect();
    $idDirector = generateId("D", "idDirector", "director");
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss',$idDirector , $idPerson);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    return array('code' => 1, 'error' => 'Add director success', '$idDirector' => $idDirector);
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST')
  {
      die;
  }

  if (!isset($_FILES["fileupload_director"]))
  {
      die;
  }

  if ($_FILES["fileupload_director"]['error'] != 0)
  {
    die;
  }


  $target_dir    = __DIR__ . "/images/portrait/";
  $target_dir = str_replace("\admin",'', $target_dir);
  $target_dir = str_replace('\\','/', $target_dir);
  $target_file   = $target_dir . basename($_FILES["fileupload_director"]["name"]);

  $allowUpload   = true;

  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  $maxfilesize   = 800000;

  $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');

  if(isset($_POST["submit_director"])) {
      $check = getimagesize($_FILES["fileupload_director"]["tmp_name"]);
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
  if ($_FILES["fileupload_director"]["size"] > $maxfilesize)
  {
      $allowUpload = false;
  }

  if (!in_array($imageFileType,$allowtypes ))
  {
      $allowUpload = false;
  }


  if ($allowUpload)
  {
      move_uploaded_file($_FILES["fileupload_director"]["tmp_name"], $target_file);
  }
  rename($target_file, $target_dir.$_POST['new_director_name'] . "." .pathinfo($target_file, PATHINFO_EXTENSION));
?>