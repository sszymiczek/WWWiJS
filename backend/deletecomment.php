<?php
    if (isset($_POST['comment-remove'])) {
        try{
            include("./includes/dbconnect.inc.php");
            session_start();

            //getting OP id
            $stmt2 = $dbh->prepare("SELECT user_id FROM comments WHERE id = :comment_id");
            $stmt2->execute([':comment_id' => $_POST['comment-id']]);
            $poster_id = $stmt2->fetch(PDO::FETCH_ASSOC);

            //getting current user info
            $stmt1 = $dbh->prepare("SELECT * FROM users WHERE id = :id");
            $stmt1->execute([':id' => $_SESSION['id']]);
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);

            $stmt2 = $dbh->prepare("SELECT * FROM comments WHERE id = :comment_id");
            $stmt2->execute([':comment_id' => $_POST['comment-id']]);
            if ($stmt2->fetch(PDO::FETCH_ASSOC)) {
                if ($user['id'] === $poster_id['user_id'] || $user['is_admin'] == true) {
                    
                    $delete_stmt = $dbh->prepare("DELETE FROM comments WHERE id = :id");
                    $delete_stmt->execute([':id' => $_POST['comment-id']]);

                    if ($_SESSION['is_admin'] == true) {
                        header("Location: https://s113.labagh.pl/index.html?page=admin&mess=commentdeleted");
                        exit();
                    } else {
                        header('Location: https://s113.labagh.pl/index.html?page=fpfti&id='.$_POST['fpfti-id']);
                        exit();
                    }
                } else {
                    header("Location: https://s113.labagh.pl/index.html?page=main&mess=accessdeny");
                    exit();
                }
            } else {
                if ($_SESSION['is_admin'] == true) {
                    header("Location: https://s113.labagh.pl/index.html?page=admin&mess=nosuchcomment");
                    exit();
                } else {
                    header('Location: https://s113.labagh.pl/index.html?page=fpfti&id='.$_POST['fpfti-id']);
                    exit();
                }
            }
                   
        } catch(PDOException $e) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
            exit();
        }
    }