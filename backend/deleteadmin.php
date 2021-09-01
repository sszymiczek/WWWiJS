<?php
    if (isset($_POST['admin-remove'])) {
        try {
            include('./includes/dbconnect.inc.php');
            session_start();

            //getting current user info
            $stmt1 = $dbh->prepare("SELECT * FROM users WHERE id = :id");
            $stmt1->execute([':id' => $_SESSION['id']]);
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);

            if ($user['is_admin'] == true) {
                $stmt2 = $dbh->prepare("SELECT * FROM users WHERE id = :user_id");
                $stmt2->execute([':user_id' => $_POST['user-id']]);
                if ($stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $stmt3 = $dbh->prepare("UPDATE users SET is_admin = 0 WHERE id = :user_id");
                    $stmt3->execute([':user_id' => $_POST['user-id']]);
                    header("Location: https://s113.labagh.pl/index.html?page=admin&mess=admindeleted");
                    exit();
                } else {
                    header("Location: https://s113.labagh.pl/index.html?page=admin&mess=nosuchuser");
                    exit();
                }
            }
        } catch(PDOException $e) {
            header("Location: https://s113.labagh.pl/index.html?page=admin&mess=error");
            exit();
        }
    }