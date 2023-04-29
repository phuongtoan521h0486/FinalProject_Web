<?php
    require_once("db_admin.php");
    
    $titleMovie = $_POST['title'];
    $releaseDate = $_POST['releaseDate'];
    $description = $_POST['description'];
    $runtime = $_POST['runtime'];

    $titleTrailer = $_POST['titleTrailer'];
    $urlTrailer = $_POST['urlTrailer'];

    $idStudio = $_POST['studio_names'][0];

    $ListIdActors = $_POST['actor_names'];

    $idDirector = $_POST['director_names'][0];

    $listIdGenres = $_POST['genre_names'];
    require_once("upload_movie_images.php");
    insertNewData($titleMovie,$releaseDate ,$description, $runtime, $titleTrailer, $urlTrailer, $idDirector, $idStudio, $ListIdActors, $listIdGenres);

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

    function insertNewData($titleMovie,$releaseDate ,$description, $runtime, $titleTrailer, $urlTrailer, $idDirector, $idStudio, $ListIdActors, $listIdGenres) {
        $idTrailer = addTrailer($titleTrailer, $urlTrailer)['idTrailer'];
        $idMovie = addMovie($titleMovie,$releaseDate ,$description, $runtime, $idDirector, $idStudio, $idTrailer)['idMovie'];

        foreach($ListIdActors as $idActor) {
            addAct($idMovie, $idActor);
        }
        foreach($listIdGenres as $idGenre) {
            addClassification($idMovie, $idGenre);
        }
        ?>
            <html lang="en">
                <head>
                    <title>Bootstrap Example</title>
                    <meta charset="utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1" />
                    <link
                    rel="stylesheet"
                    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
                    />
                    <link
                    rel="stylesheet"
                    href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
                    integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
                    crossorigin="anonymous"
                    />
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                </head>
                <body>
                    <div class="container">
                    <div class="row">
                        <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
                            <h4>Add movie success full</h4>
                            <p>You are being navigated to the Add data page</p>
                            <p>Click <a href="add.php">Here</a> to accessAdd data page <span id="counter" class="text-danger">10</span> second.</p>
                            <a href="add.php" class="btn btn-success px-5">Go</a>
                        </div>
                    </div>
                    </div>
                    <script>
                    window.addEventListener('load', startTheCountdown);

                    function startTheCountdown() {
                        let countdown = 10;
                        let counter = document.getElementById('counter');
                        let id = setInterval(() => { // arrow function
                        countdown--;
                        counter.innerHTML = countdown.toString();

                        if (countdown === 0) {
                            clearInterval(id);
                            window.location.href = "add.php"
                        }

                        }, 1000);

                    }
                    </script>
                </body>
                </html>
        
        <?php

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

    function addStudio($studioName, $location, $description) {
        $sql = "INSERT INTO studio VALUES(?, ?, ?, ?)";
        $conn = connect();
        $idStudio = generateId("S", "idStudio", "studio");
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssss',$idStudio, $studioName, $location, $description);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        return array('code' => 1, 'error' => 'Add Studio success', 'idStudio' => $idStudio);
    }

    function addTrailer($titleTrailer, $urlTrailer) {
        $sql = "INSERT INTO trailer VALUES(?, ?, ?)";
        $conn = connect();
        $idTrailer = generateId("T", "idTrailer", "trailer");
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss',$idTrailer, $titleTrailer, $urlTrailer);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        return array('code' => 1, 'error' => 'Add Trailer success', 'idTrailer' => $idTrailer);
    }

    function addGenre($genreName, $description) {
        $sql = "INSERT INTO genre VALUES(?, ?, ?)";
        $conn = connect();
        $idGenre = generateId("GEN", "idGenre", "genre");
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss',$idGenre, $genreName, $description);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        return array('code' => 1, 'error' => 'Add Genre success');
    }

    function addMovie($titleMovie,$releaseDate ,$description, $runtime, $idDirector, $idStudio, $idTrailer) {
        $sql = "INSERT INTO movie VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $conn = connect();
        $idMovie = generateId("M", "idMovie", "movie");
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssssss',$idMovie, $titleMovie,$releaseDate ,$description, $runtime, $idDirector, $idStudio, $idTrailer);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        return array('code' => 1, 'error' => 'Add movie success', 'idMovie' => $idMovie);
    }

    function addAct($idMovie, $idActor) {
        $sql = "INSERT INTO act VALUES(?, ?, ?)";
        $conn = connect();
        $idAct = generateId("MA", "idAct", "act");
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss',$idAct, $idMovie, $idActor);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        return array('code' => 1, 'error' => 'Add act success');
    }

    function addClassification($idMovie, $idGenre) {
        $sql = "INSERT INTO classification VALUES(?, ?, ?)";
        $conn = connect();
        $idClassification = generateId("C", "idClassification", "classification");
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss',$idClassification, $idMovie, $idGenre);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        return array('code' => 1, 'error' => 'Add Classification success');
    }
?>