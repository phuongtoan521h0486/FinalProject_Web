<?php
     function connect() {
        $conn = new mysqli("localhost","root","","moviewebdatabase");
        if($conn->connect_error) {
            die('Connect error:'. $conn->connect_error);
        }
        return $conn;
    }
?>