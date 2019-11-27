-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2019 at 06:30 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

--
-- Dumping data for table `user`
--

-- role = enum('admin', 'reviewer', 'author')
-- access = enum(`ok`, `blocked`)
--
-- !! password for every user is "password" (in table is hash)

INSERT INTO `user` 
	(`id_user`, `username`, `first_name`, `last_name`, `role`, `last_login`, `access`, `password`) 
VALUES 
	-- admin
	(1, 'admin', NULL, NULL, 'admin', CURRENT_TIMESTAMP(), 'ok', '$2y$10$v0aahklWK4vM6ifWCf0RGuKJnwPxSr5fk8bDQrwnqOeEXnP/kt0uO'),

	-- reviewer
	(2, 'reviewer1', 'name', 'surname', 'reviewer', CURRENT_TIMESTAMP(), 'ok', '$2y$10$v0aahklWK4vM6ifWCf0RGuKJnwPxSr5fk8bDQrwnqOeEXnP/kt0uO'),
	(3, 'reviewer2', 'name', 'surname', 'reviewer', CURRENT_TIMESTAMP(), 'ok', '$2y$10$v0aahklWK4vM6ifWCf0RGuKJnwPxSr5fk8bDQrwnqOeEXnP/kt0uO'),
	(4, 'reviewer3', 'name', 'surname', 'reviewer', CURRENT_TIMESTAMP(), 'ok', '$2y$10$v0aahklWK4vM6ifWCf0RGuKJnwPxSr5fk8bDQrwnqOeEXnP/kt0uO'),
	(5, 'reviewer4', 'name', 'surname', 'reviewer', CURRENT_TIMESTAMP(), 'ok', '$2y$10$v0aahklWK4vM6ifWCf0RGuKJnwPxSr5fk8bDQrwnqOeEXnP/kt0uO'),

	-- publisher
	(6, 'author1', 'name', 'surname', 'author', CURRENT_TIMESTAMP(), 'ok', '$2y$10$v0aahklWK4vM6ifWCf0RGuKJnwPxSr5fk8bDQrwnqOeEXnP/kt0uO'),
	(7, 'author2', 'name', 'surname', 'author', CURRENT_TIMESTAMP(), 'ok', '$2y$10$v0aahklWK4vM6ifWCf0RGuKJnwPxSr5fk8bDQrwnqOeEXnP/kt0uO');

--
-- Dumping data for table `article`
--

-- status = enum('reviewing', 'published', 'refused')

INSERT INTO `article` 
	(`id_article`, `user_id_user`, `title`, `author`, `date`, `file`, `status`, `abstract`) 
VALUES 
	(1, 6, 'title1', 'author1', CURRENT_TIMESTAMP(), 'file1.pdf', 'reviewing', 'abstract1'),
	(2, 6, 'title2', 'author1', CURRENT_TIMESTAMP(), 'file2.pdf', 'reviewing', 'abstract2'),
	(3, 7, 'title3', 'author2', CURRENT_TIMESTAMP(), 'file3.pdf', 'reviewing', 'abstract3');

--
-- Dumping data for table `review`
--

-- originality, format, language = enum('unusable=0', 'poor=1', 'normal=2', 'great=3')

INSERT INTO `review` 
	(`id_review`, `user_id_user`, `article_id_article`, `originality`, `format`, `language`, `comment`) 
VALUES
	-- article 1
	(1, 2, 1, 'unusable', 'poor', 'normal', 'review comment 1 on article 1'),
	(2, 3, 1, 'poor', 'normal', 'great', 'review comment 2 on article 1'),
	(3, 4, 1, 'normal', 'great', 'unusable', 'review comment 3 on article 1'),

	-- article 2
	(4, 3, 2, 'unusable', 'poor', 'normal', 'review comment 1 on article 2'),
	(5, 4, 2, 'poor', 'normal', 'great', 'review comment 2 on article 2'),
	(6, 5, 2, 'normal', 'great', 'unusable', 'review comment 3 on article 2'),

	-- article 3
	(7, 2, 3, 'unusable', 'poor', 'normal', 'review comment 1 on article 3'),
	(8, 3, 3, 'poor', 'normal', 'great', 'review comment 2 on article 3'),
	(9, 5, 3, 'normal', 'great', 'unusable', 'review comment 3 on article 3');
