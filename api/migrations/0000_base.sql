-- Таблица versions --
CREATE TABLE IF NOT EXISTS `versions` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `created_at` timestamp default CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)
engine = innodb
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;