<?php
    if (isset($_POST['fpfti-submit'])) {
        session_start();
        if (!isset($_SESSION['id']) || !isset($_SESSION['login'])) {
            header("Location: https://s113.labagh.pl/index.html?page=main&mess=notloggedin");
            exit();
        }

        if (!isset($_POST["title"]) || mb_strlen($_POST['title']) === 0) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=notitle");
            exit();
        }
        if(!isset($_FILES["fpfti-image"]) || $_FILES['fpfti-image']['error'] === 4) { //&& $_POST['g-recaptcha-response']) { //TODO
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=nofpfti");
            exit();
        }
        
        $ftpFile = $_FILES['fpfti-image'];
        $fileName = $ftpFile['name'];
        $fileTmpName = $ftpFile['tmp_name'];
        $fileSize = $ftpFile['size'];
        $fileError = $ftpFile['error'];
        $fileType = $ftpFile['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        if (!in_array($fileActualExt, $allowed)) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=wrongext");
            exit();
        }
        if (!($fileError === 0)) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
            exit();
        }
        if ($fileSize > 10_485_760) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=toobig");
            exit();
        }

        $fpfti_title = htmlspecialchars($_POST['title']);
        $fpfti_tags = htmlspecialchars($_POST['tags']);
        $fpfti_tags_array = explode(' ', $fpfti_tags);
        $fpfti_tags_array = array_unique($fpfti_tags_array, SORT_REGULAR);
        $keys = array_keys($fpfti_tags_array);

        if (mb_strlen($fpfti_tags) !== 0) {
            foreach($keys as $key) {
                if (mb_strlen($fpfti_tags_array[$key]) > 64) {
                    header("Location: https://s113.labagh.pl/index.html?page=profile&mess=tagtoolong");
                    exit();
                }
                if ($fpfti_tags_array[$key][0] !== '#' || mb_strlen($fpfti_tags_array[$key]) <= 1) {
                    header("Location: https://s113.labagh.pl/index.html?page=profile&mess=wrongtag");
                    exit();
                }
            }
        }

        $fileNameNew = uniqid('', true).".".$fileActualExt;
        $fileDestination = '../resources/fpfti/'.$fileNameNew;
        $fpfti_link = 'https://s113.labagh.pl/resources/fpfti/'.$fileNameNew;
        
        try {
            include('./includes/dbconnect.inc.php');

            $stmt = $dbh->prepare('INSERT INTO fpfti (title, user_id, link) VALUES (:title, :user_id, :link)');
            $stmt->execute([':title' => $fpfti_title, ':user_id' => $_SESSION['id'], ':link' => $fpfti_link]);
            
            if (mb_strlen($fpfti_tags) !== 0) {
                $stmt2 = $dbh->prepare('SELECT id FROM fpfti ORDER BY id DESC LIMIT 1');
                $stmt2->execute();
                $fpfti_id = $stmt2->fetch(PDO::FETCH_ASSOC);
                $query = 'INSERT INTO tags (tag, fpfti_id) VALUES ';
                $to_query = '';
                $to_execute = array();

                $ite = 0;
                foreach($fpfti_tags_array as $value) {
                    $to_query .= '(:tag' . $ite . ', :fpfti_id' . $ite . '), ';
                    $to_execute[':tag'.$ite] = $value;
                    $to_execute[':fpfti_id'.$ite] = $fpfti_id['id'];
                    $ite += 1;
                }

                $to_query = mb_substr($to_query, 0, -2);
                $query .= $to_query;
                $stmt3 = $dbh->prepare($query);
                $stmt3->execute($to_execute);
            }

            move_uploaded_file($fileTmpName, $fileDestination);
            
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=uploadsuccess");
        } catch (PDOException $e) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
        }
    }