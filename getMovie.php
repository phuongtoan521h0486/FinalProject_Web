<?php
    require_once("db.php");
    // require "Model.php";
    function connectDatabase() {
        return connect();
    }

    function getProduct() {
        $conn = connectDatabase();
        $result = $conn-> query("SELECT titleMovie, idMovie From movie LIMIT 10");

        for ($i=0; $i < $result -> num_rows; $i++) { 
            $product[] = $result -> fetch_assoc();
        }
        return $product;
    }

    function getInfomation($id) {
        $sql = "SELECT m.titleMovie, m.releaseDate, m.description, t.urlTrailer, p.personName From movie m 
                Join trailer t on t.idTrailer = m.idTrailer
                Join director d on m.idDirector = d.idDirector
                Join person p on d.idPerson = p.idPerson
                where m.idMovie = ?";
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
        $data = $result->fetch_assoc();
        

        return $data;
    }

    function getActor($id) {
        $sql = "SELECT p.personName From act a
                Join movie m on a.idMovie = m.idMovie
                Join Actor ac on ac.idActor = a.idActor
                Join person p on ac.idPerson = p.idPerson
                where m.idMovie = ?
                LIMIT 4";
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
            $data[] = $result -> fetch_assoc();
        }

        return $data;
    }

    function getGenre($id) {
        $sql = "SELECT g.genreName from classification c
                join movie m on c.idMovie = m.idMovie
                join genre g on c.idGenre = g.idGenre
                where m.idMovie = ?";
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
            $data[] = $result -> fetch_assoc();
        }

        return $data;
    }   
    
?>