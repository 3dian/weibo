/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : localhost:3306
 Source Schema         : api

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 14/02/2021 13:33:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for weibo_ta
-- ----------------------------
DROP TABLE IF EXISTS `weibo_ta`;
CREATE TABLE `weibo_ta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL COMMENT '用户ID',
  `name` varchar(50) NOT NULL COMMENT '名字',
  `location` varchar(50) DEFAULT NULL COMMENT '地点',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `avatar` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL DEFAULT '1' COMMENT '性别',
  `followers_count` int(11) NOT NULL DEFAULT '0' COMMENT '粉丝数',
  `friends_count` int(11) NOT NULL DEFAULT '0' COMMENT '关注数',
  `statuses_count` int(11) NOT NULL DEFAULT '0' COMMENT '微博数',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `vid` varchar(50) NOT NULL DEFAULT '0' COMMENT '微博ID',
  `add_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
