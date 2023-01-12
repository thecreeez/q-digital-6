<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tasklist');
define('DB_TABLE_VERSIONS', 'versions');

class Database {
    private static $connection = null;

    function __construct() {
        if (self::$connection != null) {
            throw new Exception('Создание второго подключения к базе данных.');
            exit();
        }

        self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!self::$connection) {
            throw new Exception('Не удалось подключиться к серверу базы данных.');
            exit();
        }
    }   

    public function getUserByLogin($login) {
        $sql = "SELECT * FROM `users` WHERE `users`.`login` = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('s', $login);

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }

    public function insertUser($login, $password) {
        $sql = "INSERT INTO `users` (`login`, `password`) VALUES (?, ?)";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('ss', $login, $password);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function close() {
        self::$connection->close();
    }

    public function getTasks($login) {
        $sql = "SELECT `tasks`.`id`, `tasks`.`description`, `tasks`.`status` FROM `tasks` WHERE `tasks`.`users_id` = (SELECT `users`.`id` FROM `users` WHERE `users`.`login` = ?)";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('s', $login);

        $stmt->execute();
        $result = $stmt->get_result();

        $out = array();
        while ($res = $result->fetch_assoc()) {
            array_push($out, $res);
        }

        return $out;
    }

    public function addTask($usersId, $description) {
        $sql = "INSERT INTO `tasks` (`users_id`, `description`) VALUES (?, ?)";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('is', $usersId, $description);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function changeTaskStatus($usersId, $taskId) {
        $sql = "UPDATE `tasks` SET `tasks`.`status` = `tasks`.`status` ^ 1 WHERE `tasks`.`users_id` = ? AND `tasks`.`id` = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('ii', $usersId, $taskId);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function removeTask($usersId, $taskId) {
        $sql = "DELETE FROM `tasks` WHERE `tasks`.`users_id` = ? AND `tasks`.`id` = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('ii', $usersId, $taskId);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function removeAllTasks($usersId) {
        $sql = "DELETE FROM `tasks` WHERE `tasks`.`users_id` = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('i', $usersId);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function readyAllTasks($usersId) {
        $sql = "UPDATE `tasks` SET `tasks`.`status` = 1 WHERE `tasks`.`users_id` = ? AND `tasks`.`status` = 0";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param('i', $usersId);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }
}