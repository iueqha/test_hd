/*
SQLyog v10.2 
MySQL - 5.6.33-log : Database - test_data
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `banner` */

DROP TABLE IF EXISTS `banner`;

CREATE TABLE `banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '广告图名称',
  `pic` varchar(60) DEFAULT NULL COMMENT '广告图链接',
  `place` tinyint(1) DEFAULT '0' COMMENT '广告图位置',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '0--已删除 1--可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '类别名称',
  `pid` int(10) DEFAULT '0' COMMENT '类别父ID',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `common` */

DROP TABLE IF EXISTS `common`;

CREATE TABLE `common` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `key` varchar(30) DEFAULT NULL COMMENT '公共信息key',
  `name` varchar(30) DEFAULT NULL COMMENT '公共信息名称',
  `content` text COMMENT '公共信息内容',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `history_record` */

DROP TABLE IF EXISTS `history_record`;

CREATE TABLE `history_record` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT NULL COMMENT '浏览的产品ID',
  `ip` varchar(30) DEFAULT NULL COMMENT '浏览的IP',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `manager` */

DROP TABLE IF EXISTS `manager`;

CREATE TABLE `manager` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account` varchar(60) DEFAULT NULL COMMENT '账号',
  `password` varchar(60) DEFAULT NULL COMMENT '密码',
  `encrypt_key` varchar(60) DEFAULT NULL COMMENT '加密key',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态是否可用 0--不可用 1--可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '留言人名称',
  `cellphone` int(11) DEFAULT NULL COMMENT '手机号',
  `phone` int(11) DEFAULT NULL COMMENT '座机',
  `info` varchar(200) DEFAULT NULL COMMENT '留言',
  `ip` varchar(30) DEFAULT NULL COMMENT 'ip',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `is_read` tinyint(4) DEFAULT '0' COMMENT '是否已读',
  `desc` varchar(100) DEFAULT NULL COMMENT '备注',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '产品名称',
  `pic` varchar(60) DEFAULT NULL COMMENT '产品封面图',
  `desc` varchar(100) DEFAULT NULL COMMENT '描述',
  `content` text COMMENT '内容',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '0--已删除 1--可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `product_category` */

DROP TABLE IF EXISTS `product_category`;

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT '0' COMMENT '商品ID',
  `category_id` int(11) DEFAULT '0' COMMENT '分类ID',
  `category_title` varchar(20) DEFAULT '' COMMENT '分类名称',
  `update_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
