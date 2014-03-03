-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 02 月 28 日 04:13
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ci_rbac`
--
CREATE DATABASE IF NOT EXISTS `ci_rbac` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ci_rbac`;

-- --------------------------------------------------------

--
-- 表的结构 `rbac_auth`
--

CREATE TABLE IF NOT EXISTS `rbac_auth` (
  `node_id` int(11) NOT NULL COMMENT '节点ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  UNIQUE KEY `nid_rid` (`node_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色与节点对应表';

--
-- 转存表中的数据 `rbac_auth`
--

INSERT INTO `rbac_auth` (`node_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1);

-- --------------------------------------------------------

--
-- 表的结构 `rbac_menu`
--

CREATE TABLE IF NOT EXISTS `rbac_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '导航名称',
  `node_id` int(11) DEFAULT NULL COMMENT '节点ID',
  `p_id` int(11) DEFAULT NULL COMMENT '导航父id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `rbac_menu`
--

INSERT INTO `rbac_menu` (`id`, `title`, `node_id`, `p_id`, `sort`, `status`) VALUES
(1, '后台管理', NULL, NULL, 9, 1),
(2, '节点管理', 5, 1, 2, 1),
(3, '导航管理', 1, 1, 1, 1),
(4, '人员管理', 14, 1, 4, 1),
(5, '角色管理', 9, 1, 3, 1),
(6, '一级菜单', 0, NULL, 0, 1),
(7, '二级节点', 18, 6, 1, 1),
(8, '一级菜单2', NULL, NULL, 2, 1),
(9, '二级菜单', NULL, 8, 1, 1),
(10, '三级节点', 18, 9, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `rbac_node`
--

CREATE TABLE IF NOT EXISTS `rbac_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dirc` varchar(20) NOT NULL COMMENT '目录',
  `cont` varchar(10) NOT NULL COMMENT '控制器',
  `func` varchar(10) NOT NULL COMMENT '方法',
  `memo` varchar(25) DEFAULT NULL COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `d_c_f` (`dirc`,`cont`,`func`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='节点表' AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `rbac_node`
--

INSERT INTO `rbac_node` (`id`, `dirc`, `cont`, `func`, `memo`, `status`) VALUES
(1, 'manage', 'Menu', 'index', '导航管理', 1),
(2, 'manage', 'Menu', 'edit', '导航修改', 1),
(3, 'manage', 'Menu', 'delete', '导航删除', 1),
(4, 'manage', 'Menu', 'add', '导航新增', 1),
(5, 'manage', 'Node', 'index', '节点管理', 1),
(6, 'manage', 'Node', 'add', '节点新增', 1),
(7, 'manage', 'Node', 'delete', '节点删除', 1),
(8, 'manage', 'Node', 'edit', '节点修改', 1),
(9, 'manage', 'Role', 'index', '角色管理', 1),
(10, 'manage', 'Role', 'action', '角色赋权', 1),
(11, 'manage', 'Role', 'delete', '角色删除', 1),
(12, 'manage', 'Role', 'edit', '角色修改', 1),
(13, 'manage', 'Role', 'add', '角色新增', 1),
(14, 'manage', 'Member', 'index', '人员管理', 1),
(15, 'manage', 'Member', 'edit', '人员修改', 1),
(16, 'manage', 'Member', 'delete', '人员删除', 1),
(17, 'manage', 'Member', 'add', '人员新增', 1),
(18, 'product', 'Index', 'index', '测试用节点', 1);

-- --------------------------------------------------------

--
-- 表的结构 `rbac_role`
--

CREATE TABLE IF NOT EXISTS `rbac_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(25) NOT NULL COMMENT '角色名',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rolename` (`rolename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `rbac_role`
--

INSERT INTO `rbac_role` (`id`, `rolename`, `status`) VALUES
(1, '管理员', 1);

-- --------------------------------------------------------

--
-- 表的结构 `rbac_user`
--

CREATE TABLE IF NOT EXISTS `rbac_user` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `rbac_user`
--

INSERT INTO `rbac_user` (`id`, `username`, `password`, `nickname`, `email`, `role_id`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'toryzen', 'admin@admin.com', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
