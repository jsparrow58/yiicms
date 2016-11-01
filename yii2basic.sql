/*
Navicat MySQL Data Transfer

Source Server         : yii2basic
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yii2basic

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-10-28 18:50:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `code` char(2) NOT NULL,
  `name` char(52) NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('AU', 'Australia', '18886000');
INSERT INTO `country` VALUES ('BR', 'Brazil', '170115000');
INSERT INTO `country` VALUES ('CA', 'Canada', '1147000');
INSERT INTO `country` VALUES ('CN', 'China', '1277558000');
INSERT INTO `country` VALUES ('DE', 'Germany', '82164700');
INSERT INTO `country` VALUES ('FR', 'France', '59225700');
INSERT INTO `country` VALUES ('GB', 'United Kingdom', '59623400');
INSERT INTO `country` VALUES ('IN', 'India', '1013662000');
INSERT INTO `country` VALUES ('RU', 'Russia', '146934000');
INSERT INTO `country` VALUES ('TW', '中国台湾', '123456789');
INSERT INTO `country` VALUES ('US', 'United States', '278357000');

-- ----------------------------
-- Table structure for `hs_admin`
-- ----------------------------
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

-- ----------------------------
-- Records of hs_admin
-- ----------------------------

-- ----------------------------
-- Table structure for `hs_admin_login`
-- ----------------------------
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

-- ----------------------------
-- Records of hs_admin_login
-- ----------------------------

-- ----------------------------
-- Table structure for `hs_category`
-- ----------------------------
DROP TABLE IF EXISTS `hs_category`;
CREATE TABLE `hs_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父栏目',
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

-- ----------------------------
-- Records of hs_category
-- ----------------------------

-- ----------------------------
-- Table structure for `hs_comment`
-- ----------------------------
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
  CONSTRAINT `fk_comment_uid_user_id` FOREIGN KEY (`uid`) REFERENCES `hs_user` (`id`),
  CONSTRAINT `fk_comment_postid_post_id` FOREIGN KEY (`postid`) REFERENCES `hs_post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hs_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `hs_log`
-- ----------------------------
DROP TABLE IF EXISTS `hs_log`;
CREATE TABLE `hs_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '日志级别',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '日志内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hs_log
-- ----------------------------

-- ----------------------------
-- Table structure for `hs_login`
-- ----------------------------
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

-- ----------------------------
-- Records of hs_login
-- ----------------------------

-- ----------------------------
-- Table structure for `hs_migration`
-- ----------------------------
DROP TABLE IF EXISTS `hs_migration`;
CREATE TABLE `hs_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hs_migration
-- ----------------------------
INSERT INTO `hs_migration` VALUES ('m000000_000000_base', '1477557803');
INSERT INTO `hs_migration` VALUES ('m161021_065427_create_tbl_hs_user', '1477557812');

-- ----------------------------
-- Table structure for `hs_post`
-- ----------------------------
DROP TABLE IF EXISTS `hs_post`;
CREATE TABLE `hs_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标签',
  `author_id` int(10) unsigned DEFAULT '0' COMMENT '作者',
  `created_at` int(10) unsigned DEFAULT '0' COMMENT '发表日期',
  `updated_id` int(10) unsigned DEFAULT '0' COMMENT '更新用户',
  `updated_at` int(10) unsigned DEFAULT '0' COMMENT '更新日期',
  `status` smallint(1) DEFAULT '0' COMMENT '博文状态',
  PRIMARY KEY (`id`),
  KEY `fk_post_cid_category_id` (`category`),
  KEY `fk_post_authorid_admin_id` (`author_id`),
  KEY `fk_post_updatedId_admin_id` (`updated_id`),
  CONSTRAINT `fk_post_updatedId_admin_id` FOREIGN KEY (`updated_id`) REFERENCES `hs_admin` (`id`),
  CONSTRAINT `fk_post_authorid_admin_id` FOREIGN KEY (`author_id`) REFERENCES `hs_admin` (`id`),
  CONSTRAINT `fk_post_cid_category_id` FOREIGN KEY (`category`) REFERENCES `hs_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hs_post
-- ----------------------------

-- ----------------------------
-- Table structure for `hs_user`
-- ----------------------------
DROP TABLE IF EXISTS `hs_user`;
CREATE TABLE `hs_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '电子邮箱',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
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
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hs_user
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'jsparrow', 'pG7TRyTIXlEbcenpi34TzmMYS2zDsMTF', '$2y$13$HtJqGRmc76KIRIwokii8AOQ1XZljXiuWCKUGFnH9vkTnfBpHtqgFu', null, 'weixi@weixistyle.com', '10', '1462597929', '1462597929');
