<?php
    if (isset($_POST['accept-button']) && $_POST['accept-button'] == 1) {
        try {
            include('./includes/dbconnect.inc.php');
            session_start();
            if ($_SESSION['is_admin'] == true) {
                $stmt = $dbh->prepare('UPDATE fpfti SET accepted = 1 WHERE id = :id');
                $stmt->execute([':id' => $_POST['fpfti-id']]);
                header("Location: https://s113.labagh.pl/index.html?page=admin");
            } else {
                header("Location: https://s113.labagh.pl/index.html?page=main");
            }
        } catch (PDOException $e) {
            header("Location: https://s113.labagh.pl/index.html?page=profile&mess=error");
        }
    }