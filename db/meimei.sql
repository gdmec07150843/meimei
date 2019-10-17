/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : meimei

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-10-17 10:08:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for aaz_adminuser
-- ----------------------------
DROP TABLE IF EXISTS `aaz_adminuser`;
CREATE TABLE `aaz_adminuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '账号',
  `password` char(64) NOT NULL COMMENT '密码',
  `creat_time` int(20) NOT NULL COMMENT '创建时间',
  `last_login_ip` varchar(50) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` int(20) unsigned DEFAULT NULL COMMENT '最后登录时间',
  `grade` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '等级;1:超级管理员;2:管理员',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:正常;2:下线',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台管理员表';

-- ----------------------------
-- Records of aaz_adminuser
-- ----------------------------
INSERT INTO `aaz_adminuser` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1563420480', '127.0.0.1', '1571193540', '1', '1');
INSERT INTO `aaz_adminuser` VALUES ('2', 'test', '202cb962ac59075b964b07152d234b70', '1563420482', null, null, '2', '1');

-- ----------------------------
-- Table structure for aaz_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `aaz_admin_menu`;
CREATE TABLE `aaz_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `app` varchar(15) NOT NULL DEFAULT '' COMMENT '应用名',
  `controller` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action` varchar(30) NOT NULL DEFAULT '' COMMENT '操作名称',
  `path` varchar(50) NOT NULL COMMENT '分类路径',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `parentid` (`parent_id`) USING BTREE,
  KEY `model` (`controller`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台菜单表';

-- ----------------------------
-- Records of aaz_admin_menu
-- ----------------------------
INSERT INTO `aaz_admin_menu` VALUES ('4', '管理员管理', '0', 'admin', 'adminuser', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('5', '管理员列表', '4', 'admin', 'adminuser', 'index', '0,4,');
INSERT INTO `aaz_admin_menu` VALUES ('6', '添加管理员', '4', 'admin', 'adminuser', 'add', '0,4,');
INSERT INTO `aaz_admin_menu` VALUES ('7', '用户管理', '0', 'admin', 'user', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('8', '用户列表', '7', 'admin', 'user', 'index', '0,7,');
INSERT INTO `aaz_admin_menu` VALUES ('9', '约会管理', '0', 'admin', 'dating', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('10', '活动管理', '0', 'admin', '', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('11', '排行榜管理', '0', 'admin', 'ranking', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('12', '财务管理', '0', 'admin', 'finance', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('13', '基础设置', '0', 'admin', 'setting', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('14', '官方客服管理', '0', 'admin', '', 'default', '0,');
INSERT INTO `aaz_admin_menu` VALUES ('16', '帮助中心', '13', 'admin', 'setting', 'index', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('17', '新手指引', '13', 'admin', 'setting', 'guideindex', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('18', '用户注册协议', '13', 'admin', 'setting', 'agreement', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('19', '建议反馈', '13', 'admin', 'setting', 'feedback', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('20', '功能设置', '13', 'admin', 'setting', 'features', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('21', '基础图片设置', '13', 'admin', 'setting', 'basicpic', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('22', '基础文案设置', '13', 'admin', 'setting', 'basiccopy', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('23', '礼物列表', '13', 'admin', 'setting', 'gift', '0,13,');
INSERT INTO `aaz_admin_menu` VALUES ('24', '异性直约', '9', 'admin', 'dating', 'heterosexual', '0,9,');
INSERT INTO `aaz_admin_menu` VALUES ('25', '同城约玩', '9', 'admin', 'dating', 'samecity', '0,9,');
INSERT INTO `aaz_admin_menu` VALUES ('26', '附近服务', '9', 'admin', 'dating', 'near', '0,9,');
INSERT INTO `aaz_admin_menu` VALUES ('27', '静夜寻聊', '9', 'admin', 'dating', 'nightchat', '0,9,');
INSERT INTO `aaz_admin_menu` VALUES ('28', '提现审核', '12', 'admin', 'finance', 'index', '0,12,');
INSERT INTO `aaz_admin_menu` VALUES ('29', '直约配对榜', '11', 'admin', 'ranking', 'matchinglist', '0,11,');
INSERT INTO `aaz_admin_menu` VALUES ('30', 'PC榜', '11', 'admin', 'ranking', 'pclist', '0,11,');

-- ----------------------------
-- Table structure for aaz_asset
-- ----------------------------
DROP TABLE IF EXISTS `aaz_asset`;
CREATE TABLE `aaz_asset` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `file_size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小,单位B',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:可用,0:不可用',
  `download_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `file_key` varchar(64) NOT NULL DEFAULT '' COMMENT '文件惟一码',
  `filename` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `file_path` varchar(100) NOT NULL DEFAULT '' COMMENT '文件路径,相对于upload目录,可以为url',
  `file_md5` varchar(32) NOT NULL DEFAULT '' COMMENT '文件md5值',
  `file_sha1` varchar(40) NOT NULL DEFAULT '',
  `suffix` varchar(10) NOT NULL DEFAULT '' COMMENT '文件后缀名,不包括点',
  `more` text COMMENT '其它详细信息,JSON格式',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=395 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='资源表';

-- ----------------------------
-- Records of aaz_asset
-- ----------------------------
INSERT INTO `aaz_asset` VALUES ('350', '1', '481898', '1558616937', '1', '0', '5eca0469be9349c0b8cfc6ec43058e82545869bb41dc1d09f33b04f18f8c0bbd', 'p_04.jpg', '20190523/485e313296c3b10ac3d7c1745874a38a.jpg', '5eca0469be9349c0b8cfc6ec43058e82', 'd2b7294a5b522b337fa4a78b43b646a916d1e818', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('351', '1', '496164', '1558617574', '1', '0', 'ec6bada8f3203df97c6316acb69a74f3141895d8c61307f5b513175bd242ee33', 'p_03.jpg', '20190523/2e6315bdb803209baf24610e89594775.jpg', 'ec6bada8f3203df97c6316acb69a74f3', 'e866525758da5ad56fa3428d4058220b67725cea', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('352', '1', '372043', '1558618944', '1', '0', '365f09c1d7b78aa3735037099f0401adfb4e76a0003cdbc5339c81ae35c47623', 'p_02.jpg', '20190523/fee86a64c2b80b06da9dd4224dcf7a6f.jpg', '365f09c1d7b78aa3735037099f0401ad', 'ec497775810abdce0ad9a56d80d090380259be0d', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('353', '1', '129715', '1558620094', '1', '0', '7efcb91ab3742e67869e8dd6adda634f517ab3d510f37a4a83cb16a2fe07c5bd', 'cover@big.jpg', '20190523/cc77184eb2ddefcec17e06b5cc71285f.jpg', '7efcb91ab3742e67869e8dd6adda634f', '8e7e5e0ea242260fd591895885e98ce1a5be7dce', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('354', '1', '331582', '1558620099', '1', '0', '774d85eae8f18b5239237556a546190553c2316a0f568647d146e87e5fb2d356', 'end.jpg', '20190523/e8678a55899623c3c1240b91a5bebac9.jpg', '774d85eae8f18b5239237556a5461905', '9044b878ebf32a89efff5569e972cb86c65a8998', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('355', '1', '90452', '1559036568', '1', '0', 'd8d573328f0b7b16de0f07c192991593a5120d862ea7d015c547a65c73c90d39', '图层25@2x.png', '20190528/7791c0f9469a1061bf725f6b6544df0c.png', 'd8d573328f0b7b16de0f07c192991593', 'dd6020acd5a926edc410818846859357b3fa442d', 'png', null);
INSERT INTO `aaz_asset` VALUES ('356', '1', '87811', '1559036628', '1', '0', '63ad941b49eda5bf8db629ea9938112309df0415121e6b56e0706b18b55deeb7', '图层24@2x.png', '20190528/578bac77b1791060693c5ae3169e496b.png', '63ad941b49eda5bf8db629ea99381123', '7e2a4fc0d09275f96535df7f40a360d96be92465', 'png', null);
INSERT INTO `aaz_asset` VALUES ('357', '1', '53607', '1559110799', '1', '0', '100f893f961693cab7ecd20147aef40d34a2a62fb69d0338d816b007a821becf', '图层18@2x.png', '20190529/57c871fb94f3c73d10d66db9c1984d2a.png', '100f893f961693cab7ecd20147aef40d', '77669c06eba768cc7962193e3e4771eea5d5da34', 'png', null);
INSERT INTO `aaz_asset` VALUES ('358', '1', '51106', '1559110891', '1', '0', '8b1cbacb2c932e20d4469f62b1f344824c06cf214e451a2a721a893985e24cb2', '图层19@2x.png', '20190529/19fad276705e76a989962da534e1bd71.png', '8b1cbacb2c932e20d4469f62b1f34482', '816c94a5a0437957795d06078e8c6a70619f2078', 'png', null);
INSERT INTO `aaz_asset` VALUES ('359', '1', '36582', '1559111274', '1', '0', 'eb63c8f5c6645de68d4a8703de5302ca3f5378f54d5ff98d45e086af38cebb0d', '图层20@2x.png', '20190529/cf0ea7dfcf1c13cb710ac0632bd2dcfe.png', 'eb63c8f5c6645de68d4a8703de5302ca', '7f6f138ec1574ede23fa8b8b8561b487df08775d', 'png', null);
INSERT INTO `aaz_asset` VALUES ('360', '1', '43383', '1559111380', '1', '0', '480d4f174b20e93ac745a3608f8522ca6c31fab82d257ae186a6aad9ce5cb158', '图层21@2x.png', '20190529/8ee0fbca2cad8e7d88e4e0aa9c16afa3.png', '480d4f174b20e93ac745a3608f8522ca', 'e3385eec48c867623e9f8d47f4f3ac0225e5deac', 'png', null);
INSERT INTO `aaz_asset` VALUES ('361', '1', '32681', '1559187978', '1', '0', 'cb44894fed6ecd84cb1b64e9b86b43e3fb8996615569fd718a32680d16d960bb', '图层23@2x.png', '20190530/953e8bbda23fed21b6beb59999094a89.png', 'cb44894fed6ecd84cb1b64e9b86b43e3', '3ae8c0b834a0cf81f1472c1c4c5edc9ee7feed6d', 'png', null);
INSERT INTO `aaz_asset` VALUES ('362', '1', '41597', '1559188031', '1', '0', '9c6f280404f7740053b0f27be39789ef16ab6a8fa34538cdfd3770b967f31488', '图层22@2x.png', '20190530/a1183a63f0d34f020da49620bb89c9f1.png', '9c6f280404f7740053b0f27be39789ef', '5a28d34ff572a5719037acbbf04c4899e04f949f', 'png', null);
INSERT INTO `aaz_asset` VALUES ('363', '1', '3851', '1559190007', '1', '0', 'cd024d0e19d86116d2f9514e29fe4cd73227e5dc2cdacb83d5f846d50a9b3432', '1.png', '20190530/f48ffccffafd536b71560ae3b3c28376.png', 'cd024d0e19d86116d2f9514e29fe4cd7', 'e5d01bb00947ba64f0838b6b65ebe5b8eb5b38c6', 'png', null);
INSERT INTO `aaz_asset` VALUES ('364', '1', '561276', '1563200933', '1', '0', '8969288f4245120e7c3870287cce0ff3f7d51bb925fe6e8387923d3a96b99a9d', 'Lighthouse.jpg', '20190715/e3a8496d39975d4cfd097f23a88d29eb.jpg', '8969288f4245120e7c3870287cce0ff3', '1b4605b0e20ceccf91aa278d10e81fad64e24e27', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('365', '1', '24', '1563525874', '1', '0', 'fcefb4a07a2eac3fa33ac37d1fe7ca40e11d570e2dc587d34e54042f1483b89e', '新建文本文档.txt', '20190719/3a8cf3698f20b3a2367bcc878b89da0b.txt', 'fcefb4a07a2eac3fa33ac37d1fe7ca40', '8fe22ef38252b630bde793327abfe49177080598', 'txt', null);
INSERT INTO `aaz_asset` VALUES ('366', '1', '355400', '1569581250', '1', '0', '4766d1b37c5a1dbbdc88e6ae04669c4f65d64d297394e4e4d1b6bd2cfa06678b', '时崎狂三(2).jpg', '20190927/d34e982fec2324a79cdcc8c667951d4b.jpg', '4766d1b37c5a1dbbdc88e6ae04669c4f', '6d47f2956f397bdb6cdd0a0f63986a9a4acbb56c', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('367', '1', '743702', '1569581371', '1', '0', '46ff8715ce3045ae9b4499ae28d5f0b0a3ad7a76c4d43fefc1795c315c046cae', '五河琴里.jpg', '20190927/2343423321d9b343797da9dfc834f6e9.jpg', '46ff8715ce3045ae9b4499ae28d5f0b0', '1caeb7fb93280c89ce1ec1215865667cc313d2c2', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('368', '1', '124512', '1569652624', '1', '0', '27a77726a76cacddb042633e6f34e3fc84e3f57d2fa14c42d41b04cac851940b', '四糸乃.jpg', '20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '27a77726a76cacddb042633e6f34e3fc', 'e08904c0bd5a5c85256fd43d20bda4ca923762b2', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('369', '1', '347330', '1569741501', '1', '0', '22ed47bf78f83871120de2696438f06c76787bd015e71f2fbe39c79f8353e028', '时崎狂三.jpg', '20190929/906429e566ddedd7936211e8a8b6dadf.jpg', '22ed47bf78f83871120de2696438f06c', '63242524feb7ade8cd883444ba2411c8981b0af5', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('370', '1', '350078', '1569812327', '1', '0', '651e27e9ba46673f08e293ce48f32cb0a904ff23114ea566a4705f569c61375c', '咖啡.png', '20190930/cc3a80fc838c5b100852bd5620233504.png', '651e27e9ba46673f08e293ce48f32cb0', 'db17164d89ac48453e574cfb86020edd40d1bded', 'png', null);
INSERT INTO `aaz_asset` VALUES ('371', '1', '607971', '1569814114', '1', '0', '94a951e364a1013acfd44ec2b245f10fc9b4f6e6c395bb877b7b0e7ec5a04dcb', '可乐.png', '20190930/b6bfe1548702c7756958fe395f7c1389.png', '94a951e364a1013acfd44ec2b245f10f', '1751710ea098f8c7b17d31da9cbe08ac47f63410', 'png', null);
INSERT INTO `aaz_asset` VALUES ('372', '1', '300013', '1569814309', '1', '0', 'c6408960fc7f786a932490cf5f0e574f1620132739c752558643ce939098a077', '雪碧.png', '20190930/6244b1dcefe2730347874c3cfbbc74f8.png', 'c6408960fc7f786a932490cf5f0e574f', '769a4aa872b5c4c3ab01ee2b2dff844d66d26d0e', 'png', null);
INSERT INTO `aaz_asset` VALUES ('373', '1', '248400', '1569814801', '1', '0', 'e56b48890d0fcee444b0bac19dd0dd1f93b26ef822bb6cfdbda57af5e8660f09', '魅币.png', '20190930/ca1ed92637f12927ebc4361665b66894.png', 'e56b48890d0fcee444b0bac19dd0dd1f', '46f754649214c0f7ff8c65a8e10c26f8e51edf0c', 'png', null);
INSERT INTO `aaz_asset` VALUES ('374', '1', '141052', '1570706064', '1', '0', 'eff9938202e8dd36d211b65775270862b07947a0161cd9b8a04a4c13448c80c8', '123.png', '20191010/b290324f7d5b57f30034144e51b79173.png', 'eff9938202e8dd36d211b65775270862', '3ae5425080226ce352c1611080c71eac5e3fd733', 'png', null);
INSERT INTO `aaz_asset` VALUES ('375', '1', '244723', '1570706131', '1', '0', '8104c227dff82fed37eba63a95160b5cecd7632c6367a128691238a63083eeee', '诱宵九美.jpg', '20191010/eda1b4170e3a9bf8d0707ea39c8be775.jpg', '8104c227dff82fed37eba63a95160b5c', '155e155dd05f33ac21746d2c75a029529733c6a1', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('376', '1', '342508', '1570706140', '1', '0', '826a916f05a3f78e3d0156f1b828597d440bcf54b2c0c4d358c0264e288713ab', '十香.jpg', '20191010/58ab7ea3d58cf6f60c56ef958cc70277.jpg', '826a916f05a3f78e3d0156f1b828597d', '85d0b9fe8015d9cdaca5f23b6358a95cfea5da3c', 'jpg', null);
INSERT INTO `aaz_asset` VALUES ('377', '1', '368694', '1570761188', '1', '0', '482d98156404f469338f2bf7c8302c972d759108822259dd72493398df0926e9', '（青）青涩之约.png', '20191011/7a0512f2eb2592ff5b8b25c9ca46e411.png', '482d98156404f469338f2bf7c8302c97', '9870f3a76819228d092b4f43d0c5c77739da965b', 'png', null);
INSERT INTO `aaz_asset` VALUES ('378', '1', '328015', '1570761675', '1', '0', '24b99b7c7543d365a122b6e2c436fd862f1ca0a77988b332d572197985f6fbf8', '（蓝）钟情之约.png', '20191011/edc9dd6d9623b0fa3cb0bd33eabd9c4a.png', '24b99b7c7543d365a122b6e2c436fd86', 'f5c4263433837333fbf5d121ee4e91d12234daca', 'png', null);
INSERT INTO `aaz_asset` VALUES ('379', '1', '320469', '1570761694', '1', '0', '80d3404f6bef751963ca0a46f689a869154963ae6187ecc461438612b88b1def', '（橙）热恋之约.png', '20191011/174bd51c6a08e68016392c0470d9e3c9.png', '80d3404f6bef751963ca0a46f689a869', 'f4faf655d769cdc7132f5d55a2df56406675cafb', 'png', null);
INSERT INTO `aaz_asset` VALUES ('380', '1', '216598', '1570762644', '1', '0', '0ff8879e610c31239df81c2bbe8cddb6e1b371ae84fbbbe48c0e13cc00699e30', '雪碧.png', '20191011/1e9d022dd9be267cabedb9a2a1045662.png', '0ff8879e610c31239df81c2bbe8cddb6', 'cca6ccd91e56f9f746c41fdb72169c1d54bb06f0', 'png', null);
INSERT INTO `aaz_asset` VALUES ('381', '1', '182250', '1570762656', '1', '0', 'aaf290884606ad071047863c47a26ac9af96febebf3e6f173435c93c463cee21', '可乐.png', '20191011/45815fafc8468820e69c213213bee14c.png', 'aaf290884606ad071047863c47a26ac9', '60af7e1f856c8fbd20b2cc131312eae03e43ae3e', 'png', null);
INSERT INTO `aaz_asset` VALUES ('382', '1', '297899', '1570762675', '1', '0', '340db9cc19480ad9bbf90798edcfcfb0fc1459101ebfde2514d2231db6067ca0', '咖啡.png', '20191011/b428b2e87c0f3b5ae148a8538efda51e.png', '340db9cc19480ad9bbf90798edcfcfb0', '15b56745dcd93c141486e775e050b424ed7f2e81', 'png', null);
INSERT INTO `aaz_asset` VALUES ('383', '1', '145386', '1570762696', '1', '0', '4aa81a37ddedf55fa674cea96992058bb5cfec9e3942a3bd808936f69bc01875', '2青涩之约（青）.png', '20191011/8787c86ebcc4a06b2d39ec6359c777be.png', '4aa81a37ddedf55fa674cea96992058b', '418d6555a8ed04773373ddf57d58cac357ced87b', 'png', null);
INSERT INTO `aaz_asset` VALUES ('384', '1', '138269', '1570762724', '1', '0', '6c4186ee4c9508d91014379e9f24fac145e6b00e91e665a1295fd2f8ce0815cf', '3怡然之约（蓝）.png', '20191011/ad2de504ced250bf2a6abd9e73436888.png', '6c4186ee4c9508d91014379e9f24fac1', '1d9db2dc3aa55d1d3062ccebc042b9bd27b080f3', 'png', null);
INSERT INTO `aaz_asset` VALUES ('385', '1', '143047', '1570762739', '1', '0', 'ab477954517c4d900d1081680e4332f66c8750949d02db2484b249edb73f1c05', '4蜜语之约（粉）.png', '20191011/9f8cd0c0a5b59380bb01af8ff1904ea8.png', 'ab477954517c4d900d1081680e4332f6', '25687807c1716fb3912215b6f4ccfdf01554702f', 'png', null);
INSERT INTO `aaz_asset` VALUES ('386', '1', '109466', '1570778560', '1', '0', 'ee257ec9e4c581d3a5f1b12c508d2353035fb3b3371514d5a76a7ba9ee092466', '鸡尾酒58约币，兑换156.6积分，387CP好感值和魅力值.png', '20191011/9e658553649e780321b8b03112b7cad5.png', 'ee257ec9e4c581d3a5f1b12c508d2353', '97da0efc9ebf1297d78db07550bdfe686c2494f1', 'png', null);
INSERT INTO `aaz_asset` VALUES ('387', '1', '183234', '1570778590', '1', '0', 'c1478842c5756b850c65d048495617a756c1b2e13a52b486e654f603f98216aa', 'hello kitty78约币，兑换210.6积分，520CP好感值和魅力值.png', '20191011/b9c3a4f33475b7fc4bb78b7177285ccb.png', 'c1478842c5756b850c65d048495617a7', '0b708797bfa5a42cca90a9d346d1c92637648e1e', 'png', null);
INSERT INTO `aaz_asset` VALUES ('388', '1', '761190', '1570778610', '1', '0', '793fc0bcc5f715c77443af510abfad13e56606fbba2a7ff13252bd480a036b91', '表白熊108约币，兑换291.6积分，720CP好感值和魅力值.png', '20191011/1ab780418a1525b33f7974fba8cf6a71.png', '793fc0bcc5f715c77443af510abfad13', '367bbc9555fa24fdefe1d8a53de7953669613aa6', 'png', null);
INSERT INTO `aaz_asset` VALUES ('389', '1', '200295', '1570778648', '1', '0', 'ef500b1c073ade64b82c5cddf95f8b7d8d6d819ca98e13ac9a1afb72c421852d', '热情向日葵138约币，兑换372.6积分，920CP好感值和魅力值.png', '20191011/1afb540d91f95bc95cede1f848c59e1a.png', 'ef500b1c073ade64b82c5cddf95f8b7d', 'bdda39cc57c3ea0406873fef812f0a2066b56586', 'png', null);
INSERT INTO `aaz_asset` VALUES ('390', '1', '1057715', '1570778662', '1', '0', '94b2466a0130562811ecf8ca7942f1bf603937a9bdeb3f80ca5d253c10aca045', '浪漫红玫瑰288约币，777.6兑换积分，1920CP好感值和魅力值.png', '20191011/d674ec83d298c593d9b5cb0acf0fce16.png', '94b2466a0130562811ecf8ca7942f1bf', '357f021ee2183663342e7298585cdde0489ab39d', 'png', null);
INSERT INTO `aaz_asset` VALUES ('391', '1', '416671', '1570778686', '1', '0', '9ccd132b2ed41b93a675de6538584703f962308572d6c42495836ac3b63639ba', '公主手链388约币，兑换1047.6积分，2587CP好感值和魅力值.png', '20191011/1282cab5564d834251460e7aa91b53a4.png', '9ccd132b2ed41b93a675de6538584703', '9c727f6694e1392914ac4ebbbc5f6aee86ef209a', 'png', null);
INSERT INTO `aaz_asset` VALUES ('392', '1', '138035', '1570778714', '1', '0', '7a477634cd07b035470ceb2c46ec24da388a06fbcc4887c7091a241ee53ee969', '情人戒指520约币，兑换1404积分，3467CP好感值和魅力值.png', '20191011/fce473036399cd56a043a8859499bfa1.png', '7a477634cd07b035470ceb2c46ec24da', '456723027fd2573cfd25a5f37faf04eafbf417b6', 'png', null);
INSERT INTO `aaz_asset` VALUES ('393', '1', '260611', '1570778737', '1', '0', 'ac9407e53ad0a9d21ee72ea1006a4ca0a922385889a6591ceb47ab9a9cc4eff4', '永驻我心888约币，兑换2397.6积分，5920CP好感值和魅力值.png', '20191011/7706e00c1e12d2e3e6b38ad7a735c871.png', 'ac9407e53ad0a9d21ee72ea1006a4ca0', '39e46c97424ff1982d01602ad34541148102c95e', 'png', null);
INSERT INTO `aaz_asset` VALUES ('394', '1', '288907', '1570778749', '1', '0', 'd264d7c851bb0fb7ca1aa1852aaa2970d7d49074b52bdbcb7bc37781f0ff4a75', '心心相印1314约币，兑换3547.8积分，8760CP好感值和魅力值.png', '20191011/12dfdd2f41f25308d16aed71e736f0b9.png', 'd264d7c851bb0fb7ca1aa1852aaa2970', '172cbb0f5c918cb2b6ad13bfb3a2a065ecba742f', 'png', null);

-- ----------------------------
-- Table structure for aaz_auth_access
-- ----------------------------
DROP TABLE IF EXISTS `aaz_auth_access`;
CREATE TABLE `aaz_auth_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL COMMENT '管理员id',
  `menu_id` int(10) unsigned NOT NULL COMMENT '菜单id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='权限授权表';

-- ----------------------------
-- Records of aaz_auth_access
-- ----------------------------

-- ----------------------------
-- Table structure for aaz_basiccopy
-- ----------------------------
DROP TABLE IF EXISTS `aaz_basiccopy`;
CREATE TABLE `aaz_basiccopy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '分项',
  `content` text COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='基础文案设置';

-- ----------------------------
-- Records of aaz_basiccopy
-- ----------------------------
INSERT INTO `aaz_basiccopy` VALUES ('1', '寻聊玩法', '玩法');
INSERT INTO `aaz_basiccopy` VALUES ('2', '寻聊提成介绍', '寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍寻聊提成介绍');

-- ----------------------------
-- Table structure for aaz_basicpic
-- ----------------------------
DROP TABLE IF EXISTS `aaz_basicpic`;
CREATE TABLE `aaz_basicpic` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '分项',
  `img1` varchar(100) DEFAULT NULL,
  `img2` varchar(100) DEFAULT NULL,
  `img3` varchar(100) DEFAULT NULL,
  `img4` varchar(100) DEFAULT NULL,
  `img5` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='基础图片设置\r\n';

-- ----------------------------
-- Records of aaz_basicpic
-- ----------------------------
INSERT INTO `aaz_basicpic` VALUES ('1', '指引页', '/upload/20190929/906429e566ddedd7936211e8a8b6dadf.jpg', '/upload/20191010/b290324f7d5b57f30034144e51b79173.png', '/upload/20190927/2343423321d9b343797da9dfc834f6e9.jpg', null, null);
INSERT INTO `aaz_basicpic` VALUES ('2', '登录页', '/upload/20191010/b290324f7d5b57f30034144e51b79173.png', null, null, null, null);
INSERT INTO `aaz_basicpic` VALUES ('3', '新手指引', '/upload/20191010/b290324f7d5b57f30034144e51b79173.png', null, null, null, null);
INSERT INTO `aaz_basicpic` VALUES ('4', 'vip', '/upload/20190927/d34e982fec2324a79cdcc8c667951d4b.jpg', '/upload/20191010/eda1b4170e3a9bf8d0707ea39c8be775.jpg', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '/upload/20191010/58ab7ea3d58cf6f60c56ef958cc70277.jpg', '/upload/20190927/2343423321d9b343797da9dfc834f6e9.jpg');

-- ----------------------------
-- Table structure for aaz_collection
-- ----------------------------
DROP TABLE IF EXISTS `aaz_collection`;
CREATE TABLE `aaz_collection` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `nid` int(10) DEFAULT NULL COMMENT '附近服务id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='点赞表';

-- ----------------------------
-- Records of aaz_collection
-- ----------------------------

-- ----------------------------
-- Table structure for aaz_datinglist
-- ----------------------------
DROP TABLE IF EXISTS `aaz_datinglist`;
CREATE TABLE `aaz_datinglist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `hid` int(10) DEFAULT NULL COMMENT '异性直约id',
  `datingtime` int(11) DEFAULT NULL COMMENT '约会时间',
  `address` varchar(255) DEFAULT NULL COMMENT '约会地址',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态;1:待操作;2:接受;3:拒绝',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='邀约列表';

-- ----------------------------
-- Records of aaz_datinglist
-- ----------------------------
INSERT INTO `aaz_datinglist` VALUES ('1', '2', '1', '1570866482', '广州天河', '1', '1570866482');
INSERT INTO `aaz_datinglist` VALUES ('2', '4', '1', '1570866482', '广州天河', '1', '1570866482');

-- ----------------------------
-- Table structure for aaz_features
-- ----------------------------
DROP TABLE IF EXISTS `aaz_features`;
CREATE TABLE `aaz_features` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '分项',
  `status` tinyint(2) DEFAULT NULL COMMENT '状态；1开启 2关闭',
  `num` int(10) DEFAULT NULL COMMENT '人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='功能设置';

-- ----------------------------
-- Records of aaz_features
-- ----------------------------
INSERT INTO `aaz_features` VALUES ('1', '礼金直约、同城约玩倒计时', '1', null);
INSERT INTO `aaz_features` VALUES ('2', '定位屏蔽功能', '2', null);
INSERT INTO `aaz_features` VALUES ('3', '排行榜显示数量', '1', null);
INSERT INTO `aaz_features` VALUES ('4', '排行榜查看头像详情', '2', null);
INSERT INTO `aaz_features` VALUES ('5', '寻聊优先功能', '1', null);
INSERT INTO `aaz_features` VALUES ('6', '当前永久VIP人数', null, '1000');

-- ----------------------------
-- Table structure for aaz_feedback
-- ----------------------------
DROP TABLE IF EXISTS `aaz_feedback`;
CREATE TABLE `aaz_feedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `pic` varchar(255) DEFAULT NULL COMMENT '图片',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='反馈建议表';

-- ----------------------------
-- Records of aaz_feedback
-- ----------------------------
INSERT INTO `aaz_feedback` VALUES ('2', '1', '/upload/20190927/d34e982fec2324a79cdcc8c667951d4b.jpg,/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '建议建议', '1570607936');

-- ----------------------------
-- Table structure for aaz_gift
-- ----------------------------
DROP TABLE IF EXISTS `aaz_gift`;
CREATE TABLE `aaz_gift` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `g_name` varchar(20) DEFAULT NULL COMMENT '礼物名称',
  `money` double(10,0) DEFAULT NULL COMMENT '礼物价格(约币)',
  `pic` varchar(100) DEFAULT NULL COMMENT '图标',
  `type` tinyint(2) DEFAULT NULL COMMENT '类型;1:聊天专用;2:发布约会',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='礼物表';

-- ----------------------------
-- Records of aaz_gift
-- ----------------------------
INSERT INTO `aaz_gift` VALUES ('1', '雪碧', '18', '/upload/20191011/1e9d022dd9be267cabedb9a2a1045662.png', '1', '1569753575');
INSERT INTO `aaz_gift` VALUES ('2', '可乐', '18', '/upload/20191011/45815fafc8468820e69c213213bee14c.png', '1', '1569753575');
INSERT INTO `aaz_gift` VALUES ('4', '咖啡', '28', '/upload/20191011/b428b2e87c0f3b5ae148a8538efda51e.png', '1', '1569812280');
INSERT INTO `aaz_gift` VALUES ('5', '《青》怡然之约', '19', '/upload/20191011/8787c86ebcc4a06b2d39ec6359c777be.png', '2', '1570761180');
INSERT INTO `aaz_gift` VALUES ('6', '《蓝》密语之约', '39', '/upload/20191011/ad2de504ced250bf2a6abd9e73436888.png', '2', '1570761660');
INSERT INTO `aaz_gift` VALUES ('7', '《粉》热恋之约', '59', '/upload/20191011/9f8cd0c0a5b59380bb01af8ff1904ea8.png', '2', '1570761660');
INSERT INTO `aaz_gift` VALUES ('8', '鸡尾酒', '38', '/upload/20191011/9e658553649e780321b8b03112b7cad5.png', '1', '1570778520');
INSERT INTO `aaz_gift` VALUES ('9', 'HelloKitty', '58', '/upload/20191011/b9c3a4f33475b7fc4bb78b7177285ccb.png', '1', '1570778580');
INSERT INTO `aaz_gift` VALUES ('10', '爱爱熊', '88', '/upload/20191011/1ab780418a1525b33f7974fba8cf6a71.png', '1', '1570778580');
INSERT INTO `aaz_gift` VALUES ('11', '热情向日葵', '138', '/upload/20191011/1afb540d91f95bc95cede1f848c59e1a.png', '1', '1570778640');
INSERT INTO `aaz_gift` VALUES ('12', '浪漫红玫瑰', '288', '/upload/20191011/d674ec83d298c593d9b5cb0acf0fce16.png', '1', '1570778640');
INSERT INTO `aaz_gift` VALUES ('13', '公主手链', '388', '/upload/20191011/1282cab5564d834251460e7aa91b53a4.png', '1', '1570778640');
INSERT INTO `aaz_gift` VALUES ('14', '情人戒指', '520', '/upload/20191011/fce473036399cd56a043a8859499bfa1.png', '1', '1570778700');
INSERT INTO `aaz_gift` VALUES ('15', '永驻我心', '988', '/upload/20191011/7706e00c1e12d2e3e6b38ad7a735c871.png', '1', '1570778700');
INSERT INTO `aaz_gift` VALUES ('16', '心心相印', '1314', '/upload/20191011/12dfdd2f41f25308d16aed71e736f0b9.png', '1', '1570778700');

-- ----------------------------
-- Table structure for aaz_guide
-- ----------------------------
DROP TABLE IF EXISTS `aaz_guide`;
CREATE TABLE `aaz_guide` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='新手指引';

-- ----------------------------
-- Records of aaz_guide
-- ----------------------------
INSERT INTO `aaz_guide` VALUES ('4', '爱爱猪怎么玩？', '<p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p style=\"margin-top: 0px; margin-bottom: 0px; text-rendering: optimizelegibility; font-feature-settings: \">内容内容内容内容内容内容内容内容内容内容</p><p><br/></p>', '1570517602');

-- ----------------------------
-- Table structure for aaz_heartbeat
-- ----------------------------
DROP TABLE IF EXISTS `aaz_heartbeat`;
CREATE TABLE `aaz_heartbeat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid_1` int(10) DEFAULT NULL,
  `uid_2` int(10) DEFAULT NULL,
  `favorability` int(20) DEFAULT NULL COMMENT '好感度',
  `type` tinyint(2) DEFAULT NULL COMMENT '类型;1:喜欢;2:心动;',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='喜欢心动表';

-- ----------------------------
-- Records of aaz_heartbeat
-- ----------------------------
INSERT INTO `aaz_heartbeat` VALUES ('1', '2', '4', '100', '1', '1569726611');
INSERT INTO `aaz_heartbeat` VALUES ('2', '1', '2', '200', '1', '1569726611');
INSERT INTO `aaz_heartbeat` VALUES ('3', '1', '4', '150', '2', '1569726611');

-- ----------------------------
-- Table structure for aaz_help
-- ----------------------------
DROP TABLE IF EXISTS `aaz_help`;
CREATE TABLE `aaz_help` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='帮助中心';

-- ----------------------------
-- Records of aaz_help
-- ----------------------------
INSERT INTO `aaz_help` VALUES ('2', '叫你有深度玩转魅魅~', '<p><span style=\"color: rgb(51, 51, 51); font-family: \">叫你有深度玩转魅魅~</span></p>', '1570514077');

-- ----------------------------
-- Table structure for aaz_heterosexual
-- ----------------------------
DROP TABLE IF EXISTS `aaz_heterosexual`;
CREATE TABLE `aaz_heterosexual` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '发布人',
  `gid` int(10) DEFAULT NULL COMMENT '礼物id',
  `address` varchar(100) DEFAULT NULL COMMENT '定位地址',
  `coordinate` varchar(20) DEFAULT NULL COMMENT '坐标',
  `method` tinyint(2) DEFAULT NULL COMMENT '约会方式;1:请吃饭;2:吃喝玩乐',
  `hope` tinyint(2) DEFAULT NULL COMMENT '约会期望;1:单约;2:可带闺蜜',
  `message` varchar(255) DEFAULT NULL COMMENT '留言',
  `invitation` int(10) DEFAULT NULL COMMENT '心动邀请人id',
  `give` tinyint(2) DEFAULT NULL COMMENT '是否赠送礼物;1:是；2:否',
  `daynum` int(2) DEFAULT '10' COMMENT '剩余时间',
  `dating_id` int(10) DEFAULT NULL COMMENT '应约id',
  `d_status` tinyint(2) DEFAULT '1' COMMENT '约会状态;1:等待邀约;2:邀约成功;3:约会结束',
  `p_status` tinyint(2) DEFAULT '1' COMMENT '发布状态;1:上架;2:下架',
  `addtime` int(11) DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='异性直约发布约会表';

-- ----------------------------
-- Records of aaz_heterosexual
-- ----------------------------
INSERT INTO `aaz_heterosexual` VALUES ('1', '1', '5', '广州天河', '113.346236,23.097441', '1', '1', '约会', null, '1', '1', null, '1', '1', '1570785973');
INSERT INTO `aaz_heterosexual` VALUES ('2', '1', '5', '广州天河', '113.346236,23.097441', '1', '1', '约会', null, '1', '10', '2', '2', '1', '1570785973');

-- ----------------------------
-- Table structure for aaz_initiate
-- ----------------------------
DROP TABLE IF EXISTS `aaz_initiate`;
CREATE TABLE `aaz_initiate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid_1` int(10) DEFAULT NULL,
  `uid_2` int(10) DEFAULT NULL,
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发起心动列表';

-- ----------------------------
-- Records of aaz_initiate
-- ----------------------------

-- ----------------------------
-- Table structure for aaz_matchinglist
-- ----------------------------
DROP TABLE IF EXISTS `aaz_matchinglist`;
CREATE TABLE `aaz_matchinglist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hid` int(10) DEFAULT NULL COMMENT '直约id',
  `phone` varchar(20) DEFAULT NULL COMMENT '发布人手机号',
  `phone2` varchar(20) DEFAULT NULL COMMENT '邀约人手机号',
  `gid` int(10) DEFAULT NULL COMMENT '道具id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态;1:开启;2:关闭',
  `addtime` int(11) DEFAULT NULL COMMENT '配对时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='直约配对榜';

-- ----------------------------
-- Records of aaz_matchinglist
-- ----------------------------
INSERT INTO `aaz_matchinglist` VALUES ('1', '1', '15917908748', '13000000000', '5', '1', '1570785973');
INSERT INTO `aaz_matchinglist` VALUES ('2', null, '13333333333', '15917908748', '7', '1', '1571212280');

-- ----------------------------
-- Table structure for aaz_near
-- ----------------------------
DROP TABLE IF EXISTS `aaz_near`;
CREATE TABLE `aaz_near` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '发布人id',
  `location` varchar(100) DEFAULT NULL COMMENT '定位地址',
  `coordinate` varchar(50) DEFAULT NULL COMMENT '坐标',
  `kind` varchar(50) DEFAULT NULL COMMENT '服务种类',
  `pic` varchar(255) DEFAULT NULL COMMENT '图片',
  `type` tinyint(2) DEFAULT NULL COMMENT '服务方式;1:可上门;2:在线服务;',
  `message` varchar(50) DEFAULT NULL COMMENT '留言',
  `telephone` int(15) DEFAULT NULL COMMENT '联系电话',
  `status` tinyint(2) DEFAULT NULL COMMENT '发布状态;1:开启;2:关闭',
  `addtime` int(11) DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='附近服务表';

-- ----------------------------
-- Records of aaz_near
-- ----------------------------
INSERT INTO `aaz_near` VALUES ('1', '1', '广州海珠琶洲海港花园', '113.346236,23.097441', '电脑修配,搬物搬家,舞蹈拳道', '/upload/20190927/d34e982fec2324a79cdcc8c667951d4b.jpg,/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '1', '上门教学', '1300000000', '1', '1570785973');

-- ----------------------------
-- Table structure for aaz_nightchat
-- ----------------------------
DROP TABLE IF EXISTS `aaz_nightchat`;
CREATE TABLE `aaz_nightchat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '发布人',
  `topic` varchar(50) DEFAULT NULL COMMENT '话题',
  `pointend` double(10,1) DEFAULT '0.0' COMMENT '结算积分',
  `area` varchar(20) DEFAULT NULL COMMENT '优先地区',
  `sex` char(2) DEFAULT NULL COMMENT '优先性别',
  `uid2` int(10) DEFAULT NULL COMMENT '接受人id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态;1:待接通;2:正在通话;3:未接通;4:已结束',
  `addtime` int(11) DEFAULT NULL COMMENT '发起时间',
  `starttime` int(11) DEFAULT NULL COMMENT '开始时间',
  `endtime` int(11) DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='静夜寻聊表';

-- ----------------------------
-- Records of aaz_nightchat
-- ----------------------------
INSERT INTO `aaz_nightchat` VALUES ('2', '4', '你觉得今天的股市怎么样？', '0.0', '广州市', '女', null, '1', '1571047659', null, null);

-- ----------------------------
-- Table structure for aaz_option
-- ----------------------------
DROP TABLE IF EXISTS `aaz_option`;
CREATE TABLE `aaz_option` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `autoload` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否自动加载;1:自动加载;0:不自动加载',
  `option_name` varchar(64) NOT NULL DEFAULT '' COMMENT '配置名',
  `option_value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `option_name` (`option_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='全站配置表';

-- ----------------------------
-- Records of aaz_option
-- ----------------------------
INSERT INTO `aaz_option` VALUES ('7', '1', 'site_info', '{\"site_name\":\"\\u70ed\\u551b\",\"site_seo_title\":\"\\u8fdc\\u60f3\",\"site_seo_keywords\":\"ThinkCMF,php,\\u5185\\u5bb9\\u7ba1\\u7406\\u6846\\u67b6,cmf,cms,\\u7b80\\u7ea6\\u98ce, simplewind,framework\",\"site_seo_description\":\"ThinkCMF\\u662f\\u7b80\\u7ea6\\u98ce\\u7f51\\u7edc\\u79d1\\u6280\\u53d1\\u5e03\\u7684\\u4e00\\u6b3e\\u7528\\u4e8e\\u5feb\\u901f\\u5f00\\u53d1\\u7684\\u5185\\u5bb9\\u7ba1\\u7406\\u6846\\u67b6\",\"site_icp\":\"\",\"site_admin_email\":\"\",\"site_analytics\":\"\",\"urlmode\":\"1\",\"html_suffix\":\"\"}');
INSERT INTO `aaz_option` VALUES ('8', '1', 'cmf_settings', '{\"open_registration\":\"0\",\"banned_usernames\":\"\"}');
INSERT INTO `aaz_option` VALUES ('9', '1', 'cdn_settings', '{\"cdn_static_root\":\"\"}');
INSERT INTO `aaz_option` VALUES ('10', '1', 'admin_settings', '{\"admin_password\":\"\",\"admin_style\":\"flatadmin\"}');

-- ----------------------------
-- Table structure for aaz_participate
-- ----------------------------
DROP TABLE IF EXISTS `aaz_participate`;
CREATE TABLE `aaz_participate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '参与人id',
  `sid` int(10) DEFAULT NULL COMMENT '同城约玩id',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='同城约玩参与列表';

-- ----------------------------
-- Records of aaz_participate
-- ----------------------------
INSERT INTO `aaz_participate` VALUES ('1', '2', '2', '1570785973');
INSERT INTO `aaz_participate` VALUES ('2', '4', '2', '1570785973');

-- ----------------------------
-- Table structure for aaz_pclist
-- ----------------------------
DROP TABLE IF EXISTS `aaz_pclist`;
CREATE TABLE `aaz_pclist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `m_phone` varchar(20) DEFAULT NULL COMMENT '男性手机号',
  `w_phone` varchar(20) DEFAULT NULL COMMENT '女性手机号',
  `heartbeat` int(10) DEFAULT '0' COMMENT '心动值',
  `status` tinyint(2) DEFAULT '1' COMMENT '开启状态;1:开启 2:关闭',
  `addtime` int(11) DEFAULT NULL COMMENT '配对时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='PC榜';

-- ----------------------------
-- Records of aaz_pclist
-- ----------------------------
INSERT INTO `aaz_pclist` VALUES ('1', '1591790848', '13000000000', '0', '1', '1571215609');
INSERT INTO `aaz_pclist` VALUES ('3', '15917908748', '13000000000', '123', '1', '1571219245');

-- ----------------------------
-- Table structure for aaz_pclist_copy
-- ----------------------------
DROP TABLE IF EXISTS `aaz_pclist_copy`;
CREATE TABLE `aaz_pclist_copy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `m_phone` varchar(20) DEFAULT NULL COMMENT '男性手机号',
  `w_phone` varchar(20) DEFAULT NULL COMMENT '女性手机号',
  `heartbeat` int(10) DEFAULT '0' COMMENT '心动值',
  `status` tinyint(2) DEFAULT '1' COMMENT '开启状态;1:开启 2:关闭',
  `addtime` int(11) DEFAULT NULL COMMENT '配对时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='PC榜';

-- ----------------------------
-- Records of aaz_pclist_copy
-- ----------------------------
INSERT INTO `aaz_pclist_copy` VALUES ('1', '1591790848', '13000000000', '0', '1', '1571215609');
INSERT INTO `aaz_pclist_copy` VALUES ('3', '15917908748', '13000000000', '123', '1', '1571219245');

-- ----------------------------
-- Table structure for aaz_samecity
-- ----------------------------
DROP TABLE IF EXISTS `aaz_samecity`;
CREATE TABLE `aaz_samecity` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '发布人',
  `content` varchar(20) DEFAULT NULL COMMENT '约会内容',
  `location` varchar(100) DEFAULT NULL COMMENT '定位地址',
  `coordinate` varchar(50) DEFAULT NULL COMMENT '坐标',
  `address` varchar(255) DEFAULT NULL COMMENT '选择地点',
  `happytime` int(11) DEFAULT NULL COMMENT '邀玩时间;1:随时;2周末;时间戳',
  `payway` tinyint(2) DEFAULT NULL COMMENT '买单方式;1:AA制;2:我请客;',
  `bring_friend` tinyint(2) DEFAULT NULL COMMENT '允许带朋友;1:允许 2不允许',
  `hope` tinyint(2) DEFAULT NULL COMMENT '约会期望;1:单约;2:聚会',
  `message` varchar(255) DEFAULT NULL COMMENT '留言',
  `daynum` int(2) DEFAULT '10' COMMENT '剩余时间',
  `d_status` tinyint(2) DEFAULT '1' COMMENT '约会状态;1:发布中;2:已下架;',
  `addtime` int(11) DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='同城约玩列表';

-- ----------------------------
-- Records of aaz_samecity
-- ----------------------------
INSERT INTO `aaz_samecity` VALUES ('2', '1', '看电影', '广州海珠琶洲海港花园', '113.346236,23.097441', '广州市天河区天上人间KTV', '1570959933', '1', '2', '2', '好好玩', '9', '1', '1570785973');

-- ----------------------------
-- Table structure for aaz_setting
-- ----------------------------
DROP TABLE IF EXISTS `aaz_setting`;
CREATE TABLE `aaz_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '分项',
  `content` text COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='基础设置表';

-- ----------------------------
-- Records of aaz_setting
-- ----------------------------
INSERT INTO `aaz_setting` VALUES ('1', '用户注册协议', '<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户注册协议</strong></p>');
INSERT INTO `aaz_setting` VALUES ('2', '商家发布任务页面提醒', '<p><strong><span style=\"font-size:19px;font-family:等线;color:red\">绑定店铺最后一个上传淘宝店图片这里，不要这些文字提示，其实我要的是文字提示是：为避免恶意绑定他人店铺，请上传千牛卖家后台的截图。</span></strong><strong><span style=\"font-size:19px;font-family:等线;color:red\">绑定店铺最后一个上传淘宝店图片这里，不要这些文字提示，其实我要的是文字提示是：为避免恶意绑定他人店铺，请上传千牛卖家后台的截图。</span></strong></p>');
INSERT INTO `aaz_setting` VALUES ('3', '用户账号补充信息要求', '<p>补充<strong><span style=\"font-size:19px;font-family:等线;color:red\">绑定店铺最后一个上传淘宝店图片这里，不要这些文字提示，其实我要的是文字提示是：为避免恶意绑定他人店铺，请上传千牛卖家后台的截图。</span></strong></p>');
INSERT INTO `aaz_setting` VALUES ('4', '商家收费标准', '<p><img src=\"/ueditor/php/upload/image/20190920/1568940167942673.png\" title=\"1568940167942673.png\" alt=\"image.png\"/></p>');

-- ----------------------------
-- Table structure for aaz_user
-- ----------------------------
DROP TABLE IF EXISTS `aaz_user`;
CREATE TABLE `aaz_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(50) DEFAULT NULL COMMENT '昵称',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号码',
  `icon` varchar(255) DEFAULT NULL COMMENT '头像',
  `icon_v1` varchar(255) DEFAULT NULL COMMENT '副图1',
  `icon_v2` varchar(255) DEFAULT NULL COMMENT '副图2',
  `icon_v3` varchar(255) DEFAULT NULL COMMENT '副图3',
  `icon_v4` varchar(255) DEFAULT NULL COMMENT '副图4',
  `vip` tinyint(2) DEFAULT '2' COMMENT '是否是永久vip  1是 2不是',
  `viptime` int(10) DEFAULT NULL COMMENT 'vip过期时间',
  `financial` int(10) DEFAULT '0' COMMENT '男：财气值 ; 女：魅力值',
  `coordinate` varchar(20) DEFAULT NULL COMMENT '坐标',
  `interest` varchar(30) DEFAULT NULL COMMENT '兴趣',
  `signature` varchar(50) DEFAULT NULL COMMENT '个性签名',
  `gender` tinyint(2) DEFAULT NULL COMMENT '性别;1:男;2:女;',
  `currency` double(10,0) DEFAULT '0' COMMENT '约币',
  `integral` double(10,1) DEFAULT '0.0' COMMENT '积分',
  `icon_status` tinyint(2) DEFAULT '1' COMMENT '头像启用状态;1:启用;2:禁用',
  `hall` tinyint(2) DEFAULT '2' COMMENT '大厅显示;1:显示;2:隐藏',
  `status` tinyint(2) DEFAULT '1' COMMENT '账户状态;1:启用;2:停用',
  `lasttime` int(20) DEFAULT NULL COMMENT '活跃时间(上次请求时间)',
  `token` varchar(50) DEFAULT NULL,
  `time_out` int(10) DEFAULT NULL COMMENT 'token过期时间',
  `addtime` int(20) unsigned DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表';

-- ----------------------------
-- Records of aaz_user
-- ----------------------------
INSERT INTO `aaz_user` VALUES ('1', '小牛', '1969-10-20', '15917908748', '20190927/d34e982fec2324a79cdcc8c667951d4b.jpg', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '1', null, '0', '500,600', null, '我的地盘我做主', '1', '0', '0.0', '1', '2', '1', '1569577961', null, null, '1569571071');
INSERT INTO `aaz_user` VALUES ('2', '小妞', '1998-09-28', '13000000000', '20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '2', null, '0', null, null, null, '2', '0', '0.0', '1', '2', '1', null, null, null, '1569652620');
INSERT INTO `aaz_user` VALUES ('4', '小飞', '2000-01-17', '13333333333', '20190927/2343423321d9b343797da9dfc834f6e9.jpg', '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '', null, '/upload/20190928/159126a92d974f890d32ccf3461fc0cd.jpg', '2', '1569571071', '0', null, null, null, '1', '20', '0.0', '1', '2', '1', null, null, null, '1569653400');

-- ----------------------------
-- Table structure for aaz_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `aaz_withdraw`;
CREATE TABLE `aaz_withdraw` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `order_num` varchar(16) DEFAULT NULL COMMENT '提现订单号',
  `account` varchar(50) DEFAULT NULL COMMENT '支付宝账号',
  `zfb_name` varchar(20) DEFAULT NULL COMMENT '支付宝姓名',
  `money` int(5) DEFAULT NULL COMMENT '提现金额',
  `status` tinyint(2) DEFAULT '1' COMMENT '提现状态;1:待审核;2:通过;3:不通过',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  `endtime` int(11) DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='提现管理表';

-- ----------------------------
-- Records of aaz_withdraw
-- ----------------------------
INSERT INTO `aaz_withdraw` VALUES ('1', '1', '2019101500001234', '123456789', '张三', '100', '1', '1571119723', null);
INSERT INTO `aaz_withdraw` VALUES ('2', '1', '2019101500001235', '123456789', '张三', '100', '2', '1571119723', '1571123470');
