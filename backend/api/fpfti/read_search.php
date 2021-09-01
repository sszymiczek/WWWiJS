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

    try {
    $page = isset($_GET['page']) ? $_GET['page'] : die();
    $fpfti_query = htmlspecialchars($_GET['query']);

    if (mb_strlen($fpfti_query) !== 0) {
            if (mb_strlen($fpfti_query) > 64) {
                echo json_encode(
                    array('message' => 'hashtag too long')
                );
            }

            if (is_numeric($fpfti_query[0])) {
                $result = $fpfti->read_search_by_user_id($page, $fpfti_query);
            } else if ($fpfti_query[0] !== '#') {
                $result = $fpfti->read_search_by_login($page, $fpfti_query);
            } else {
                $result = $fpfti->read_search_by_tag($page, $fpfti_query);
            }
            //get row count
            $num = $result->rowCount();

            //check if any fpfti
            if($num > 0) {
                //Post array
                $fpfti_arr = array();
                $fpfti_arr['data'] = array();

                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $fpfti_item = array(
                        'id' => $row['id'],
                        'title' => $row['title'],
                        'user_id' => $row['user_id'],
                        'link' => $row['link'],
                        'accepted' => $row['accepted'],
                        'likes' => $row['likes'],
                        'created' => $row['created']
                    );

                    //Push to "data"
                    array_push($fpfti_arr['data'], $fpfti_item);
                }
            }

        //Turn to JSON & output
        echo json_encode($fpfti_arr);
    } else {
        echo json_encode(
            array('message' => 'No tags found')
        );
    }
}catch (PDOException $e) {
    echo json_encode(
        array('error' => $e)
    );
}