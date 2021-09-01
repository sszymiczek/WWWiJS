<?php
    if (isset($_POST['logoutbutton'])) {
        session_start();
        if (isset($_SESSION['id'])) {
            unset($_SESSION['id']);
        }
        session_destroy();
    }
    header("Location: https://s113.labagh.pl");
    exit();