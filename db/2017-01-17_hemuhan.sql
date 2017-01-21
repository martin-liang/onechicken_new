ALTER TABLE `onechicken`.`chicken` ADD COLUMN `no_get_eggs` int DEFAULT 0 COMMENT '未拾取的蛋的数量' AFTER `create_at`;
ALTER TABLE `onechicken`.`soil` DROP COLUMN `name`, CHANGE COLUMN `henroost_a` `henroost_a` tinyint(4) DEFAULT NULL COMMENT '鸡窝A是否有鸡在住', CHANGE COLUMN `henroost_b` `henroost_b` tinyint(4) DEFAULT NULL COMMENT '鸡窝b中是否有鸡在住';

drop table `user_addition`;
CREATE TABLE `user_addition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '所属用户',
  `money` decimal(10,2) DEFAULT NULL,
  `recommand` int(11) DEFAULT NULL COMMENT '推荐人',
  `eggs` int(11) DEFAULT NULL COMMENT '蛋的数量',
  `chickens` int(11) DEFAULT NULL COMMENT '鸡的数量',
  `soils` int(11) DEFAULT NULL COMMENT '土地的数量',
  `today_eggs` int(11) DEFAULT '0' COMMENT '今天获取蛋的数量',
  `recommand_code` varchar(255) DEFAULT NULL COMMENT '推荐代码',
  `recommand_eggs` int(11) DEFAULT '0' COMMENT '昨天从推荐用户处获取的蛋的数量',
  `recommand_total_eggs` int(11) DEFAULT NULL COMMENT '用户从推荐用户处获取蛋的总数量',
  `total_eggs` int(11) DEFAULT NULL COMMENT '用户总的蛋数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='用户附加信息表，重要信息都放在此表中'





/**
于洋的SQL
 */



/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-01-17 23:59:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', 'admin@admin.com', '5416d7cd6ef195a0f7622a9c56b55e84');

-- ----------------------------
-- Table structure for `chicken_wechat_token`
-- ----------------------------
DROP TABLE IF EXISTS `chicken_wechat_token`;
CREATE TABLE `chicken_wechat_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` text CHARACTER SET latin1 NOT NULL,
  `signature` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '微信 signature',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `valid_time` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chicken_wechat_token
-- ----------------------------
INSERT INTO `chicken_wechat_token` VALUES ('1', 'laZBjDiw24QyNs56ZZhFv67s21F4fQwGOl_ZAiIE7VcH01LbO5LxLAykoT5MbVyTyB3LgdEI9KH510GTgSWlT0HKqBgyNnCGf1oa5FyWc_Ys0GtaJZ1FN1a8zLaRmen0URChCCAMJU', 'ef70fc06a45dbcb272bbd242dfcc1ca71404caea', '1484190644', '1484197744');
INSERT INTO `chicken_wechat_token` VALUES ('2', 'xuWyraAbjy80f13b35kHDE3iqczVuSsHjV8REbjNEV3rQv4kYGujSand4FIq3QTjeRTuxUnqiUDRDrZMaQchULkG4suLGPOwXgudk2SWCI0KOZkCCAAEP', '5908b0ae3c8aa48f52162842688e2296d65ba055', '1484284119', '1484291219');
INSERT INTO `chicken_wechat_token` VALUES ('3', 'YHsSZUBc-E1mEqow4uO-HzzQvSn1hoQ2k0rP_-BeZ0L0n1YnW0CNvNal4ZwyWRsHkjwWmzSuH1aTkQg9Y2-hH2i0G320K6FVDQVPleipTbaoXa-7ILv8mvAzRpambJx7EVLcCJALCS', '8a3abc362a8173fa1f225c838243be8b48d21c46', '1484302101', '1484309201');
INSERT INTO `chicken_wechat_token` VALUES ('4', '111', '111', '0', '0');
INSERT INTO `chicken_wechat_token` VALUES ('5', '222', '222', '0', '0');
INSERT INTO `chicken_wechat_token` VALUES ('6', 'hJWEbXh2CdDpQ4icJH-3fgJd-Zdqih2u9IaaQWs4jZB_ESaZoO-JMZrl-SvNAi4GO1Ffkc8c2MiBy_nYkWuEvMcXq02qIei39KnrhrddqaMPjwArYtT_vDm7NJv7OQhIPPYcCIASSB', 'f379e491256cf7f19be3a29385ce12a5993c22cc', '1484545923', '1484553023');
INSERT INTO `chicken_wechat_token` VALUES ('7', 'cvxMtnmTCcE8Wvdy4C1Pg3kgMD_nr63R_e1lpDyK3q1SyzxlSUeBYsxsoDTFqIwdKd5DUJLnc6pKZMQnqOJV1kuFSCFRjUYUfsIyiLl6079ISg8sXqr3GMPl9Emdi1RzKEQjCJAVPB', 'e95cf652b670ba344fefc2c812e0c7b078921c5e', '1484655852', '1484662952');

-- ----------------------------
-- Table structure for `chicken_wechat_user`
-- ----------------------------
DROP TABLE IF EXISTS `chicken_wechat_user`;
CREATE TABLE `chicken_wechat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wechat_id` varchar(255) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `headimgurl` text,
  `nickname` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT '1' COMMENT '1 男 2女',
  `recommand_code` varchar(255) NOT NULL DEFAULT '' COMMENT '推荐链接',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人用户id',
  `parent_code` varchar(255) NOT NULL DEFAULT '' COMMENT '推荐人的邀请码',
  PRIMARY KEY (`id`),
  KEY `i1` (`wechat_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chicken_wechat_user
-- ----------------------------
INSERT INTO `chicken_wechat_user` VALUES ('1', '1', '1', '1', '1', '1', '1', '1', '111111', '0', '');

-- ----------------------------
-- Table structure for `extract`
-- ----------------------------
DROP TABLE IF EXISTS `extract`;
CREATE TABLE `extract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '用户姓名',
  `brank_num` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '用户银行卡号',
  `money` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '提现金额',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `wu_id` int(11) NOT NULL DEFAULT '0' COMMENT 'wechat_user id',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 未处理 2已处理',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='提现记录';

-- ----------------------------
-- Records of extract
-- ----------------------------
INSERT INTO `extract` VALUES ('1', 'www', '131313', '12', '19891831', '1', '1');

-- ----------------------------
-- Table structure for `top_up`
-- ----------------------------
DROP TABLE IF EXISTS `top_up`;
CREATE TABLE `top_up` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wu_id` int(11) DEFAULT '0' COMMENT 'wechat_user id',
  `order_num` varchar(255) DEFAULT '' COMMENT '订单编号',
  `money` varchar(255) DEFAULT '' COMMENT '充值金额',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(4) DEFAULT '1' COMMENT '1 未成功 2成功',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='充值记录';

-- ----------------------------
-- Records of top_up
-- ----------------------------
INSERT INTO `top_up` VALUES ('1', '1', '1', '1', '0', '1');
