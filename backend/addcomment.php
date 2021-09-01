<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    if (isset($_POST['comment-add'])) {
        try {
            include('./includes/dbconnect.inc.php');
            session_start();

            //getting current user info
            $stmt1 = $dbh->prepare("SELECT * FROM users WHERE id = :id");
            $stmt1->execute([':id' => $_SESSION['id']]);
            $fpfti_id = $_POST['fpfti-id'];

            $stmt2 = $dbh->prepare("SELECT * FROM fpfti WHERE id = :id");
            $stmt2->execute([':id' => $fpfti_id]);

            if (empty($_POST['comment-text'])){
                header('Location: https://s113.labagh.pl/index.html?page=fpfti&id=' . $fpfti_id . '&mess=emptycomment');
                exit();
            }else if (!$stmt2->fetch(PDO::FETCH_ASSOC)) {
                header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
                exit();
            } else if ($user = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $stmt3 = $dbh->prepare('INSERT INTO comments (text, user_id, fpfti_id) VALUES (:text, :user_id, :fpfti_id)');
                $stmt3->execute([
                    ':text' => htmlspecialchars($_POST['comment-text']),
                    ':user_id' => $_SESSION['id'],
                    ':fpfti_id' => $fpfti_id
                ]);
                header('Location: https://s113.labagh.pl/index.html?page=fpfti&id=' . $fpfti_id . '&mess=commentadded');
                exit();
            } else {
                header('Location: https://s113.labagh.pl/index.html?page=fpfti&id=' . $fpfti_id . '&mess=notloggedin');
                exit();
            }
        } catch(PDOException $e) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
            exit();
        }
    }