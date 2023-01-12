<?php

require('Application.php');

function route($params) {
    Application::init();
    session_start();
    $args = explode(":", $params['requestType']);
    $type = $args[0];

    switch ($type) {
        case "LOGIN": Application::login($params); break;
        case "LOGOUT": Application::logout($params); break;
        case "ADD_TASK": Application::addTask($params); break;

        case "CHANGE_STATUS_ONE": Application::changeTaskStatus($args[1]); break;
        case "REMOVE_ONE": Application::removeOneTask($args[1]); break;

        case "REMOVE_ALL": Application::removeAllTasks(); break;
        case "READY_ALL": Application::readyAllTasks(); break;
    }

    Application::close();
    header("Location: /");
    exit();
}

route($_POST);