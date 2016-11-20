-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-18 21:29:28
-- 服务器版本： 10.1.8-MariaDB
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `happy_class`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_back`
--

CREATE TABLE IF NOT EXISTS `tp_back` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `class_id` int(3) NOT NULL COMMENT '投票的班级id',
  `time` int(11) NOT NULL COMMENT '上一次统计的投票时间',
  `num` int(11) NOT NULL COMMENT '上一次的票数 '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='返回时间点的表';

--
-- 转存表中的数据 `tp_back`
--

INSERT INTO `tp_back` (`id`, `class_id`, `time`, `num`) VALUES
(0, 2, 1479458771, 3);

-- --------------------------------------------------------

--
-- 表的结构 `tp_button`
--

CREATE TABLE IF NOT EXISTS `tp_button` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tp_class`
--

CREATE TABLE IF NOT EXISTS `tp_class` (
  `id` int(11) NOT NULL COMMENT '唯一id',
  `name` varchar(30) NOT NULL COMMENT '班级名称',
  `info` text NOT NULL COMMENT '班级介绍',
  `num` int(11) NOT NULL COMMENT '票数',
  `change` varchar(200) NOT NULL COMMENT '修改票数数据'
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_class`
--

INSERT INTO `tp_class` (`id`, `name`, `info`, `num`, `change`) VALUES
(1, '15电气三班', '拉票宣言：快乐无道理，三班永伴你，一五电气三班，需要你的支持！', 0, ''),
(2, '16机电二班', '你确定不支持16级的小鲜肉吗？请把你们神圣的一票给我们吧！我们是16机电2班，谢谢！', 0, ''),
(3, '15英语三班', '你投或者不投，我们都在这里。', 0, ''),
(4, '15人力一班', '作为一群人力的咸鱼，我们会的不仅是翻身，最重要的是我们还有梦想。', 0, ''),
(5, '15会计三班', '气质高贵 发型到位 我们呐喊 三班万岁 谢谢你们！', 0, ''),
(6, '14金融六班', '期待你的爱与支持和鼓励。请投我们14金融6班一票！麻烦各位投票啊! 你的一张票就是我们班的无限动力！感谢你们的支持哟@14金融（6）班', 0, ''),
(7, '14车辆三班', '快乐无处不在，有时“矛盾”作怪，班级才是真爱！', 0, ''),
(8, '15国贸三班', '15国贸3班拉票宣言:在一起，我们就了不起！投我，你也了不起！', 0, ''),
(9, '15建筑三班', '志存高远，无所畏惧', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `tp_danmu`
--

CREATE TABLE IF NOT EXISTS `tp_danmu` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `danmu` varchar(400) NOT NULL COMMENT '弹幕json',
  `class_id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_danmu`
--

INSERT INTO `tp_danmu` (`id`, `danmu`, `class_id`, `time`) VALUES
(12, '{ &quot;text&quot;:&quot;123456&quot;,&quot;color&quot;:&quot;#ffffff&quot;,&quot;size&quot;:&quot;1&quot;,&quot;position&quot;:&quot;0&quot;,&quot;time&quot;:251}', 0, 1479473450),
(13, '{ &quot;text&quot;:&quot;234156&quot;,&quot;color&quot;:&quot;#ffffff&quot;,&quot;size&quot;:&quot;1&quot;,&quot;position&quot;:&quot;0&quot;,&quot;time&quot;:3}', 0, 1479473458);

-- --------------------------------------------------------

--
-- 表的结构 `tp_people`
--

CREATE TABLE IF NOT EXISTS `tp_people` (
  `id` int(11) NOT NULL COMMENT '主键',
  `class_id` int(11) NOT NULL COMMENT '投票班级名称',
  `time` int(11) NOT NULL COMMENT '投票时间戳',
  `ip` varchar(30) NOT NULL COMMENT '投票者的ip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='记录投票人信息的表';

--
-- 转存表中的数据 `tp_people`
--

INSERT INTO `tp_people` (`id`, `class_id`, `time`, `ip`) VALUES
(0, 2, 1479458771, '0.0.0.0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tp_back`
--
ALTER TABLE `tp_back`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_button`
--
ALTER TABLE `tp_button`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_class`
--
ALTER TABLE `tp_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tp_danmu`
--
ALTER TABLE `tp_danmu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_people`
--
ALTER TABLE `tp_people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tp_button`
--
ALTER TABLE `tp_button`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tp_class`
--
ALTER TABLE `tp_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一id',AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tp_danmu`
--
ALTER TABLE `tp_danmu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
