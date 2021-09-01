<?php
    if (isset($_POST['user-remove'])) {
        try{
            include("./includes/dbconnect.inc.php");
            session_start();

            $user_id = $_POST['user-id'] == -1 ? $_SESSION['id'] : $_POST['user-id'];
            //getting current user info
            $stmt1 = $dbh->prepare("SELECT * FROM users WHERE id = :id");
            $stmt1->execute([':id' => $user_id]);
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);

            if ($user['is_admin'] == true || $user['id'] = $user_id) {
                $stmt2 = $dbh->prepare("SELECT * FROM users WHERE id = :user_id");
                $stmt2->execute([':user_id' => $user_id]);
                if ($u = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    
                    $stmt3 = $dbh->prepare("SELECT * FROM fpfti WHERE user_id = :user_id");
                    $stmt3->execute([':user_id' => $user_id]);
                    while ($fpfti = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                        $stmt4 = $dbh->prepare("DELETE FROM tags WHERE fpfti_id = :fpfti_id");
                        $stmt4->execute([':fpfti_id' => $fpfti['id']]);
                        $stmt5 = $dbh->prepare("DELETE FROM comments WHERE fpfti_id = :fpfti_id");
                        $stmt5->execute([':fpfti_id' => $fpfti['id']]);
                        $stmt6 = $dbh->prepare("DELETE FROM likes WHERE fpfti_id = :fpfti_id");
                        $stmt6->execute([':fpfti_id' => $fpfti['id']]);
                        unset($stmt4);
                        unset($stmt5);
                        unset($stmt6);
                    }
                    $stmt7 = $dbh->prepare("DELETE FROM fpfti WHERE user_id = :user_id");
                    $stmt7->execute([':user_id' => $user_id]);
                    $stmt8 = $dbh->prepare("DELETE FROM comments WHERE user_id = :user_id");
                    $stmt8->execute([':user_id' => $user_id]);
                    $stmt9 = $dbh->prepare("DELETE FROM likes WHERE user_id = :user_id");
                    $stmt9->execute([':user_id' => $user_id]);
                    $stmt10 = $dbh->prepare("DELETE FROM users WHERE id = :user_id");
                    $stmt10->execute([':user_id' => $user_id]);

                    if ($_SESSION['is_admin'] == true && $user_id !== $_SESSION['id']) {
                        header("Location: https://s113.labagh.pl/index.html?page=admin&mess=userdeleted");
                        exit();
                    } else {
                        session_destroy();
                        header("Location: https://s113.labagh.pl/index.html?page=main&mess=userdeleted");
                        exit();
                    }
                } else {
                    if ($_SESSION['is_admin'] == true) {
                        header("Location: https://s113.labagh.pl/index.html?page=admin&mess=nosuchuser");
                        exit();
                    } else {
                        header("Location: https://s113.labagh.pl/index.html?page=main&mess=nosuchuser");
                        exit();
                    }
                }
            }
        } catch(PDOException $e) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
            exit();
        }
    }