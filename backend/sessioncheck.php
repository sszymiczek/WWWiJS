<?php
    session_start();
    if (isset($_SESSION['id']) && isset($_SESSION['login'])) {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === '1') {
            echo 2;
        } else {
            echo 1;
        }
    } else {
        echo 0;
    }