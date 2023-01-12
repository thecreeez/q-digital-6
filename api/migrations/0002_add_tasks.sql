-- Таблица задач --
CREATE TABLE `tasks` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `users_id` int(10) NOT NULL,
    `description` varchar(255) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `status` BIT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
)
engine = innodb
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;