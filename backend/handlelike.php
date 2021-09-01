<?php
    if (isset($_POST['like-button'])) {
        try {
            include('./includes/dbconnect.inc.php');
            session_start();

            $stmt = $dbh->prepare("SELECT * FROM likes WHERE user_id = :user_id AND fpfti_id = :fpfti_id");
            $stmt->execute([':user_id' => $_SESSION['id'], ':fpfti_id' => $_POST['fpfti-id']]);
            if ($like = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($like['is_positive'] == 0) {
                    $stmt2 = $dbh->prepare("UPDATE likes SET is_positive = 1 WHERE fpfti_id = :fpfti_id");
                    $stmt2->execute([':fpfti_id' => $_POST['fpfti-id']]);
                    $stmt3 = $dbh->prepare("UPDATE fpfti SET likes = likes + 2 WHERE id = :fpfti_id");
                    $stmt3->execute([':fpfti_id' => $_POST['fpfti-id']]);
                }
            } else {
                $stmt2 = $dbh->prepare("INSERT INTO likes (user_id, fpfti_id, is_positive) VALUES (:user_id, :fpfti_id, :is_positive)");
                $stmt2->execute([':user_id' => $_SESSION['id'], ':fpfti_id' => $_POST['fpfti-id'], ':is_positive' => 1]);
                $stmt3 = $dbh->prepare("UPDATE fpfti SET likes = likes + 1 WHERE id = :fpfti_id");
                $stmt3->execute([':fpfti_id' => $_POST['fpfti-id']]);
            }
            header('Location: '.$_POST['header'].'');
            exit();  
        } catch(PDOException $e) {
            echo $e;
            header("Location: https://s113.labagh.pl/index.html?page=main&mess=error");
            exit();
        }
    }