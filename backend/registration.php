<?php	
    if (! isset($_POST['reg-button'])) {
        header('Location: https://s113.labagh.pl/index.html');
    }

    if (! isset($_POST['reg-login'], $_POST['reg-password'], $_POST['reg-repassword'])) { //&& $_POST['g-recaptcha-response']) {
        header('Location: https://s113.labagh.pl/index.html?page=main&mess=formnotfilled');
        exit();
    }
        
    if (strlen($_POST['reg-login']) <= 0 || strlen($_POST['reg-password']) <= 0) {
        header('Location: https://s113.labagh.pl/index.html?page=main&mess=tooshort');
            exit();
    }
    if ($_POST['reg-password'] !== $_POST['reg-repassword']) {
        header('Location: https://s113.labagh.pl/index.html?page=main&mess=passwordthesame');
        exit();
    }

    $register_login = htmlspecialchars($_POST['reg-login']);
    $register_password = password_hash(htmlspecialchars($_POST['reg-password']), PASSWORD_DEFAULT);
    try {
        include('./includes/dbconnect.inc.php');

        $stmt = $dbh->prepare('SELECT * FROM users WHERE login = :login');
        $stmt->execute([':login' => $register_login]);
        $check_login = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($register_login !== $check_login['login']){   
            $stmt = $dbh->prepare('INSERT INTO users (login, password) VALUES (:login, :password)');
            $stmt->execute([':login' => $register_login, ':password' => $register_password]);
            header('Location: https://s113.labagh.pl/index.html?page=main&mess=registrationsuccess');
            exit();
        } else {
            header('Location: https://s113.labagh.pl/index.html?page=main&mess=loginistaken');
            exit();
        }
    } catch (PDOException $e) {
        header('Location: https://s113.labagh.pl/index.html?page=main&mess=error');
        exit();
    } 