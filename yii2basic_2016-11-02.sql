# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.29)
# Database: yii2basic
# Generation Time: 2016-11-02 13:49:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `code` char(2) NOT NULL,
  `name` char(52) NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;

INSERT INTO `country` (`code`, `name`, `population`)
VALUES
	('AU','Australia',18886000),
	('BR','Brazil',170115000),
	('CA','Canada',1147000),
	('CN','China',1277558000),
	('DE','Germany',82164700),
	('FR','France',59225700),
	('GB','United Kingdom',59623400),
	('IN','India',1013662000),
	('RU','Russia',146934000),
	('TW','中国台湾',123456789),
	('US','United States',278357000);

/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hs_admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_admin`;

CREATE TABLE `hs_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'auth_key',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码Hash',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '密码重置命牌',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '电子邮箱',
  `status` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '建立日期',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新日期',
  `last_login_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录地址',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_admin_login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_admin_login`;

CREATE TABLE `hs_admin_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `client_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆地址',
  `client_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆时间',
  `login_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登陆状态',
  PRIMARY KEY (`id`),
  KEY `fk_adminlogin_uid_admin_id` (`uid`),
  CONSTRAINT `fk_adminlogin_uid_admin_id` FOREIGN KEY (`uid`) REFERENCES `hs_admin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_category`;

CREATE TABLE `hs_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT NULL COMMENT '父栏目',
  `postion` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `hide` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `status` smallint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `fk_category_pid_category_id` (`pid`),
  CONSTRAINT `fk_category_pid_category_id` FOREIGN KEY (`pid`) REFERENCES `hs_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `hs_category` WRITE;
/*!40000 ALTER TABLE `hs_category` DISABLE KEYS */;

INSERT INTO `hs_category` (`id`, `pid`, `postion`, `title`, `hide`, `image`, `icon`, `status`)
VALUES
	(1,NULL,0,'PHP',0,'','',0);

/*!40000 ALTER TABLE `hs_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hs_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_comment`;

CREATE TABLE `hs_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '评论内容',
  `status` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '评论状态',
  `postid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `client_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ip',
  `client_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表时间',
  PRIMARY KEY (`id`),
  KEY `fk_comment_postid_post_id` (`postid`),
  KEY `fk_comment_uid_user_id` (`uid`),
  CONSTRAINT `fk_comment_postid_post_id` FOREIGN KEY (`postid`) REFERENCES `hs_post` (`id`),
  CONSTRAINT `fk_comment_uid_user_id` FOREIGN KEY (`uid`) REFERENCES `hs_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_log`;

CREATE TABLE `hs_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '日志级别',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '日志内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_login`;

CREATE TABLE `hs_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `client_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆地址',
  `client_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆时间',
  `login_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登陆状态',
  PRIMARY KEY (`id`),
  KEY `fk_login_uid_user_id` (`uid`),
  CONSTRAINT `fk_login_uid_user_id` FOREIGN KEY (`uid`) REFERENCES `hs_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_migration`;

CREATE TABLE `hs_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hs_migration` WRITE;
/*!40000 ALTER TABLE `hs_migration` DISABLE KEYS */;

INSERT INTO `hs_migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1477557803),
	('m161021_065427_create_tbl_hs_user',1477557812);

/*!40000 ALTER TABLE `hs_migration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hs_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_post`;

CREATE TABLE `hs_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `summary` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '摘要',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标签',
  `author_id` int(10) unsigned DEFAULT '0' COMMENT '作者',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '发表日期',
  `updated_id` int(10) unsigned DEFAULT '0' COMMENT '更新用户',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新日期',
  `status` smallint(1) DEFAULT '0' COMMENT '博文状态',
  `label_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_cid_category_id` (`category`),
  KEY `fk_post_authorid_admin_id` (`author_id`),
  KEY `fk_post_updatedId_admin_id` (`updated_id`),
  CONSTRAINT `fk_post_authorid_admin_id` FOREIGN KEY (`author_id`) REFERENCES `hs_admin` (`id`),
  CONSTRAINT `fk_post_cid_category_id` FOREIGN KEY (`category`) REFERENCES `hs_category` (`id`),
  CONSTRAINT `fk_post_updatedId_admin_id` FOREIGN KEY (`updated_id`) REFERENCES `hs_admin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_post_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_post_tags`;

CREATE TABLE `hs_post_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_tags_to_post` (`post_id`),
  KEY `fk_post_tags_to_tags` (`tag_id`),
  CONSTRAINT `fk_post_tags_to_post` FOREIGN KEY (`post_id`) REFERENCES `hs_post` (`id`),
  CONSTRAINT `fk_post_tags_to_tags` FOREIGN KEY (`tag_id`) REFERENCES `hs_tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_tags`;

CREATE TABLE `hs_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `post_num` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hs_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hs_user`;

CREATE TABLE `hs_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '电子邮箱',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'auth_key',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码Hash',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '密码重置命牌',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '注册日期',
  `updated_id` int(10) unsigned DEFAULT '0' COMMENT '更新用户，是admin表中的用户',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新日期',
  `last_login_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录地址',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` smallint(1) DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username_unique` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `hs_user` WRITE;
/*!40000 ALTER TABLE `hs_user` DISABLE KEYS */;

INSERT INTO `hs_user` (`id`, `username`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `created_at`, `updated_id`, `updated_at`, `last_login_ip`, `last_login_time`, `status`)
VALUES
	(1,'jsparrow','jsparrow@aliyun.com','','$2y$13$hbkZsQloo0o56z7HMMtiZ.3IRPKltLJTexgh.xpVGNXXp7Tt1ASbi',NULL,1478086967,0,1478086967,0,0,1);

/*!40000 ALTER TABLE `hs_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'jsparrow','pG7TRyTIXlEbcenpi34TzmMYS2zDsMTF','$2y$13$HtJqGRmc76KIRIwokii8AOQ1XZljXiuWCKUGFnH9vkTnfBpHtqgFu',NULL,'weixi@weixistyle.com',10,1462597929,1462597929);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
