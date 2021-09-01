<?php
    if (isset($_POST['settings-button'])) {
        if (isset($_POST['fname']) && isset($_POST['fpassword']) && isset($_POST['fpassword2']) && isset($_POST['age'])) {
            if (mb_strlen($_POST['fname']) > 0 && mb_strlen($_POST['fpassword']) > 0 && mb_strlen($_POST['fpassword2']) > 0 && mb_strlen($_POST['age']) > 0) {
                if ($_POST['fpassword'] !== $_POST['fpassword2']) {
                    header('Location: https://s113.labagh.pl/index.html?page=settings&mess=passwordthesame');
                    exit();
                }
                try {
                    include('./includes/dbconnect.inc.php');
                    session_start();
        
                    //getting current user info
                    $stmt1 = $dbh->prepare("SELECT id FROM users WHERE id = :id");
                    $stmt1->execute([':id' => $_SESSION['id']]);
                    $user = $stmt1->fetch(PDO::FETCH_ASSOC);
        
                    if ($user['id'] === $_SESSION['id']) {
                        $name = htmlspecialchars($_POST['fname']);
                        $password = password_hash(htmlspecialchars($_POST['fpassword']), PASSWORD_DEFAULT);
                        $age = htmlspecialchars($_POST['age']);
                        $stmt2 = $dbh->prepare("UPDATE users SET name = :name, password = :password, age = :age WHERE id = :id");
                        $stmt2->execute([':name' => $name, ':password' => $password, ':age' => $age, ':id' => $user['id']]);
                        header("Location: https://s113.labagh.pl/index.html?page=settings&mess=settingschanged");
                        exit();
                    } else {
                        header("Location: https://s113.labagh.pl/index.html?page=main&mess=accessdeny");
                        exit();
                    }
                } catch(PDOException $e) {
                    header("Location: https://s113.labagh.pl/index.html?page=settings&mess=error");
                    exit();
                }
            } else {
                header("Location: https://s113.labagh.pl/index.html?page=settings&mess=formnotfilled");
                exit();
            }
        } else {
            header("Location: https://s113.labagh.pl/index.html?page=settings&mess=formnotfilled");
            exit();
        }
    }