/*
SQLyog Enterprise - MySQL GUI v5.19
Host - 5.6.12-log : Database - ci_rbac
*********************************************************************
Server version : 5.6.12-log
*/

SET NAMES utf8;

SET SQL_MODE='';

create database if not exists `ci_rbac`;

USE `ci_rbac`;

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';

/*Table structure for table `rbac_auth` */

DROP TABLE IF EXISTS `rbac_auth`;

CREATE TABLE `rbac_auth` (
  `node_id` int(11) NOT NULL COMMENT '节点ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  UNIQUE KEY `nid_rid` (`node_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色与节点对应表';

/*Table structure for table `rbac_menu` */

DROP TABLE IF EXISTS `rbac_menu`;

CREATE TABLE `rbac_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '导航名称',
  `node_id` int(11) DEFAULT NULL COMMENT '节点ID',
  `p_id` int(11) DEFAULT NULL COMMENT '导航父id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='菜单表';

/*Table structure for table `rbac_node` */

DROP TABLE IF EXISTS `rbac_node`;

CREATE TABLE `rbac_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dirc` varchar(20) NOT NULL COMMENT '目录',
  `cont` varchar(10) NOT NULL COMMENT '控制器',
  `func` varchar(10) NOT NULL COMMENT '方法',
  `memo` varchar(25) DEFAULT NULL COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `d_c_f` (`dirc`,`cont`,`func`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='节点表';

/*Table structure for table `rbac_role` */

DROP TABLE IF EXISTS `rbac_role`;

CREATE TABLE `rbac_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(25) NOT NULL COMMENT '角色名',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rolename` (`rolename`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色表';

/*Table structure for table `rbac_user` */

DROP TABLE IF EXISTS `rbac_user`;

CREATE TABLE `rbac_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `nickname` varchar(20) NOT NULL COMMENT '昵称',
  `email` varchar(25) NOT NULL COMMENT 'Email',
  `role_id` int(11) DEFAULT NULL COMMENT '角色ID',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
