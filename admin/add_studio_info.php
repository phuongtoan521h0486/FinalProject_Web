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
?>