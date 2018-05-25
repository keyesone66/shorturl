/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : cs

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-05-25 15:11:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for shorturl_settings
-- ----------------------------
DROP TABLE IF EXISTS `shorturl_settings`;
CREATE TABLE `shorturl_settings` (
  `last_number` bigint(20) unsigned NOT NULL DEFAULT '0',
  KEY `last_number` (`last_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of shorturl_settings
-- ----------------------------
INSERT INTO `shorturl_settings` VALUES ('1002022');
INSERT INTO `shorturl_settings` VALUES ('1002022');

-- ----------------------------
-- Table structure for shorturl_urls
-- ----------------------------
DROP TABLE IF EXISTS `shorturl_urls`;
CREATE TABLE `shorturl_urls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of shorturl_urls
-- ----------------------------
INSERT INTO `shorturl_urls` VALUES ('48', 'http://www.cnblogs.com/iforever/p/4316422.html', 'abcde', '2018-05-25 15:04:27');
INSERT INTO `shorturl_urls` VALUES ('34', 'http://www.cnblogs.com/iforever/p/4316422.html', 'fvBX', '2018-05-24 18:47:41');
INSERT INTO `shorturl_urls` VALUES ('35', 'http://php.net/manual-lookup.php?pattern=do+while&scope=quickref', '/manual-lookup.php', '2018-05-24 20:23:41');
INSERT INTO `shorturl_urls` VALUES ('36', 'http://www.ccc.com/fvBX', '/fvBX', '2018-05-24 20:25:04');
INSERT INTO `shorturl_urls` VALUES ('39', 'http://www.sjyhome.com/php/shorturl.html', 'iforever/p/4316422.h', '2018-05-24 20:59:25');
INSERT INTO `shorturl_urls` VALUES ('40', 'http://www.cnblogs.com/iforever', 'iforever', '2018-05-25 12:04:23');
