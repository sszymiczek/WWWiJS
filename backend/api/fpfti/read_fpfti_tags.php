<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Fpfti.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate fpfti object
    $fpfti = new Fpfti($db);

    //query
    $fpfti_id = isset($_GET['fpfti_id']) ? $_GET['fpfti_id'] : die();
    $result = $fpfti->read_fpfti_tags($fpfti_id);
    //get row count
    $num = $result->rowCount();

    //check if any fpfti
    if($num > 0) {
        //Post array
        $tags_arr = array();
        $tags_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $tags_item = array(
                'tag' => $tag
            );

            //Push to "data"
            array_push($tags_arr['data'], $tags_item);
        }

        //Turn to JSON & output
        echo json_encode($tags_arr);
    } else {
        $tags_arr = array();
        $tags_arr['data'] = array();
        echo json_encode($tags_arr);
    }