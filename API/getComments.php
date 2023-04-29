<?php
    require_once("../comment.php");
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        $data = array();
        $data['code'] = 2;
        $data['message'] = 'This method is not supported ' . $_SERVER['REQUEST_METHOD'];

        http_response_code(405);
        die(json_encode($data));
    }

    $result = getComments($_GET['id']);
    if ($result) {
        die(json_encode(array('code' => 0, 'message' => $result)));
    } else {
        die(json_encode(array('code' => 1, 'message' => 'get comment fail')));
    }
?>