/*
 Navicat Premium Data Transfer

 Source Server         : api
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : 81.70.16.87:3306
 Source Schema         : api

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 27/02/2021 12:53:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for weibo_resou
-- ----------------------------
DROP TABLE IF EXISTS `weibo_resou`;
CREATE TABLE `weibo_resou` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(100) NOT NULL COMMENT '推送服务器',
  `kw` varchar(50) NOT NULL COMMENT '关键字',
  `desc` varchar(50) NOT NULL COMMENT '热搜',
  `addTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
