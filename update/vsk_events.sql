/*
Navicat MySQL Data Transfer

Source Server         : Titan
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : eticket

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2013-03-07 10:09:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `vsk_events`
-- ----------------------------
DROP TABLE IF EXISTS `vsk_events`;
CREATE TABLE `vsk_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `display_start_time` tinyint(1) DEFAULT '1',
  `display_end_time` tinyint(1) DEFAULT '1',
  `last_modified` int(10) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `img` varchar(20) DEFAULT NULL,
  `thumbnail` text,
  `description` text,
  `organizer_name` varchar(200) DEFAULT NULL,
  `organizer_description` text,
  `published` tinyint(1) DEFAULT NULL,
  `show_tickets` tinyint(1) DEFAULT '0',
  `disabled` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  `is_repeat` tinyint(1) DEFAULT '0',
  `reason` text,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vsk_events
-- ----------------------------
INSERT INTO `vsk_events` VALUES ('4', '1', 'Sự kiện Infographic 2012', 'su-kien-infographic-2012', '1', '2012-10-06 12:00:00', '2012-10-06 15:00:00', '1', '1', null, '1349260495', 'hiYrZRatf.jpg', 'a:3:{s:9:\"thumbnail\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:21:\"277x140-hiYrZRatf.jpg\";s:5:\"width\";i:277;s:6:\"height\";i:140;}s:5:\"small\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:19:\"50x50-hiYrZRatf.jpg\";s:5:\"width\";i:50;s:6:\"height\";i:50;}s:4:\"full\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:13:\"hiYrZRatf.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:768;}}', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Sự kiện infographic đầu ti&ecirc;n</p>\r\n</body>\r\n</html>', null, null, '1', '1', '0', '0', '0', null);
INSERT INTO `vsk_events` VALUES ('5', '1', 'Hội chợ CNTT WVC2012', 'hoi-cho-cntt-wvc2012', '2', '2012-10-07 07:00:00', '2012-10-10 19:00:00', '1', '1', null, '1349431061', '7GeAHSvzf.jpg', 'a:3:{s:9:\"thumbnail\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:21:\"277x140-7GeAHSvzf.jpg\";s:5:\"width\";i:277;s:6:\"height\";i:140;}s:5:\"small\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:19:\"50x50-7GeAHSvzf.jpg\";s:5:\"width\";i:50;s:6:\"height\";i:50;}s:4:\"full\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:13:\"7GeAHSvzf.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:768;}}', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n\r\n</body>\r\n</html>', null, null, '1', '1', '0', '0', '0', null);
INSERT INTO `vsk_events` VALUES ('7', '1', 'Sự kiện Boxing 2012', 'su-kien-boxing-2012', '1', '2012-10-11 12:00:00', '2012-10-13 14:00:00', '0', '0', null, '1349754526', '28AObjUhL.jpg', 'a:3:{s:9:\"thumbnail\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:21:\"277x140-28AObjUhL.jpg\";s:5:\"width\";i:277;s:6:\"height\";i:140;}s:5:\"small\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:19:\"50x50-28AObjUhL.jpg\";s:5:\"width\";i:50;s:6:\"height\";i:50;}s:4:\"full\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:13:\"28AObjUhL.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:768;}}', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Đ&acirc;y l&agrave; sự kiện Boxing lần đầu ti&ecirc;n tại VietNam</p>\r\n</body>\r\n</html>', null, null, '1', '1', '0', '0', '0', null);
INSERT INTO `vsk_events` VALUES ('9', '1', 'Xem tranh 3D', 'xem-tranh-3d', '2', '2012-10-11 12:00:00', '2012-10-11 17:00:00', '1', '1', null, '1349756762', 'jxAGdAkAd.jpg', 'a:3:{s:9:\"thumbnail\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:21:\"277x140-jxAGdAkAd.jpg\";s:5:\"width\";i:277;s:6:\"height\";i:140;}s:5:\"small\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:19:\"50x50-jxAGdAkAd.jpg\";s:5:\"width\";i:50;s:6:\"height\";i:50;}s:4:\"full\";a:4:{s:6:\"folder\";s:8:\"2012/10/\";s:8:\"filename\";s:13:\"jxAGdAkAd.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:768;}}', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p style=\"text-align: justify;\"><span style=\"font-size: medium;\">Dear Sir/Madam,</span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-size: medium;\">The Singapore Management University (SMU) Executive MBA program is a prestigious program that will equip students with the knowledge and skills sets to take companies global and turn change paradigm shifts into growth. The key features of the SMU EMBA program are:</span></p>\r\n<ul>\r\n<li><span style=\"text-indent: -18pt; font-size: medium;\">The most senior students&rsquo; profile in the world with the current intake consisting of 68% C-Suite executives, average age 43 years, 20 years rich experiences from 11 countries.</span></li>\r\n<li><span style=\"text-indent: -18pt; font-size: medium;\">Accelerated program, 9 weeks over 12 months.</span></li>\r\n<li><span style=\"text-indent: -18pt; font-size: medium;\">Classes held in the USA (The Wharton School), India (Indian School of Business). China (Peking University) and Singapore (SMU).</span></li>\r\n<li><span style=\"text-indent: -18pt; font-size: medium;\">Curriculum co-designed by 100 business leaders in Asia</span></li>\r\n</ul>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">We will be in Vietnam Hanoi on <strong>5&nbsp;Oct 2012</strong>. We will be having an information session to recruit students for the SMU EMBA program at the <strong>Fortuna&nbsp;Hotel</strong> from <strong>7pm to 8.30pm</strong>. Dinner will be from 6pm to 7pm.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">The information session will be conducted in English.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">The basic entry requirements are:</span></p>\r\n<ul>\r\n<li><span style=\"text-indent: -18pt; font-size: medium;\">At least a Bachelor&rsquo; Degree from any discipline</span></li>\r\n<li><span style=\"text-indent: -18pt; font-size: medium;\">More than 10 years of working experience</span></li>\r\n</ul>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">We would like to invite your senior executives who are responsible for talent development and succession planning of you organizations (such as CEOs and Human Resources Director) as well as senior executives whom you deem suitable for our SMU EMBA program to attend our information session.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">Thank you and we look forward to meeting you at our event.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">Neo Chia Reei</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">Director, SMU EMBA Program</span></p>\r\n</body>\r\n</html>', null, null, '1', '1', '1', '0', '1', 'Vi phạm');
