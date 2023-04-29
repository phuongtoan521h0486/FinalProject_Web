<?php
    require_once("db.php");
    // require "Model.php";

    function getComments($id) {

        $sql = "SELECT username, textComment, commentDate From comment where idMovie = ? ORDER BY `idComment` DESC";

        $conn = connect();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        $result = $stm->get_result();
        if ($result->num_rows === 0) {
            return array('code' => 1, 'error' => 'Movie does not exists');
        }

        for ($i=0; $i < $result -> num_rows; $i++) { 
            $comments[] = $result -> fetch_assoc();
        }
        return $comments;
    }

    function generateIdComment() {
        $sql = "SELECT `idComment` FROM comment ORDER BY `idComment` DESC LIMIT 1";
        $conn = connect();

        $stm = $conn->prepare($sql);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        $result = $stm->get_result();
        if ($result->num_rows === 0) {
            return "C001";
        }
        else {
            $lastID = $result -> fetch_assoc();
            $lastID = $lastID['idComment'];
            $number = (int)substr($lastID, 1, strlen($lastID)) + 1;
            $newID = "C";
            $numberOfzeros = strlen($lastID) - strlen($newID) - strlen(strval($number));
            
            for( $i = 0 ; $i< $numberOfzeros; ++$i) {
                $newID = $newID . "0";
            }
            return $newID . strval($number);
        }
    }

    function addComment($textComment, $username, $idMovie) {
        $sql = "INSERT INTO comment VALUES(?, ?, ?, ?, ?)";
        $conn = connect();

        $stm = $conn->prepare($sql);
        $stm->bind_param('sssss', generateIdComment(), $textComment, date("Y-m-d"), $username, $idMovie);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        
        return array('code' => 0, 'success' => 'Add comment success');
    }
?>