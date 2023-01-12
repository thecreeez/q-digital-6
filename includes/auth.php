<?php 
    session_start();
    $tasks = array();

    $login = false;
    $loginButtonText = "Войти";

    if (isset($_SESSION['s_login'])) {
        require('api/Application.php');

        $loginButtonText = "Выйти";
        $login = $_SESSION['s_login'];
    }
?>