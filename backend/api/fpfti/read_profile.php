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
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();
    $result = $fpfti->read_profile($user_id);
    //get row count
    $num = $result->rowCount();

    //check if any fpfti
    if($num > 0) {
        //Post array
        $user = array();
        $user['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
                'id' => $id,
                'login' => $login,
                'name' => $name,
                'age' => $age,
                'is_admin' => $is_admin,
                'created' => $created

            );

            //Push to "data"
            array_push($user['data'], $user_item);
        }

        //Turn to JSON & output
        echo json_encode($user);
    } else {
        echo json_encode(
            array('message' => 'No user found')
        );
    }