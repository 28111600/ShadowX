SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(128) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(32) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `passwd` varchar(16) NOT NULL,
  `t` int(11) NOT NULL DEFAULT '0',
  `u` bigint(20) NOT NULL,
  `d` bigint(20) NOT NULL,
  `transfer_enable` bigint(20) NOT NULL,
  `port` int(11) NOT NULL,
  `max_speed` int(11) NOT NULL DEFAULT '0',
  `enable` tinyint(4) NOT NULL DEFAULT '1',
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `invite_num` int(8) NOT NULL,
  `ref_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`, `port`),
  INDEX `user_uid` (`uid`) USING BTREE,
  INDEX `user_port` (`port`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`user_name`, `email`, `pass`, `passwd`, `t`, `u`, `d`, `transfer_enable`, `port`, `max_speed`, `enable`, `reg_date`, `invite_num`, `ref_by`) VALUES
('xiaodong', 'xiaodong@abc.com', 'c5a4e7e6882845ea7bb4d9462868219b', 'ABCDEDG', 1427454468, 0, 0, 1024000, 5000, 0, 1, 1429758822, 0, 0);

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `node_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `port` int(11) NOT NULL,
  `t` int(11) NOT NULL DEFAULT 0,
  `u` bigint(20) NOT NULL,
  `d` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `log_t` (`t`) USING BTREE,
  INDEX `log_node_id_uid_t` (`node_id`, `uid`, `t`) USING BTREE,
  INDEX `log_node_id` (`node_id`) USING BTREE,
  INDEX `log_uid` (`uid`) USING BTREE,
  INDEX `log_uid_t` (`uid`, `t`) USING BTREE
) ENGINE = INNODB DEFAULT CHARSET=utf8;

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ss_user_admin`;
CREATE TABLE `ss_user_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ss_user_admin` (`id`, `uid`) VALUES
(1, 1);

SET NAMES utf8;
SET time_zone = '+08:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ss_reset_pwd`;
CREATE TABLE `ss_reset_pwd` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ss_node`;
CREATE TABLE `ss_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
	`node_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `server` varchar(128) NOT NULL,
  `method` varchar(64) NOT NULL,
  `info` varchar(128) NOT NULL,
  `loadavg` varchar(64) NOT NULL,
  `uptime` int(11) NOT NULL DEFAULT 0,
  `checktime` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ss_node` (`node_id`, `name`, `server`, `method`, `info`, `loadavg`, `uptime`, 'checktime') VALUES
(1, '第一个节点', 'node.url.io', 'aes-256-cfb', 'node描述', 0, '0.00,0.00,0.00', '0', '0');

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `ss_invite_code`;
CREATE TABLE `ss_invite_code` (
  `id` int(32) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `code` varchar(128) NOT NULL,
  `user` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
