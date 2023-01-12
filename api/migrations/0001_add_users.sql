-- Таблица пользователей --
CREATE TABLE `users` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `login` varchar(16) NOT NULL UNIQUE,
    `password` varchar(60) NOT NULL,
    `created_at` timestamp default CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)
engine = innodb
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;