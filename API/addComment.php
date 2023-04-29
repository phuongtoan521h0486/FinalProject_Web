<?php
    require_once("../comment.php");
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $data = array();
        $data['code'] = 2;
        $data['message'] = 'This method is not supported ' . $_SERVER['REQUEST_METHOD'];

        http_response_code(405);
        die(json_encode($data));
    }

    $data = json_decode(file_get_contents('php://input'));

    if (is_null($data)) {
        http_response_code(405);
        die(json_encode(array('code' => 3, 'message' => 'JSON is null')));
    }

    if (!property_exists($data, 'id') ||
        !property_exists($data, 'username') ||
        !property_exists($data, 'textComment')) {
        
        http_response_code(405);
        die(json_encode(array('code' => 4, 'message' => 'Please provide id, textComment and user')));

    }

    if (empty($data->id) ||
        empty($data->textComment) ||
        empty($data->username)) {
        
        http_response_code(405);
        die(json_encode(array('code' => 5, 'message' => 'Your provide id, textComment and user is empty')));
    }

    $result = addComment($data->textComment,$data->username, $data->id);
    if ($result) {
        die(json_encode(array('code' => 0, 'message' => 'add comment successfully')));
    } else {
        die(json_encode(array('code' => 1, 'message' => 'add comment fail')));
    }

?>