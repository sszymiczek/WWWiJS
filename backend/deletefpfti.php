<?php
    //TODO test if user can remove his fpfti

    if (isset($_POST['fpfti-remove'])) {
        try {
            include("./includes/dbconnect.inc.php");

            session_start();

            //getting OP id
            $stmt2 = $dbh->prepare('SELECT user_id, link FROM fpfti WHERE id = :fpfti_id');
            $stmt2->execute([':fpfti_id' => $_POST['fpfti-id']]);
            $fpfti_info = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (mb_strlen($fpfti_info['link']) === 0) {
                if ($_SESSION['is_admin'] == true) {
                header("Location: https://s113.labagh.pl/index.html?page=admin&mess=nofpftiremove");
                exit();
                } else {
                    header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
                    exit();
                }
            }

            //getting current user info
            $stmt1 = $dbh->prepare('SELECT id, is_admin FROM users WHERE id = :id');
            $stmt1->execute([':id' => $_SESSION['id']]);
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);

            if ($_SESSION['is_admin'] != true && $fpfti_info['user_id'] !== $user['id']) {
                header("Location: https://s113.labagh.pl/index.html?page=profile&mess=accessdeny");
                exit();
            }

            $file = explode('/', $fpfti_info['link']);
            $file_path = '../resources/fpfti/'.end($file);
            if (file_exists($fpfti_info['link'])) {
                header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
                exit();
            }
            if (unlink($file_path)) {
                //deleting fpfti's tags
                $delete_stmt = $dbh->prepare('DELETE FROM tags WHERE fpfti_id = :fpfti_id');
                $delete_stmt->execute([':fpfti_id' => $_POST['fpfti-id']]);
                //deleting fpfti's likes
                $delete_stmt1 = $dbh->prepare('DELETE FROM likes WHERE fpfti_id = :id');
                $delete_stmt1->execute([':id' => $_POST['fpfti-id']]);                
                //deleting fpfti's comments
                $delete_stmt2 = $dbh->prepare('DELETE FROM comments WHERE fpfti_id = :id');
                $delete_stmt2->execute([':id' => $_POST['fpfti-id']]);
                //deleting fpfti
                $delete_stmt3 = $dbh->prepare('DELETE FROM fpfti WHERE id = :id');
                $delete_stmt3->execute([':id' => $_POST['fpfti-id']]);

                if ($fpfti_info['user_id'] !== $user['id'] && $_SESSION['is_admin'] == true) {
                    header("Location: https://s113.labagh.pl/index.html?page=admin&mess=fpftideleted");
                    exit();
                }
                header("Location: https://s113.labagh.pl/index.html?page=profile&mess=fpftideleted");
                exit();
            } else {
                header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
                exit();
            }
        } catch (PDOException $e) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
            exit();
        }
    } 