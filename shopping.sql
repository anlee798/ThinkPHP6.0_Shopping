-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-03-20 20:34:06
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `shopping`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_adress`
--

CREATE TABLE `tp_adress` (
  `id` int(11) NOT NULL COMMENT '地址表id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `username` varchar(50) NOT NULL COMMENT '收货人姓名',
  `phone` varchar(20) NOT NULL COMMENT '收货人手机号',
  `postcode` int(6) NOT NULL COMMENT '收货人邮编',
  `adress` varchar(255) NOT NULL COMMENT '收货地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_adress`
--

INSERT INTO `tp_adress` (`id`, `uid`, `username`, `phone`, `postcode`, `adress`) VALUES
(1, 10001, '风清扬', '17634432080', 465200, '海南省三亚市吉阳区'),
(7, 10001, '风清扬', '18338614359', 572000, '中国北京'),
(10, 10005, '东方不败', '18338614359', 66666, '中国北京'),
(11, 10002, 'hhhh', '222', 555, '54464');

-- --------------------------------------------------------

--
-- 表的结构 `tp_category`
--

CREATE TABLE `tp_category` (
  `id` int(11) NOT NULL COMMENT '类别Id',
  `parent_id` int(11) DEFAULT NULL COMMENT '父类别id当id=0时说明是根节点,一级类别',
  `name` varchar(50) DEFAULT NULL COMMENT '类别名称',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_category`
--

INSERT INTO `tp_category` (`id`, `parent_id`, `name`, `create_time`) VALUES
(11001, 0, '智能设备', '2020-02-24 00:00:00'),
(11002, 0, '美妆专区', '2020-02-24 00:00:00'),
(11003, 0, '服装专区', '2020-02-24 00:00:00'),
(11004, 0, '品牌云购', '2020-02-24 00:00:00'),
(11005, 11001, '手机', '2020-02-24 00:00:00'),
(11006, 11001, '电脑/办公', '2020-02-24 00:00:00'),
(11007, 11001, '电脑外设', '2020-02-24 00:00:00'),
(11008, 11001, '数码配件', '2020-02-24 00:00:00'),
(11009, 11002, '口红', '2020-02-24 00:00:00'),
(11010, 11002, '护肤馆', '2020-02-24 00:00:00'),
(11011, 11002, '彩妆馆', '2020-02-24 00:00:00'),
(11012, 11002, '香氛馆', '2020-02-24 00:00:00'),
(11013, 11004, '一线品牌', '2020-02-24 00:00:00'),
(11014, 11004, '零售品牌', '2020-02-24 00:00:00'),
(11015, 11004, '国内品牌', '2020-02-24 00:00:00'),
(11016, 11004, '国外品牌', '2020-02-24 00:00:00'),
(11018, 0, '家电/工具', '2020-02-28 11:34:35'),
(11020, 11003, '女装', '2020-03-02 10:21:42'),
(11021, 11003, '男装', '2020-03-02 10:21:52'),
(11022, 11003, '童装', '2020-03-02 10:21:58'),
(11023, 11003, '配饰', '2020-03-02 10:22:03'),
(11024, 11018, '厨具', '2020-03-02 10:23:51'),
(11025, 11018, '家纺', '2020-03-02 10:24:12'),
(11026, 11018, '生活电器', '2020-03-02 10:24:55'),
(11027, 11018, '个护健康', '2020-03-02 10:25:18');

-- --------------------------------------------------------

--
-- 表的结构 `tp_evaluate`
--

CREATE TABLE `tp_evaluate` (
  `id` int(11) NOT NULL COMMENT '评价表id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `nav` varchar(255) NOT NULL COMMENT '评价',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_evaluate`
--

INSERT INTO `tp_evaluate` (`id`, `uid`, `gid`, `nav`, `time`) VALUES
(6, 10001, 10000, 'haohaohaohaohoahaoahoahaohoasacnovodavbqvbovnjadaa', '2020-03-01 08:24:37');

-- --------------------------------------------------------

--
-- 表的结构 `tp_goods`
--

CREATE TABLE `tp_goods` (
  `id` int(11) NOT NULL COMMENT '商品表id，自动增长',
  `gname` varchar(255) NOT NULL COMMENT '商品名称',
  `price` int(11) UNSIGNED NOT NULL COMMENT '商品价格',
  `imgsrc` varchar(255) NOT NULL COMMENT '商品图片路径',
  `description` text COMMENT '商品描述',
  `stock` int(11) UNSIGNED DEFAULT NULL COMMENT '商品库存',
  `cid` int(10) UNSIGNED DEFAULT NULL COMMENT '商品分类ID',
  `sales` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品销量',
  `evaluate` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评价数量',
  `statue` int(1) NOT NULL COMMENT '是否下架(0-下架，1-正常)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_goods`
--

INSERT INTO `tp_goods` (`id`, `gname`, `price`, `imgsrc`, `description`, `stock`, `cid`, `sales`, `evaluate`, `statue`) VALUES
(10000, 'iphone11proMax', 9999, '/static/img/shopImg/1.jpg', '诺西N1 保修期:12个月 套餐类型:官方标配 是否线控:否 灵敏度:112dB/mW 生产企业:东莞市北欧电子有限公司 适用音乐类型:ACG动漫游戏控类型 阻抗:32Ω 频响范围:20-20Hz 颜色分类:黑色升级版黑色升级版(3.5单插口)白色升级版黑色七彩光版黑色七彩光版(3.5单插口)白色七彩光版黑色不发光版 佩戴方式:头戴护耳式 耳机类型:有线 有无麦克风:带麦 耳机售后服务:全国联保 插头直径:3.5mm 耳机插头类型:直插型 耳机输出音源:PC电脑 缆线长度:2.2米 耳机类别:普通耳机 品牌:诺西 型号:N1 ', 96, 11005, 2, 1, 1),
(10001, 'iphone8proMax', 6666, '/static/img/shopImg/1.jpg', '诺西N1 保修期:12个月 套餐类型:官方标配 是否线控:否 灵敏度:112dB/mW 生产企业:东莞市北欧电子有限公司 适用音乐类型:ACG动漫游戏控类型 阻抗:32Ω 频响范围:20-20Hz 颜色分类:黑色升级版黑色升级版(3.5单插口)白色升级版黑色七彩光版黑色七彩光版(3.5单插口)白色七彩光版黑色不发光版 佩戴方式:头戴护耳式 耳机类型:有线 有无麦克风:带麦 耳机售后服务:全国联保 插头直径:3.5mm 耳机插头类型:直插型 耳机输出音源:PC电脑 缆线长度:2.2米 耳机类别:普通耳机 品牌:诺西 型号:N1 ', 99, 11005, 1, 0, 0),
(10004, '索尼照相机', 16666, '/static/img/shopImg/d5\\c6aaf1f61b7fc856756686d0d0b771.jpg', '诺西N1 保修期:12个月 套餐类型:官方标配 是否线控:否 灵敏度:112dB/mW 生产企业:东莞市北欧电子有限公司 适用音乐类型:ACG动漫游戏控类型 阻抗:32Ω 频响范围:20-20Hz 颜色分类:黑色升级版黑色升级版(3.5单插口)白色升级版黑色七彩光版黑色七彩光版(3.5单插口)白色七彩光版黑色不发光版 佩戴方式:头戴护耳式 耳机类型:有线 有无麦克风:带麦 耳机售后服务:全国联保 插头直径:3.5mm 耳机插头类型:直插型 耳机输出音源:PC电脑 缆线长度:2.2米 耳机类别:普通耳机 品牌:诺西 型号:N1 ', 100, 11019, 0, 0, 1),
(10005, '松下照相机', 5555, '/static/img/shopImg/d5\\c6aaf1f61b7fc856756686d0d0b771.jpg', '松下照相机 日本产 价格公道 适合日常办公 数量有限 及时抢购 京东 淘宝 拼多多', 0, 11005, 0, 0, 1),
(10006, 'hhhh', 333, '/static/img/shopImg/d5\\c6aaf1f61b7fc856756686d0d0b771.jpg', '哈哈哈 哈哈哈哈哈哈哈哈哈 哈哈哈哈 哈哈哈哈看看 坎坎坷坷 咔咔咔咔咔咔 咔咔咔咔咔咔 咔咔咔咔咔咔', 0, 11005, 0, 0, 1),
(10007, 'qqq', 3333, '/static/img/shopImg/d5\\c6aaf1f61b7fc856756686d0d0b771.jpg', 'qwwe qef qefqe wfqf qwfq wf', 10, 11006, 0, 0, 1),
(10008, '132', 5555, '/static/img/shopImg/d5\\c6aaf1f61b7fc856756686d0d0b771.jpg', '21erfc qasad ewfefw gfwg', 23, 11002, 0, 0, 1),
(10009, '机器人', 6666, '/static/img/shopImg/d5\\c6aaf1f61b7fc856756686d0d0b771.jpg', '证书编号：2015010805827249++ 证书状态：有效++ 申请人名称：深圳市九州游科技有限公司++ 制造商名称：深圳市九州游科技有限公司++ 产品名称：数码播放器++3C 产品型号：A1，A2，A3，A5，A6，A7，A8，A9，A10，A20，A30，A50，A60，A70，A8...++3C 规格型号：A1，A2，A3，A5，A6，A7，A8，A9，A10，A20，A30，A50，A60，A70，A8...++ 产地:中国大陆++ 品牌:智力快车++ 型号:R2++ 玩具类型:电玩具++ 货号:R2++ 适用年龄段:&lt;14岁++ 颜色分类: 白色128MB 白色16G++ 适用年龄:2岁3岁4岁5岁6岁7岁8岁++套餐类型:【咨询客服再送大礼】++ 材质:塑料++ 是否有导购视频:有\', 5, 16, 80, 12', 100, 11008, 0, 0, 1),
(10010, 'HUAWEI', 4999, '/static/img/shopImg/86\\7136b876c3ecf2e0b934948225ca5f.jpg', '胡安娜的剧本v 奥冲爱车 阿偶混饭吃 爱是gia法 双酚AW为SbZAVA AGAEAERGDFS AGFV ', 48, 11005, 1, 0, 1),
(10011, '圣罗兰', 268, '/static/img/shopImg/72\\7c1e9cfcd191de8853f53b3827ac15.jpg', '暗示法啊agree 为atEFDS WEAFFFWD WADBFWEIFI DFWKIQ 购房户我佛 戒晚饭后全额返回 为哈佛恶化 未发货哦时是否为好 金佛', 100, 11009, 0, 0, 1),
(10012, '照相机', 2688, '/static/img/shopImg/13\\82186554884e981a9be7e838e0e1a0.jpg', '阿聪奥of群殴 东风街我发 万佛我 万佛我返回 万佛我我哈佛 万佛我佛我佛 晚饭后却无法 我佛去哦器 万佛我佛 为哈佛', 100, 11008, 0, 0, 1),
(10013, '夏装', 188, '/static/img/shopImg/da\\345310f1cb1d4b18e824f99770d037.jpg', '到期哦亲而佛 你去弄番茄红 清佛气氛 清佛气氛 起飞后起飞 清佛请回复轻浮去我去哦哦哦亲 去of黄浦区复合肥 解放前复合肥 ofo去', 99, 11020, 0, 0, 1),
(10014, '香水', 266, '/static/img/shopImg/b0\\3600075a8719e48140b2ea917fe40b.jpg', '好好从前我欺负 佛前黄飞鸿 起飞后全球化 你能否QQof和 去哦哦分红青海湖 清佛群殴分红 轻浮好气哦护肤 浅粉红请回复 气氛浓请回复 清佛请回复 去of红曲粉', 50, 11012, 0, 0, 1),
(10015, '男装', 99, '/static/img/shopImg/a5\\26671a44f070588fa351faabd25e22.jpg', '撒女不代表 爱红曲粉好气哦 群殴of后期恢复 全部浮球阀 缺乏对后期符合 全球化佛强风化 浅粉红请回复 放大器哦哈佛强风化轻浮 切换佛请回复 切换佛前红曲粉 轻浮切换佛请回复', 20, 11021, 0, 0, 1),
(10016, '净水器', 1099, '/static/img/shopImg/e6\\994f1e30bb417763081f4247e163d2.jpg', '爱情ofo去 清佛请回复 清佛进去发挥 清佛气氛 切换佛前哈佛 请回复后期哈佛 切换佛前发货 切换佛法和', 60, 11024, 0, 0, 1),
(10017, '笔记本电脑', 5999, '/static/img/shopImg/0a\\e536fac9f70bb0ad416369c7d58534.jpg', '啊飒飒的 十多万的父亲  我确认 我完全去 我QQ人 去问问我去 QQ 阒其无人群 欠人情若 欠人情', 30, 11006, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_order`
--

CREATE TABLE `tp_order` (
  `id` int(11) NOT NULL COMMENT '订单id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `num` int(11) NOT NULL COMMENT '数量',
  `money` decimal(10,2) NOT NULL COMMENT '总金额',
  `user_adress` int(11) NOT NULL COMMENT '用户地址ID',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `statue` int(1) NOT NULL DEFAULT '1' COMMENT '1-正常,0-用户删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_order`
--

INSERT INTO `tp_order` (`id`, `user_id`, `goods_id`, `num`, `money`, `user_adress`, `createtime`, `statue`) VALUES
(2, 10001, 10001, 9, '59994.00', 1, '2020-02-26 15:44:37', 1),
(3, 10001, 10000, 2, '19998.00', 1, '2020-02-27 07:02:01', 1),
(6, 10001, 10004, 1, '16666.00', 1, '2020-02-28 15:04:31', 1),
(7, 10005, 10000, 3, '29997.00', 10, '2020-03-05 13:55:04', 1),
(8, 10001, 10000, 1, '9999.00', 1, '2020-03-20 10:46:52', 1),
(9, 10001, 6, 0, '0.00', 1, '2020-03-20 11:30:13', 1),
(10, 10002, 6, 0, '0.00', 11, '2020-03-20 11:40:18', 1),
(11, 10002, 8, 0, '0.00', 11, '2020-03-20 11:40:18', 1),
(12, 10002, 10000, 1, '9999.00', 11, '2020-03-20 11:40:47', 1),
(13, 10002, 6, 0, '0.00', 11, '2020-03-20 11:42:23', 1),
(14, 10002, 9, 0, '0.00', 11, '2020-03-20 11:42:23', 1),
(15, 10002, 6, 0, '0.00', 11, '2020-03-20 11:43:08', 1),
(16, 10002, 9, 0, '0.00', 11, '2020-03-20 11:43:08', 1),
(17, 10002, 6, 0, '0.00', 11, '2020-03-20 11:44:29', 1),
(18, 10002, 9, 0, '0.00', 11, '2020-03-20 11:44:29', 1),
(19, 10002, 6, 0, '0.00', 11, '2020-03-20 11:46:31', 1),
(20, 10002, 9, 0, '0.00', 11, '2020-03-20 11:46:31', 1),
(21, 10002, 6, 0, '0.00', 11, '2020-03-20 11:47:07', 1),
(22, 10002, 9, 0, '0.00', 11, '2020-03-20 11:47:07', 1),
(23, 10002, 9, 0, '0.00', 11, '2020-03-20 11:49:20', 1),
(25, 10002, 10011, 1, '268.00', 11, '2020-03-20 11:53:52', 1),
(26, 10002, 10010, 1, '4999.00', 11, '2020-03-20 11:54:57', 1),
(27, 10002, 10000, 1, '9999.00', 11, '2020-03-20 11:54:57', 1),
(28, 10002, 10016, 1, '1099.00', 11, '2020-03-20 11:56:41', 1),
(29, 10002, 10012, 1, '2688.00', 11, '2020-03-20 11:57:20', 1),
(30, 10002, 10010, 1, '4999.00', 11, '2020-03-20 12:04:20', 1),
(31, 10002, 10010, 1, '4999.00', 11, '2020-03-20 12:05:25', 1),
(32, 10002, 10010, 1, '4999.00', 11, '2020-03-20 12:06:08', 1),
(33, 10002, 10010, 1, '4999.00', 11, '2020-03-20 12:08:05', 1),
(34, 10002, 10013, 1, '188.00', 11, '2020-03-20 12:09:29', 1),
(35, 10002, 10010, 1, '4999.00', 11, '2020-03-20 12:11:19', 1),
(36, 10001, 10000, 1, '9999.00', 7, '2020-03-20 12:29:04', 1),
(37, 10001, 10000, 1, '9999.00', 1, '2020-03-20 12:29:32', 1),
(38, 10001, 10000, 1, '9999.00', 7, '2020-03-20 12:30:46', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_shopcart`
--

CREATE TABLE `tp_shopcart` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键ID，自动增长',
  `uid` int(10) UNSIGNED NOT NULL COMMENT '购买者ID',
  `addtime` timestamp NULL DEFAULT NULL COMMENT '加入购物车时间',
  `gid` varchar(255) DEFAULT NULL COMMENT '购买商品ID',
  `num` tinyint(3) NOT NULL COMMENT '购买商品数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_shopcart`
--

INSERT INTO `tp_shopcart` (`id`, `uid`, `addtime`, `gid`, `num`) VALUES
(12, 10001, '2020-03-20 11:55:46', '10011', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_user`
--

CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL COMMENT '用户表id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '用户密码，MD5加密',
  `email` varchar(50) DEFAULT NULL COMMENT '邮件',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `question` varchar(100) DEFAULT NULL COMMENT '找回密码问题',
  `answer` varchar(100) DEFAULT NULL COMMENT '找回密码答案',
  `role` int(4) NOT NULL COMMENT '0-超级管理员,1-普通管理员，2-会员',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '最后一次更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_user`
--

INSERT INTO `tp_user` (`id`, `username`, `password`, `email`, `phone`, `question`, `answer`, `role`, `create_time`, `update_time`) VALUES
(10001, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '17634432080', '123', '123', 1, '2020-02-22 00:00:00', '2020-03-20 20:28:35'),
(10002, 'Jason', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '17634432080', '123', '123', 2, '2020-02-23 11:32:34', '2020-03-20 19:56:19'),
(10003, '令狐冲', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '17634432080', '123', '123', 2, '2020-02-27 21:09:05', '2020-02-27 21:09:05'),
(10004, 'hhhhh', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '17634432080', '123', '123', 2, '2020-02-29 13:53:24', '2020-02-29 13:53:24'),
(10005, '白龙马', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '17634432080', '123', '123', 2, '2020-03-05 21:01:02', '2020-03-05 21:01:02'),
(10006, 'hhh', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '18338614359', '123', '123', 2, '2020-03-20 14:36:10', '2020-03-20 14:36:10'),
(10007, '马冬梅', 'c33367701511b4f6020ec61ded352059', '2578329547@qq.com', '17634432080', '123', '123', 2, '2020-03-20 14:42:30', '2020-03-20 14:42:30'),
(10012, '马云', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '17634432080', '123', '123', 2, '2020-03-20 14:59:47', '2020-03-20 14:59:47'),
(10013, '123', 'e10adc3949ba59abbe56e057f20f883e', '2578329547@qq.com', '222', '123456', '123456', 2, '2020-03-20 15:10:49', '2020-03-20 15:10:49');

--
-- 转储表的索引
--

--
-- 表的索引 `tp_adress`
--
ALTER TABLE `tp_adress`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_category`
--
ALTER TABLE `tp_category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_evaluate`
--
ALTER TABLE `tp_evaluate`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_goods`
--
ALTER TABLE `tp_goods`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_order`
--
ALTER TABLE `tp_order`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_shopcart`
--
ALTER TABLE `tp_shopcart`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_user`
--
ALTER TABLE `tp_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name_unique` (`username`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tp_adress`
--
ALTER TABLE `tp_adress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地址表id', AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `tp_category`
--
ALTER TABLE `tp_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '类别Id', AUTO_INCREMENT=11028;

--
-- 使用表AUTO_INCREMENT `tp_evaluate`
--
ALTER TABLE `tp_evaluate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评价表id', AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `tp_goods`
--
ALTER TABLE `tp_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品表id，自动增长', AUTO_INCREMENT=10018;

--
-- 使用表AUTO_INCREMENT `tp_order`
--
ALTER TABLE `tp_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id', AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `tp_shopcart`
--
ALTER TABLE `tp_shopcart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID，自动增长', AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `tp_user`
--
ALTER TABLE `tp_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户表id', AUTO_INCREMENT=10014;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
