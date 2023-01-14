<?php
require('Database.php');
session_start();

class Application {
    private static $db = null;

    public static function init() {
        self::$db = new Database();
    }

    public static function login($params) {
        $login = $params['login'];
        $password = $params['password'];

        $userFromDB = self::$db->getUserByLogin($login);

        if (!$userFromDB)
            return self::registerUser($login, password_hash($password, PASSWORD_BCRYPT));
        
        return self::loginUser($userFromDB, $password);
    }

    private static function registerUser($login, $password) {
        if (strlen($login) > 16) {
            echo "Имя слишком длинное (Максимум - 16 символом)";
            exit();
        }

        self::$db->insertUser($login, $password);
        $_SESSION['s_login']=$login;
        return true;
    }

    private static function loginUser($userFromDB, $password) {
        if (!password_verify($password, $userFromDB['password'])) {
            return false;
        }

        $_SESSION['s_login']=$userFromDB['login'];
        return true;
    }

    public static function getTasks() {
        $userFromDB = self::authUser();

        return self::$db->getTasks($userFromDB['login']);
    }

    public static function addTask($params) {
        $userFromDB = self::authUser();
        
        return self::$db->addTask($userFromDB['id'], $params['taskDescription']);
    }  
    
    public static function changeTaskStatus($taskId) {
        $userFromDB = self::authUser();

        return self::$db->changeTaskStatus($userFromDB['id'], $taskId);
    }

    public static function removeOneTask($taskId) {
        $userFromDB = self::authUser();

        return self::$db->removeTask($userFromDB['id'], $taskId);
    }

    public static function removeAllTasks() {
        $userFromDB = self::authUser();

        return self::$db->removeAllTasks($userFromDB['id']);
    }

    public static function readyAllTasks() {
        $userFromDB = self::authUser();

        return self::$db->readyAllTasks($userFromDB['id']);
    }

    private static function authUser() {
        if (!isset($_SESSION['s_login'])) {
            header("Location: /login.php");
            exit();
        }

        $userFromDB = self::$db->getUserByLogin($_SESSION['s_login']);

        if (!isset($userFromDB)) {
            header("Location: /login.php");
            exit();
        }

        return $userFromDB;
    }
}