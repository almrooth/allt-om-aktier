-- Ensure UTF8 on the database connection
SET NAMES utf8;

--
-- Table aoa_users
--
DROP TABLE IF EXISTS aoa_users;
CREATE TABLE `aoa_users` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `role` VARCHAR(20) NOT NULL,
    `username` VARCHAR(100) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `created` DATETIME,
    `updated` DATETIME,
    `deleted` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

select * from aoa_users;

--
-- Table aoa_comments
--
DROP TABLE IF EXISTS aoa_comments;
CREATE TABLE `aoa_comments` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `question_id` INTEGER,
    `answer_id` INTEGER,
    `user_id` INTEGER NOT NULL,
    `content` TEXT NOT NULL,
    `created` DATETIME,
    `updated` DATETIME,
    `deleted` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

select * from aoa_comments;

--
-- Table aoa_questions
--
DROP TABLE IF EXISTS aoa_questions;
CREATE TABLE `aoa_questions` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `user_id` INTEGER NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `created` DATETIME,
    `updated` DATETIME,
    `deleted` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table aoa_tags
--
DROP TABLE IF EXISTS aoa_tags;
CREATE TABLE `aoa_tags` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `tag` VARCHAR(255) NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table aoa_tags_questions
--
DROP TABLE IF EXISTS aoa_tags_questions;
CREATE TABLE `aoa_tags_questions` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `tag_id` INTEGER NOT NULL,
    `question_id` INTEGER NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


--
-- Table aoa_answers
--
DROP TABLE IF EXISTS aoa_answers;
CREATE TABLE `aoa_answers` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `question_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `content` TEXT NOT NULL,
    `created` DATETIME,
    `updated` DATETIME,
    `deleted` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


select u.id, u.username, count(temp.user_id) as activity from aoa_users as u
inner join (
select user_id from aoa_questions
union all
select user_id from aoa_answers
union all
select user_id from aoa_comments) as temp on u.id = temp.user_id
group by u.id;

select * from aoa_comments;
select * from aoa_answers;
select * from aoa_questions;
select * from aoa_users;
-- 
-- Default users
--
INSERT INTO `aoa_users` (`role`, `username`, `password`, `email`) VALUES
    ('admin', 'admin', '$2y$10$uZx4liCNftH1yDJYKnycu.TBOwQ6X09cdGgT53RX38baUYZTJRG56', 'admin@comment.com'),
    ('user', 'doe', '$2y$10$Q4Y6zom7KP1EiGcKjFg0K.pFfRsf5.XeTrarffeB.Ug89LanDFeXO', 'doe@comment.com');

--
-- Default comments
--
INSERT INTO `aoa_comments` (`user_id`, `content`) VALUES
    ('1', 'This is a comment by an admin, admin.'),
    ('2', 'This is a comment by a user, doe.');