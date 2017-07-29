/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : tp32cms

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-07-29 12:41:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `add_time` int(10) DEFAULT NULL,
  `last_time` int(10) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_admin
-- ----------------------------
INSERT INTO `cms_admin` VALUES ('1', 'lianx314', '3109c2ee735c83fac824c73786246361', '1431999838', null, '1', '1');
INSERT INTO `cms_admin` VALUES ('2', 'zhang', 'cd726acaf264667c5f08507ed6c2dff8', '1495769686', '1495769686', '1', '2');

-- ----------------------------
-- Table structure for `cms_album`
-- ----------------------------
DROP TABLE IF EXISTS `cms_album`;
CREATE TABLE `cms_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` tinyint(4) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `orig` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `abst` varchar(255) NOT NULL,
  `info` mediumtext NOT NULL,
  `add_time` datetime NOT NULL,
  `ordid` tinyint(4) NOT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_best` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-待审核 1-已审核',
  `seo_title` varchar(255) NOT NULL,
  `seo_keys` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  `approval` int(11) NOT NULL DEFAULT '0',
  `opposition` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_best` (`is_best`),
  KEY `add_time` (`add_time`),
  KEY `cate_id` (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_album
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_album_image`
-- ----------------------------
DROP TABLE IF EXISTS `cms_album_image`;
CREATE TABLE `cms_album_image` (
  `id` int(11) NOT NULL,
  `sitename` varchar(100) DEFAULT NULL,
  `durl` varchar(255) NOT NULL,
  `downloads` int(11) NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_album_image
-- ----------------------------
INSERT INTO `cms_album_image` VALUES ('1', '网盘下载', 'http://sharncode.ctfile.com/fs/syE147645743', '0', '0');
INSERT INTO `cms_album_image` VALUES ('5', '百度网盘', 'http://pan.baidu.com/s/1bVigB8', '0', '1');
INSERT INTO `cms_album_image` VALUES ('7', '网盘下载', 'http://page49.ctfile.com/fs/Yk7147644036', '0', '1');
INSERT INTO `cms_album_image` VALUES ('6', '网盘下载', 'http://sharncode.ctfile.com/fs/P2O147644231', '0', '1');
INSERT INTO `cms_album_image` VALUES ('9', '网盘下载', 'http://sharncode.ctfile.com/fs/Zm9147647993', '0', '1');
INSERT INTO `cms_album_image` VALUES ('8', '网盘下载', 'http://sharncode.ctfile.com/fs/mDV147646508', '0', '1');
INSERT INTO `cms_album_image` VALUES ('10', '网盘下载', 'http://sharncode.ctfile.com/fs/CNX147647999', '0', '1');
INSERT INTO `cms_album_image` VALUES ('11', '网盘下载', 'http://sharncode.ctfile.com/fs/9QA147648011', '0', '1');
INSERT INTO `cms_album_image` VALUES ('12', '百度网盘', 'http://sharncode.ctfile.com/fs/Yw6147648020', '0', '1');
INSERT INTO `cms_album_image` VALUES ('13', '网盘下载', 'http://sharncode.ctfile.com/fs/fTj147648032', '0', '1');
INSERT INTO `cms_album_image` VALUES ('14', '网盘下载', 'http://sharncode.ctfile.com/fs/cQ5147648083', '0', '1');
INSERT INTO `cms_album_image` VALUES ('15', '网盘下载', 'http://sharncode.ctfile.com/fs/J5h147648098', '0', '1');
INSERT INTO `cms_album_image` VALUES ('16', '网盘下载', 'http://sharncode.ctfile.com/fs/nPL147737804', '0', '1');
INSERT INTO `cms_album_image` VALUES ('17', '网盘下载', 'http://sharncode.ctfile.com/fs/2ii147737981', '0', '1');
INSERT INTO `cms_album_image` VALUES ('18', '网盘下载', 'http://sharncode.ctfile.com/fs/QPu147738035', '0', '1');
INSERT INTO `cms_album_image` VALUES ('19', '网盘下载', 'http://sharncode.ctfile.com/fs/vJN147738062', '0', '1');
INSERT INTO `cms_album_image` VALUES ('20', '网盘下载', 'http://sharncode.ctfile.com/fs/9Rt147738059', '0', '1');
INSERT INTO `cms_album_image` VALUES ('21', '网盘下载', 'http://sharncode.ctfile.com/fs/EjZ147738317', '0', '1');
INSERT INTO `cms_album_image` VALUES ('22', '网盘下载', 'http://sharncode.ctfile.com/fs/0vv152058794', '0', '2');
INSERT INTO `cms_album_image` VALUES ('23', '网盘下载1', 'http://dix3.com/fs/5s4h9a8r0nfc3o0de0/', '0', '1');
INSERT INTO `cms_album_image` VALUES ('24', '网盘下载', 'http://sharncode.ctfile.com/fs/f1F152057255', '0', '2');
INSERT INTO `cms_album_image` VALUES ('26', '网盘下载', 'http://sharncode.ctfile.com/fs/PDy152057045', '0', '1');
INSERT INTO `cms_album_image` VALUES ('24', '网盘下载1', 'http://dix3.com/fs/fs8h1a6ran3c8o8de3/', '0', '1');
INSERT INTO `cms_album_image` VALUES ('22', '网盘下载1', 'http://dix3.com/fs/cs8h5a8rbn1cbo5de0/', '0', '1');

-- ----------------------------
-- Table structure for `cms_article`
-- ----------------------------
DROP TABLE IF EXISTS `cms_article`;
CREATE TABLE `cms_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` tinyint(4) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `orig` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `abst` varchar(255) NOT NULL,
  `info` mediumtext NOT NULL,
  `add_time` datetime NOT NULL,
  `ordid` tinyint(4) NOT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_best` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-待审核 1-已审核',
  `seo_title` varchar(255) NOT NULL,
  `seo_keys` varchar(255) NOT NULL,
  `seo_desc` text NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  `approval` int(11) NOT NULL DEFAULT '0',
  `opposition` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_best` (`is_best`),
  KEY `add_time` (`add_time`),
  KEY `cate_id` (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_article
-- ----------------------------
INSERT INTO `cms_article` VALUES ('1', '4', '关于我们', '3', '', '', '4', '5', '2017-05-17 10:51:03', '2', '1', '0', '1', '', '', '', '0', '0', '0');
INSERT INTO `cms_article` VALUES ('2', '4', '诚邀合作', '', '', '', '诚邀合作', '诚邀合作', '2017-06-02 19:34:01', '0', '1', '0', '1', '', '', '', '0', '0', '0');

-- ----------------------------
-- Table structure for `cms_catalog`
-- ----------------------------
DROP TABLE IF EXISTS `cms_catalog`;
CREATE TABLE `cms_catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icourl` varchar(100) DEFAULT NULL,
  `alias` varchar(50) NOT NULL,
  `pid` smallint(4) unsigned NOT NULL,
  `channel` smallint(4) NOT NULL DEFAULT '2',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `shownav` tinyint(1) NOT NULL DEFAULT '0',
  `showbottom` tinyint(1) unsigned NOT NULL,
  `istuijian` tinyint(1) NOT NULL,
  `sort` smallint(4) unsigned NOT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_catalog
-- ----------------------------
INSERT INTO `cms_catalog` VALUES ('1', 'html模板', 'psd17174.JPG', 'htmltemplate', '0', '3', '1', '1', '0', '0', '2', '', '', 'html描述');
INSERT INTO `cms_catalog` VALUES ('3', '整站模板', './data/setting/597bddbc63340.JPG', 'sitetemplate', '0', '3', '1', '1', '0', '1', '4', '', '', '');
INSERT INTO `cms_catalog` VALUES ('4', '关于我们', null, 'aboutus', '0', '2', '1', '1', '1', '0', '99', '', '', '');
INSERT INTO `cms_catalog` VALUES ('5', 'wap站点1', './data/setting/597bdd4a695e6.JPG', 'wap', '1', '3', '1', '1', '0', '0', '2', '', '', '');
INSERT INTO `cms_catalog` VALUES ('6', '1', './data/setting/597bdb189b801.JPG', '1', '0', '1', '1', '0', '0', '0', '1', '', '', '');

-- ----------------------------
-- Table structure for `cms_download`
-- ----------------------------
DROP TABLE IF EXISTS `cms_download`;
CREATE TABLE `cms_download` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `descript` varchar(255) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `modelid` int(11) NOT NULL,
  `projectid` int(11) NOT NULL,
  `languageid` int(11) NOT NULL,
  `keywords` int(11) DEFAULT NULL,
  `imgurl` varchar(255) DEFAULT NULL,
  `addtime` int(20) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `downloads` int(11) NOT NULL DEFAULT '0',
  `detail` text,
  `filesize` float NOT NULL,
  `platform` tinyint(1) NOT NULL DEFAULT '1',
  `officialurl` varchar(255) DEFAULT NULL,
  `officialdurl` varchar(255) DEFAULT NULL,
  `version` float DEFAULT '0',
  `ishot1` tinyint(1) unsigned DEFAULT NULL,
  `ishot2` tinyint(1) unsigned DEFAULT NULL,
  `ishot3` tinyint(1) unsigned DEFAULT NULL,
  `ishot4` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_download
-- ----------------------------
INSERT INTO `cms_download` VALUES ('7', 'mqtt-client-0.4.0.jar', '', '3', '0', '0', '1', null, null, '1459845783', '1', '78', '0', 'mqtt-client-0.4.0.jar mqtt协议客户端', '0', '1', null, null, '0', '0', '0', '1', '0');
INSERT INTO `cms_download` VALUES ('30', '大气宽屏旅游公司介绍单页模板', '', '5', '0', '0', '5', null, '5928402923261.png', '1495778856', '1', '48', '0', 'a', '0', '1', null, null, '0', '1', '0', '0', '0');
INSERT INTO `cms_download` VALUES ('28', '英文大气宽屏的工程建设公司网站静态模板', '', '5', '0', '6', '0', null, '5928405fd72e1.png', '1494988681', '1', '16', '0', '1', '0', '1', null, null, '0', '1', '0', '0', '0');
INSERT INTO `cms_download` VALUES ('29', '宽屏教育培训公司网页模板', '', '5', '0', '0', '5', null, '5928409be2994.png', '1494989288', '1', '103', '0', '<h2 id=\"h2-flash-\" style=\"font-size:21px;color:#303030;font-family:Verdana, Helvetica, Arial;text-align:justify;background-color:#FFFFFF;\">\r\n	<span class=\"header-link octicon octicon-link\">Flash上传</span> \r\n</h2>\r\n<p style=\"color:#303030;font-family:Verdana, Helvetica, Arial;text-align:justify;background-color:#FFFFFF;\">\r\n	很多时候上传的需求要求显示<strong>上传进度、中断上传过程、大文件分片上传</strong>等等，这时传统的表单上传很难实现这些功能，于是产生了使用Flash上传的方式，它采用Flash作为一个中间代理层，代替客户端跟服务端通信，此外，它也对客户端的文件选择方面拥有更多的控制权，比input[type=”file”] 要大得多。\r\n</p>\r\n<p style=\"color:#303030;font-family:Verdana, Helvetica, Arial;text-align:justify;background-color:#FFFFFF;\">\r\n	在这里我使用了jQuery封装好的uploadify插件来进行演示，一般这类插件都自带了上传用的Flash文件，因为跟服务端回传的数据和展示跟客户端的交互，都是Flash文件的接口跟插件来对接的。<img src=\"/findide/data/news/image/20170523/20170523172435_55708.jpg\" alt=\"\" /> \r\n</p>\r\n<div class=\"cnblogs_code\" style=\"border:1px solid #CCCCCC;padding:5px;margin:5px 0px;text-align:justify;font-family:\'Courier New\' !important;background-color:#F5F5F5;\">\r\n<pre><span style=\"color:#0000FF;line-height:1.5 !important;\">&lt;</span><span style=\"color:#800000;line-height:1.5 !important;\">div </span><span style=\"color:#FF0000;line-height:1.5 !important;\">id</span><span style=\"color:#0000FF;line-height:1.5 !important;\">=\"file_upload\"</span><span style=\"color:#0000FF;line-height:1.5 !important;\">&gt;<!--<span style=\"color:#800000;line-height:1.5 !important;\">div</span><span style=\"color:#0000FF;line-height:1.5 !important;\">></span></span></pre>\r\n</div>\r\n<p style=\"color:#303030;font-family:Verdana, Helvetica, Arial;text-align:justify;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"color:#303030;font-family:Verdana, Helvetica, Arial;text-align:justify;background-color:#FFFFFF;\">\r\n	html部分很简单，预留一个hook后，插件会在这个节点内部创建Flash的object，并且还附带创建了上传进度、取消控件和多文件队列展示等界面。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<div class=\"cnblogs_code_toolbar\">\r\n	<br />\r\n</div>\r\n<p>\r\n	<img src=\"https://ss0.baidu.com/73x1bjeh1BF3odCf/it/u=346064221,1367487355&fm=85&s=A92EE412113B70291CC500DA020090F2\" alt=\"\" /> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n--></span></pre>\r\n	</div>', '0', '1', null, null, '0', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for `cms_download_url`
-- ----------------------------
DROP TABLE IF EXISTS `cms_download_url`;
CREATE TABLE `cms_download_url` (
  `id` int(11) NOT NULL,
  `sitename` varchar(100) DEFAULT NULL,
  `durl` varchar(255) NOT NULL,
  `downloads` int(11) NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_download_url
-- ----------------------------
INSERT INTO `cms_download_url` VALUES ('7', '网盘下载', 'http://page49.ctfile.com/fs/Yk7147644036', '0', '1');
INSERT INTO `cms_download_url` VALUES ('30', '百度网盘', 'http://www.baidu.com', '0', '1');
INSERT INTO `cms_download_url` VALUES ('28', '测试地址', 'http://www.baidu.com', '0', '2');
INSERT INTO `cms_download_url` VALUES ('28', '百度网盘', 'http://pan.baidu.com', '0', '1');

-- ----------------------------
-- Table structure for `cms_group`
-- ----------------------------
DROP TABLE IF EXISTS `cms_group`;
CREATE TABLE `cms_group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `title` varchar(50) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_group
-- ----------------------------
INSERT INTO `cms_group` VALUES ('4', 'article', '内容管理', '1222841259', '1222841259', '1', '2');
INSERT INTO `cms_group` VALUES ('1', 'system', '系统设置', '1222841259', '1222841259', '1', '100');
INSERT INTO `cms_group` VALUES ('8', 'member', '会员管理', '0', '0', '1', '98');
INSERT INTO `cms_group` VALUES ('9', 'home', '起始页', '0', '1341386748', '1', '0');
INSERT INTO `cms_group` VALUES ('31', 'attribute', '自定义属性', '0', '0', '1', '8');
INSERT INTO `cms_group` VALUES ('29', 'download', '下载管理', '0', '0', '1', '4');
INSERT INTO `cms_group` VALUES ('30', 'catalog', '栏目管理', '0', '0', '1', '10');
INSERT INTO `cms_group` VALUES ('32', 'album', '相册管理', '0', '0', '1', '6');
INSERT INTO `cms_group` VALUES ('33', 'custom', '合作管理', '0', '0', '1', '96');

-- ----------------------------
-- Table structure for `cms_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `cms_keyword`;
CREATE TABLE `cms_keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_keyword
-- ----------------------------
INSERT INTO `cms_keyword` VALUES ('1', 'java8');

-- ----------------------------
-- Table structure for `cms_language`
-- ----------------------------
DROP TABLE IF EXISTS `cms_language`;
CREATE TABLE `cms_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_language
-- ----------------------------
INSERT INTO `cms_language` VALUES ('1', 'java');
INSERT INTO `cms_language` VALUES ('2', 'c#');
INSERT INTO `cms_language` VALUES ('3', 'php');
INSERT INTO `cms_language` VALUES ('4', 'javascript');

-- ----------------------------
-- Table structure for `cms_node`
-- ----------------------------
DROP TABLE IF EXISTS `cms_node`;
CREATE TABLE `cms_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `action` varchar(255) NOT NULL,
  `action_name` varchar(50) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `auth_type` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned DEFAULT '0',
  `often` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不常用 1-常用',
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不常用 1-常用',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `module` (`module`),
  KEY `auth_type` (`auth_type`),
  KEY `is_show` (`is_show`),
  KEY `group_id` (`group_id`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=168 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_node
-- ----------------------------
INSERT INTO `cms_node` VALUES ('2', 'Node', '菜单管理', 'index', '菜单列表', '', '1', '', '96', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('7', 'Role', '角色管理', 'index', '角色管理', '', '1', '', '92', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('166', 'Download', '下载管理', 'add', '发布下载', '', '1', '', '0', '1', '29', '0', '0');
INSERT INTO `cms_node` VALUES ('13', 'Admin', '管理员管理', 'index', '管理员列表', '', '1', '', '94', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('50', 'Setting', '网站设置', 'index', '站点设置', '', '1', '', '100', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('165', 'Setting', '网站设置', '', '', '', '1', '', '100', '0', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('100', 'Flink', '友链管理', 'index', '友链列表', '', '1', '', '100', '1', '33', '0', '0');
INSERT INTO `cms_node` VALUES ('102', 'Article', '资讯管理', 'index', '资讯列表', '', '1', '', '0', '1', '4', '0', '0');
INSERT INTO `cms_node` VALUES ('103', 'Article', '资讯管理', 'add', '添加资讯', '', '1', '', '0', '1', '4', '0', '0');
INSERT INTO `cms_node` VALUES ('106', 'Article', '资讯管理', 'delete', '删除资讯', '', '1', '', '0', '2', '4', '0', '0');
INSERT INTO `cms_node` VALUES ('135', 'SellerCate', '商家分类管理', '', '', '', '1', '', '0', '0', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('136', 'SellerCate', '商家分类管理', 'index', '分类列表', '', '1', '', '0', '1', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('137', 'SellerCate', '商家分类管理', 'add', '增加分类', '', '1', '', '0', '2', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('126', 'Public', '起始页', '', '', '', '1', '', '0', '0', '9', '0', '0');
INSERT INTO `cms_node` VALUES ('127', 'Public', '起始页', 'main', '后台首页', '', '1', '', '0', '1', '9', '0', '0');
INSERT INTO `cms_node` VALUES ('129', 'Group', '栏目管理', 'index', '栏目列表', '', '1', '', '98', '1', '1', '0', '0');
INSERT INTO `cms_node` VALUES ('138', 'SellerCate', '商家分类管理', 'edit', '编辑分类', '', '1', '', '0', '2', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('139', 'SellerCate', '商家分类管理', 'delete', '删除分类', '', '1', '', '0', '2', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('140', 'SellerList', '商家管理', '', '', '', '1', '', '0', '0', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('141', 'SellerList', '商家管理', 'index', '商家列表', '', '1', '', '0', '1', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('142', 'SellerList', '商家管理', 'add', '增加商家', '', '1', '', '0', '2', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('143', 'SellerList', '商家管理', 'edit', '编辑商家', '', '1', '', '0', '2', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('144', 'SellerList', '商家管理', 'delete', '删除商家', '', '1', '', '0', '2', '27', '0', '0');
INSERT INTO `cms_node` VALUES ('146', 'Adboard', '广告位置', 'index', '广告位置', '', '1', '', '98', '1', '33', '0', '0');
INSERT INTO `cms_node` VALUES ('151', 'Ad', '广告管理', 'index', '广告列表', '', '1', '', '96', '1', '33', '0', '0');
INSERT INTO `cms_node` VALUES ('156', 'User', '会员管理', 'index', '会员列表', '', '1', '', '0', '1', '8', '0', '0');
INSERT INTO `cms_node` VALUES ('158', 'Download', '下载管理', 'index', '下载列表', '', '1', '', '10', '1', '29', '0', '0');
INSERT INTO `cms_node` VALUES ('160', 'Catalog', '栏目管理', 'index', '栏目列表', '', '1', '', '90', '1', '30', '0', '0');
INSERT INTO `cms_node` VALUES ('161', 'Language', '颜色管理', 'index', '颜色列表', '', '1', '', '94', '1', '31', '0', '0');
INSERT INTO `cms_node` VALUES ('162', 'Project', '项目管理', 'index', '项目列表', '', '1', '', '98', '1', '31', '0', '0');
INSERT INTO `cms_node` VALUES ('163', 'Keyword', '标签管理', 'index', '标签列表', '', '1', '', '96', '1', '31', '0', '0');

-- ----------------------------
-- Table structure for `cms_project`
-- ----------------------------
DROP TABLE IF EXISTS `cms_project`;
CREATE TABLE `cms_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalogid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `imgurl` varchar(100) NOT NULL,
  `officialurl` varchar(255) DEFAULT NULL,
  `officialdurl` varchar(255) DEFAULT NULL,
  `addtime` int(20) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `descript` text,
  `keywordids` varchar(255) DEFAULT NULL,
  `languageid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_project
-- ----------------------------
INSERT INTO `cms_project` VALUES ('6', '0', '建筑', '1', '1', '1', '1459929682', '1', '0', '1', null, '1');
INSERT INTO `cms_project` VALUES ('11', '0', 'jquey 1.9', '', '', '', '1496545218', '1', '0', '', null, '0');

-- ----------------------------
-- Table structure for `cms_projectrelation`
-- ----------------------------
DROP TABLE IF EXISTS `cms_projectrelation`;
CREATE TABLE `cms_projectrelation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attributeid` int(11) NOT NULL DEFAULT '0',
  `addtime` bigint(20) NOT NULL,
  `articleid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_projectrelation
-- ----------------------------
INSERT INTO `cms_projectrelation` VALUES ('6', '6', '1459929682', '28');
INSERT INTO `cms_projectrelation` VALUES ('11', '6', '0', '1');
INSERT INTO `cms_projectrelation` VALUES ('15', '6', '1496545189', '29');
INSERT INTO `cms_projectrelation` VALUES ('14', '6', '1496545178', '30');
INSERT INTO `cms_projectrelation` VALUES ('17', '11', '1496545267', '7');

-- ----------------------------
-- Table structure for `cms_role`
-- ----------------------------
DROP TABLE IF EXISTS `cms_role`;
CREATE TABLE `cms_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_role
-- ----------------------------
INSERT INTO `cms_role` VALUES ('1', '管理员', '1', '管理员1', '1208784792', '1254325558');
INSERT INTO `cms_role` VALUES ('2', '编辑', '1', '编辑', '1208784792', '1254325558');

-- ----------------------------
-- Table structure for `cms_setting`
-- ----------------------------
DROP TABLE IF EXISTS `cms_setting`;
CREATE TABLE `cms_setting` (
  `name` varchar(100) NOT NULL,
  `data` text NOT NULL,
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_setting
-- ----------------------------
INSERT INTO `cms_setting` VALUES ('site_name', 'CMS站点');
INSERT INTO `cms_setting` VALUES ('site_title', 'findide 最纯净的开发工具下载站！');
INSERT INTO `cms_setting` VALUES ('site_keyword', 'findide开发工具下载');
INSERT INTO `cms_setting` VALUES ('site_description', 'findide致力于源码、工具、资源、文档');
INSERT INTO `cms_setting` VALUES ('site_status', '0');
INSERT INTO `cms_setting` VALUES ('site_icp', '京ICP备88888888号');
INSERT INTO `cms_setting` VALUES ('statistics_code', '');
INSERT INTO `cms_setting` VALUES ('closed_reason', 'welcome to findide.com');
INSERT INTO `cms_setting` VALUES ('site_domain', 'http://www.findide.com');
INSERT INTO `cms_setting` VALUES ('weibo_url', 'http://www.weibo.com');
INSERT INTO `cms_setting` VALUES ('qqzone_url', '');
INSERT INTO `cms_setting` VALUES ('douban_url', '');
INSERT INTO `cms_setting` VALUES ('attachment_size', '3145728');
INSERT INTO `cms_setting` VALUES ('template', 'default');
INSERT INTO `cms_setting` VALUES ('taobao_app_key', '12504724');
INSERT INTO `cms_setting` VALUES ('qq_app_key', '');
INSERT INTO `cms_setting` VALUES ('qq_app_Secret', '');
INSERT INTO `cms_setting` VALUES ('sina_app_key', '100308089');
INSERT INTO `cms_setting` VALUES ('sina_app_Secret', '25ee4d31ca98edea230885985e1cf2e1');
INSERT INTO `cms_setting` VALUES ('taobao_app_secret', '9d6877190386092d4288dcae32811081');
INSERT INTO `cms_setting` VALUES ('url_model', '0');
INSERT INTO `cms_setting` VALUES ('attachment_path', 'data/uploads');
INSERT INTO `cms_setting` VALUES ('client_hash', '');
INSERT INTO `cms_setting` VALUES ('attachment_type', 'jpg,gif,png,jpeg');
INSERT INTO `cms_setting` VALUES ('miao_appkey', '1003336');
INSERT INTO `cms_setting` VALUES ('miao_appsecret', '0847c5008f99150de65fad8e8ec342fa');
INSERT INTO `cms_setting` VALUES ('mail_smtp', 'smtp.163.com');
INSERT INTO `cms_setting` VALUES ('mail_username', 'ho1000003@163.com\r\nho1000004@163.com\r\nho1000005@163.com\r\nhml100000@163.com');
INSERT INTO `cms_setting` VALUES ('mail_password', 'PassWord01!');
INSERT INTO `cms_setting` VALUES ('mail_port', '25');
INSERT INTO `cms_setting` VALUES ('mail_fromname', 'MobileCms');
INSERT INTO `cms_setting` VALUES ('check_code', '0');
INSERT INTO `cms_setting` VALUES ('comment_time', '10');
INSERT INTO `cms_setting` VALUES ('site_share', '');
INSERT INTO `cms_setting` VALUES ('ban_sipder', 'youdaobot|bingbot');
INSERT INTO `cms_setting` VALUES ('ban_ip', '192.168.1.50');
INSERT INTO `cms_setting` VALUES ('site_logo', './data/setting/597bd23ccf1de.JPG');
INSERT INTO `cms_setting` VALUES ('article_count', '20');
INSERT INTO `cms_setting` VALUES ('html_suffix', '.html');
INSERT INTO `cms_setting` VALUES ('mail_username', 'ho1000003@163.com\r\nho1000004@163.com\r\nho1000005@163.com\r\nhml100000@163.com');
INSERT INTO `cms_setting` VALUES ('mail_receive_username', '');
INSERT INTO `cms_setting` VALUES ('mail_content', '<body style=\\\"margin: 10px;\\\">\r\n<div align=\\\"center\\\"><img src=\\\"http://www.phonegap100.com/static/image/common/logo.png\\\"></div><br>\r\n<br>\r\n <h3>欢迎使用 树根cms 此系统由phonegap中文网 <a href=\\\"http://www.phonegap100.com\\\" target=\\\"_blank\\\">phonegap100.com</a>提供 </h3>\r\n<br>\r\n\r\n在使用中遇到任何问题，请到phonegap中文网提出，感谢大家对此程序的支持，我们的qq群：295402925\r\n\r\n</body>');
INSERT INTO `cms_setting` VALUES ('mail_title', '欢迎使用树根cms，这是一封感谢信');
INSERT INTO `cms_setting` VALUES ('site_name', 'CMS站点');
INSERT INTO `cms_setting` VALUES ('site_title', 'findide 最纯净的开发工具下载站！');
INSERT INTO `cms_setting` VALUES ('site_keyword', 'findide开发工具下载');
INSERT INTO `cms_setting` VALUES ('site_description', 'findide致力于源码、工具、资源、文档');
INSERT INTO `cms_setting` VALUES ('site_status', '0');
INSERT INTO `cms_setting` VALUES ('site_icp', '京ICP备88888888号');
INSERT INTO `cms_setting` VALUES ('statistics_code', '');
INSERT INTO `cms_setting` VALUES ('closed_reason', 'welcome to findide.com');
INSERT INTO `cms_setting` VALUES ('site_domain', 'http://www.findide.com');
INSERT INTO `cms_setting` VALUES ('weibo_url', 'http://www.weibo.com');
INSERT INTO `cms_setting` VALUES ('qqzone_url', '');
INSERT INTO `cms_setting` VALUES ('douban_url', '');
INSERT INTO `cms_setting` VALUES ('attachment_size', '3145728');
INSERT INTO `cms_setting` VALUES ('template', 'default');
INSERT INTO `cms_setting` VALUES ('taobao_app_key', '12504724');
INSERT INTO `cms_setting` VALUES ('qq_app_key', '');
INSERT INTO `cms_setting` VALUES ('qq_app_Secret', '');
INSERT INTO `cms_setting` VALUES ('sina_app_key', '100308089');
INSERT INTO `cms_setting` VALUES ('sina_app_Secret', '25ee4d31ca98edea230885985e1cf2e1');
INSERT INTO `cms_setting` VALUES ('taobao_app_secret', '9d6877190386092d4288dcae32811081');
INSERT INTO `cms_setting` VALUES ('url_model', '0');
INSERT INTO `cms_setting` VALUES ('attachment_path', 'data/uploads');
INSERT INTO `cms_setting` VALUES ('client_hash', '');
INSERT INTO `cms_setting` VALUES ('attachment_type', 'jpg,gif,png,jpeg');
INSERT INTO `cms_setting` VALUES ('miao_appkey', '1003336');
INSERT INTO `cms_setting` VALUES ('miao_appsecret', '0847c5008f99150de65fad8e8ec342fa');
INSERT INTO `cms_setting` VALUES ('mail_smtp', 'smtp.163.com');
INSERT INTO `cms_setting` VALUES ('mail_username', 'ho1000003@163.com\r\nho1000004@163.com\r\nho1000005@163.com\r\nhml100000@163.com');
INSERT INTO `cms_setting` VALUES ('mail_password', 'PassWord01!');
INSERT INTO `cms_setting` VALUES ('mail_port', '25');
INSERT INTO `cms_setting` VALUES ('mail_fromname', 'MobileCms');
INSERT INTO `cms_setting` VALUES ('check_code', '0');
INSERT INTO `cms_setting` VALUES ('comment_time', '10');
INSERT INTO `cms_setting` VALUES ('site_share', '');
INSERT INTO `cms_setting` VALUES ('ban_sipder', 'youdaobot|bingbot');
INSERT INTO `cms_setting` VALUES ('ban_ip', '192.168.1.50');
INSERT INTO `cms_setting` VALUES ('site_logo', './data/setting/597bd23ccf1de.JPG');
INSERT INTO `cms_setting` VALUES ('article_count', '20');
INSERT INTO `cms_setting` VALUES ('html_suffix', '.html');
INSERT INTO `cms_setting` VALUES ('mail_username', 'ho1000003@163.com\r\nho1000004@163.com\r\nho1000005@163.com\r\nhml100000@163.com');
INSERT INTO `cms_setting` VALUES ('mail_receive_username', '');
INSERT INTO `cms_setting` VALUES ('mail_content', '<body style=\\\"margin: 10px;\\\">\r\n<div align=\\\"center\\\"><img src=\\\"http://www.phonegap100.com/static/image/common/logo.png\\\"></div><br>\r\n<br>\r\n <h3>欢迎使用 树根cms 此系统由phonegap中文网 <a href=\\\"http://www.phonegap100.com\\\" target=\\\"_blank\\\">phonegap100.com</a>提供 </h3>\r\n<br>\r\n\r\n在使用中遇到任何问题，请到phonegap中文网提出，感谢大家对此程序的支持，我们的qq群：295402925\r\n\r\n</body>');
INSERT INTO `cms_setting` VALUES ('mail_title', '欢迎使用树根cms，这是一封感谢信');
