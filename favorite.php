<?php
    require_once("db.php");
    // require "Model.php";

    function getFavoriteList($username) {

        $sql = "SELECT idMovie FROM favorite where username = ?";

        $conn = connect();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $username);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        $result = $stm->get_result();
        if ($result->num_rows === 0) {
            return array('code' => 1, 'error' => 'This user have not favorite list movie');
        }

        for ($i=0; $i < $result -> num_rows; $i++) { 
            $list[] = $result -> fetch_assoc();
        }
        return $list;
    }

    function generateIdFavorite() {
        $sql = "SELECT `idFavorite` FROM favorite ORDER BY `idFavorite` DESC LIMIT 1";
        $conn = connect();

        $stm = $conn->prepare($sql);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        $result = $stm->get_result();
        if ($result->num_rows === 0) {
            return "F001";
        }
        else {
            $lastID = $result -> fetch_assoc();
            $lastID = $lastID['idFavorite'];
            $number = (int)substr($lastID, 1, strlen($lastID)) + 1;
            $newID = "F";
            $numberOfzeros = strlen($lastID) - strlen($newID) - strlen(strval($number));
            
            for( $i = 0 ; $i< $numberOfzeros; ++$i) {
                $newID = $newID . "0";
            }
            return $newID . strval($number);
        }
    }

    function addFavorite($username, $idMovie) {
        if (!isAdded($username, $idMovie)) {
            $sql = "INSERT INTO favorite VALUES(?, ?, ?)";
        $conn = connect();

        $stm = $conn->prepare($sql);
        $stm->bind_param('sss', generateIdFavorite(), $username, $idMovie);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        
        return array('code' => 0, 'success' => 'Add movie to favorite list success');
        }      
    }

    function isAdded($username, $idMovie) {
        $sql = "SELECT * FROM favorite WHERE username = ? AND idMovie = ?";
        $conn = connect();

        $stm = $conn->prepare($sql);
        $stm->bind_param("ss", $username, $idMovie);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        $result = $stm->get_result();
        if ($result->num_rows >= 0) {
            return true;
        }
        return false;
    }
?>