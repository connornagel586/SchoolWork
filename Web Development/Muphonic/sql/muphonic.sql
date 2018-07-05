SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `User ID` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `topic_id` int(10) NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `topic_text` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `created_by` int(10) NOT NULL,
  `num_comments` int(100) NOT NULL,
  `time_created` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `Topic ID` (`topic_id`),
  CONSTRAINT `topicID_user` FOREIGN KEY (`created_by`) REFERENCES `user_info` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) NOT NULL,
  `posted_by` int(10) NOT NULL,
  `comment_text` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `time_posted` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  PRIMARY KEY (`comment_id`),
  CONSTRAINT `comment_user` FOREIGN KEY (`posted_by`) REFERENCES `user_info` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  KEY `Comment ID` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms`(
  `room_id` int(10) NOT NULL AUTO_INCREMENT,
  `room_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `room_desc` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `created_by` int(4) NOT NULL,
  `time_created` DATETIME NOT NULL,
  PRIMARY KEY (`room_id`),
  CONSTRAINT `room_user` FOREIGN KEY (`created_by`) REFERENCES `user_info` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  KEY `Room ID` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat`(
  `chat_id` int(10) NOT NULL AUTO_INCREMENT,
  `room_id` int(10) NOT NULL,
  `posted_by` int(4) NOT NULL,
  `time_posted` DATETIME NOT NULL,
  `message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`chat_id`),
  CONSTRAINT `chat_user` FOREIGN KEY (`posted_by`) REFERENCES `user_info` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `chat_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  KEY `Chat ID` (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
