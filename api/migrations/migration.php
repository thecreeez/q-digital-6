<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tasklist');
define('DB_TABLE_VERSIONS', 'versions');

/**
 * Создает подключение к базе данных.
 */
function connectDB() {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$connection) {
        throw new Exception('Не удалось подключиться к серверу базы данных.');
        exit();
    }

    $query = $connection->query('set names utf8');

    if (!$query) {
        throw new Exception('Не удалось выполнить тестовый запрос.');
        exit();
    }

    return $connection;
}

/**
 * Список актуальных, еще не выполненных миграций
 */
function getMigrationFiles($conn) {
    $sqlFolder = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
    $allFiles = glob($sqlFolder . '*.sql');

    $query = sprintf('SHOW TABLES FROM `%s` LIKE "%s"', DB_NAME, DB_TABLE_VERSIONS);
    $result = $conn->query($query);
    
    // Если нет таблицы
    $firstMigration = !$result->num_rows;

    if ($firstMigration) {
        return $allFiles;
    }

    $query = sprintf('SELECT `name` FROM `%s`', DB_TABLE_VERSIONS);
    $result = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

    $versionsFiles = array();
    foreach ($result as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }

    // Выдает значения которые есть только в одной из таблиц
    return array_diff($allFiles, $versionsFiles);
}

/**
 * Накатывает миграцию (По имени файла)
 */
function migrate($conn, $file) {
    $sqlFile = fopen($file, 'r');

    $query = fread($sqlFile, filesize($file));
    $conn->query($query);

    fclose($sqlFile);


    $baseName = basename($file);
    $query = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_VERSIONS, $baseName);
    $conn->query($query);
}

$conn = connectDB();
$files = getMigrationFiles($conn);

if (empty($files)) {
    echo 'Ваша база данных в актуальном состоянии...';
    $conn->close();
    exit();
}

echo 'Начинаем миграцию...<br><br>';

foreach ($files as $file) {
    migrate($conn, $file);
    echo basename($file).'<br>';
}

echo '<br>Миграция завершена.';
$conn->close();
exit();