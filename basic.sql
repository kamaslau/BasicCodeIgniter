SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `activity`;
CREATE TABLE `activity` (
  `activity_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '活动ID',
  `name` varchar(10) NOT NULL COMMENT '活动名称；最多10个汉字',
  `detail` varchar(100) NOT NULL COMMENT '活动描述；最多100个汉字。',
  `time_start` datetime DEFAULT NULL COMMENT '开始日期',
  `time_end` datetime DEFAULT NULL COMMENT '结束日期',
  `time_create` datetime NOT NULL COMMENT '创建日期',
  `time_edit` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑日期',
  `time_delete` datetime DEFAULT NULL COMMENT '删除日期',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '状态；1正常2已删除',
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='营销活动信息表';

DROP TABLE IF EXISTS  `article`;
CREATE TABLE `article` (
  `article_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `category_id` varchar(3) NOT NULL DEFAULT '0' COMMENT '所属分类ID；默认为0，即默认分类',
  `author_id` varchar(10) DEFAULT NULL COMMENT '作者的stuff_id',
  `title` varchar(30) NOT NULL COMMENT '标题；最多30个字符',
  `content` blob NOT NULL COMMENT '正文内容',
  `excerpt` varchar(100) DEFAULT NULL COMMENT '摘要；最多100个字符',
  `keywords` varchar(255) DEFAULT NULL COMMENT 'keywords（SEO）；每个关键词之间用半角逗号“,”分隔，最多255个汉字',
  `description` varchar(255) DEFAULT NULL COMMENT 'description（SEO）；最多255个汉字',
  `tag_ids` varchar(255) DEFAULT NULL COMMENT '所属标签的id列表；以1个空格分隔',
  `password` varchar(40) DEFAULT NULL COMMENT '查看密码；经过SHA1加密',
  `time_create` datetime NOT NULL COMMENT '创建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('草稿','公开','加密') NOT NULL DEFAULT '公开' COMMENT '文章状态',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章（公告、说明、服务条款等一般不可讨论或留言的内容）';

DROP TABLE IF EXISTS  `article_category`;
CREATE TABLE `article_category` (
  `category_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章分类ID',
  `parent_id` varchar(3) DEFAULT NULL COMMENT '所属分类ID',
  `name` varchar(10) NOT NULL COMMENT '分类名称；最多10个汉字',
  `nicename` varchar(30) DEFAULT NULL COMMENT 'URL名称（SEO）；最多30个汉字',
  `description` varchar(100) DEFAULT NULL COMMENT '分类描述；最多100个汉字',
  `time_create` datetime NOT NULL COMMENT '创建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('隐藏','公开') NOT NULL DEFAULT '公开' COMMENT '分类状态；覆盖所含文章状态',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类';

DROP TABLE IF EXISTS  `branch`;
CREATE TABLE `branch` (
  `branch_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '门店ID',
  `name` varchar(10) NOT NULL COMMENT '门店名称',
  `province` varchar(8) NOT NULL COMMENT '省级行政区（港澳台、直辖市、省、自治区等）',
  `city` varchar(15) NOT NULL COMMENT '地级行政区（地级市等）',
  `county` varchar(15) DEFAULT NULL COMMENT '县级行政区（地级市下属区、县等）',
  `address` varchar(35) NOT NULL COMMENT '具体地址',
  `latitude` varchar(10) DEFAULT NULL COMMENT '纬度',
  `longitude` varchar(10) DEFAULT NULL COMMENT '经度',
  `tel` varchar(13) NOT NULL COMMENT '电话（固话或者手机号均可）',
  `image_url` varchar(255) DEFAULT NULL COMMENT '主图URL',
  `map_url` varchar(255) DEFAULT NULL COMMENT '百度地图链接',
  `map_image_url` varchar(255) DEFAULT NULL COMMENT '百度地图URL',
  `time_create` datetime NOT NULL COMMENT '创建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('隐藏', '正常') NOT NULL DEFAULT '正常' COMMENT '状态',
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='门店信息';

DROP TABLE IF EXISTS  `brand`;
CREATE TABLE `brand` (
  `brand_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '品牌ID',
  `index` varchar(1) NOT NULL COMMENT '索引；中文名称拼音首字母大写',
  `name_cn` varchar(10) NOT NULL COMMENT '品牌中文名称',
  `name_en` varchar(30) DEFAULT NULL COMMENT '品牌英文名称',
  `logo_url` varchar(255) DEFAULT NULL COMMENT 'LOGO图片网址',
  `detail` blob COMMENT '品牌简介',
  `url_cn` varchar(255) DEFAULT NULL COMMENT '品牌中文网址',
  `url_en` varchar(255) DEFAULT NULL COMMENT '品牌英文网址',
  `time_create` datetime NOT NULL COMMENT '创建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('隐藏', '正常') NOT NULL DEFAULT '正常' COMMENT '状态',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='品牌';

DROP TABLE IF EXISTS  `captcha`;
CREATE TABLE `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台用户sessionCodeIgniter框架存储session所用的表';

DROP TABLE IF EXISTS  `ci_sessions_admin`;
CREATE TABLE `ci_sessions_admin` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理后台用户session；Codeigniter框架存储session所用的表';

DROP TABLE IF EXISTS  `comment`;
CREATE TABLE `comment` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `user_id` varchar(11) NOT NULL COMMENT '用户ID',
  `order_type` enum('1','2') NOT NULL COMMENT '订单类型；1常规订单2代购订单',
  `order_id` varchar(11) NOT NULL COMMENT '订单ID',
  `title` varchar(30) NOT NULL COMMENT '评论标题；最多30个汉字',
  `content` blob NOT NULL COMMENT '评论内容',
  `image_urls` blob COMMENT '评论图片的URL们；URL之间以1个空格分隔',
  `time_create` datetime NOT NULL COMMENT '评论创建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) DEFAULT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('草稿','正常','隐藏') NOT NULL DEFAULT '正常' COMMENT '状态',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户对订单的评论';

DROP TABLE IF EXISTS  `coupon`;
CREATE TABLE `coupon` (
  `coupon_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠券ID',
  `user_id` varchar(11) NOT NULL COMMENT '会员ID',
  `brand_id` varchar(32) DEFAULT NULL COMMENT '限定使用的品牌ID',
  `series_id` varchar(10) DEFAULT NULL COMMENT '限定使用的车系ID',
  `edition_id` varchar(11) DEFAULT NULL COMMENT '限定使用的车版ID',
  `amount` decimal(7,2) unsigned NOT NULL COMMENT '优惠券金额',
  `from` enum('1','2','3','4') NOT NULL COMMENT '来源（获取方式）；1完成普通订单2完成代购订单3猜车宝4其它市场活动',
  `order_id` varchar(11) DEFAULT NULL COMMENT '普通订单ID（若来源是普通订单则填写此项）',
  `daigou_id` varchar(11) DEFAULT NULL COMMENT '代购订单ID（若来源是代购订单则填写此项）',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '获取时间',
  `time_expire` datetime DEFAULT NULL COMMENT '失效时间',
  `time_use` datetime DEFAULT NULL COMMENT '使用日期',
  `use_operator_id` varchar(3) DEFAULT NULL COMMENT '使用操作经手员工stuff_id',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `delete_operator_id` varchar(3) DEFAULT NULL COMMENT '删除操作经手员工stuff_id',
  `status` enum('未使用','已使用','已删除','已过期') NOT NULL DEFAULT '未使用' COMMENT '状态',
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优惠券信息';

DROP TABLE IF EXISTS  `edition`;
CREATE TABLE `edition` (
  `edition_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '车版ID',
  `brand_id` varchar(3) NOT NULL COMMENT '所属品牌ID',
  `series_id` varchar(10) NOT NULL COMMENT '所属车系ID',
  `name` varchar(30) NOT NULL COMMENT '车版名称',
  `main_image_url` varchar(255) NOT NULL COMMENT '车版图片url',
  `detail` blob NOT NULL COMMENT '车版详情',
  `count` tinyint(3) unsigned DEFAULT NULL COMMENT '库存数量（辆）',
  `tag_price` decimal(7,2) unsigned NOT NULL COMMENT '参考价（万元）；最高99999.99万元',
  `price` decimal(7,2) unsigned NOT NULL COMMENT '商城价（万元）；最高99999.99万元',
  `earnest` int(5) unsigned NOT NULL COMMENT '定金（元）；最高99999',
  `source` enum('中规','平行进口') NOT NULL COMMENT '来源（中规、平行进口）',
  `year` varchar(4) NOT NULL COMMENT '年款',
  `power` enum('汽油','柴油','电力','混合动力') NOT NULL COMMENT '动力类型',
  `gear` enum('自动','手动','手自一体','无级变速') NOT NULL COMMENT '变速箱',
  `displacement` decimal(3,1) unsigned NOT NULL COMMENT '排量（L）',
  `chicun` varchar(20) NOT NULL COMMENT '尺寸；长宽高（mm）',
  `zhouju` varchar(5) NOT NULL COMMENT '轴距（mm）',
  `jiegou` varchar(20) NOT NULL COMMENT '车身结构（X门X座SUV/轿车/轿跑车等等）',
  `item1` varchar(30) NOT NULL COMMENT '发动机型号',
  `item11` varchar(3) NOT NULL COMMENT '最大马力(Ps)',
  `item22` varchar(30) NOT NULL COMMENT '简称',
  `item23` varchar(4) NOT NULL COMMENT '档位个数',
  `item24` varchar(30) NOT NULL COMMENT '变速箱类型',
  `item28` varchar(30) NOT NULL COMMENT '前悬架',
  `item29` varchar(30) NOT NULL COMMENT '后悬架',
  `item31` varchar(30) NOT NULL COMMENT '车体结构',
  `color_outer` varchar(10) NOT NULL COMMENT '车身颜色',
  `color_inner` varchar(10) NOT NULL COMMENT '内饰颜色',
  `color_inner_second` varchar(6) DEFAULT NULL COMMENT '内饰第二颜色（即双拼色）',
  `liangdian` varchar(255) DEFAULT NULL COMMENT '亮点配置',
  `time_create` datetime NOT NULL COMMENT '新建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('未上架','已上架') NOT NULL DEFAULT '未上架' COMMENT '状态',
  PRIMARY KEY (`edition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='车版信息（即品牌brand→车型model→车版edition）；部分字段系由车版详情信息表复制而来，保留原字段名';

DROP TABLE IF EXISTS  `meta_system`;
CREATE TABLE `meta_system` (
  `meta_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '设置项ID',
  `name` varchar(255) NOT NULL COMMENT '设置项名称',
  `value` varchar(255) DEFAULT NULL COMMENT '设置项内容',
  `note` varchar(255) DEFAULT NULL COMMENT '说明',
  `time_create` datetime NOT NULL COMMENT '新建时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统设置信息';

DROP TABLE IF EXISTS  `order`;
CREATE TABLE `order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '常规订单ID',
  `user_id` varchar(11) NOT NULL COMMENT '用户ID',
  `user_ip` varchar(32) NOT NULL DEFAULT '0.0.0.0' COMMENT '用户设备IP地址',
  `comment_id` varchar(11) DEFAULT NULL COMMENT '订单评论ID',
  `edition_id` varchar(11) NOT NULL COMMENT '车版ID',
  `shipment` enum('0','1') DEFAULT '0' COMMENT '交付方式；0到店自提1送车上门',
  `total` decimal(7,2) unsigned NOT NULL COMMENT '支付金额（元）；最高99999',
  `payment_type` enum('1','2') DEFAULT NULL COMMENT '1支付宝2微信支付',
  `payment_id` varchar(50) DEFAULT NULL COMMENT '支付流水号',
  `note_user` varchar(30) DEFAULT NULL COMMENT '会员备注',
  `note` varchar(150) DEFAULT NULL COMMENT '管理员备注',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单创建时间',
  `time_close` datetime DEFAULT NULL COMMENT '订单过期时间',
  `time_cancel` datetime DEFAULT NULL COMMENT '用户取消订单时间',
  `time_pay` datetime DEFAULT NULL COMMENT '用户支付成功时间',
  `time_refuse` datetime DEFAULT NULL COMMENT '管理员拒绝订单时间',
  `refuse_operator_id` varchar(3) DEFAULT NULL COMMENT '拒绝订单的管理员stuff_id',
  `time_finish` datetime DEFAULT NULL COMMENT '订单成交时间（即确认提车时间）',
  `finish_operator_id` varchar(3) DEFAULT NULL COMMENT '确认成交（即提车）的管理员stuff_id',
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0' COMMENT '订单状态；0待支付1已支付2已成交3已取消4已拒绝5已过期',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='常规订单信息，即可直接支付的订单。';

DROP TABLE IF EXISTS  `patch_ios`;
CREATE TABLE `patch_ios` (
  `patch_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Patch编号',
  `version` varchar(8) NOT NULL COMMENT 'APP版本号；X.X.X（最高99.99.99）',
  `file_name` varchar(10) DEFAULT NULL COMMENT 'Patch文件名（.js）',
  `content` blob NOT NULL COMMENT 'Patch内容',
  `time_create` datetime NOT NULL COMMENT '创建日期',
  `time_delete` datetime DEFAULT NULL COMMENT '删除日期',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('正常') NOT NULL DEFAULT '正常' COMMENT '状态',
  PRIMARY KEY (`patch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='JSPatch（iOS应用热修复）信息表';

DROP TABLE IF EXISTS  `sms`;
CREATE TABLE `sms` (
  `sms_id` bigint(19) unsigned NOT NULL AUTO_INCREMENT COMMENT '短信ID',
  `mobile` varchar(11) NOT NULL COMMENT '收信手机号',
  `type` enum('1','2','3','4') NOT NULL DEFAULT '1' COMMENT '短信类型；1注册、登录、密码找回、邮箱绑定等验证码2订单通知',
  `content` varchar(32) DEFAULT NULL COMMENT '短信内容（若为验证码则需保存此项）',
  `user_ip` varchar(20) DEFAULT NULL COMMENT '用户IP',
  `time_sent` varchar(3) NOT NULL DEFAULT '' COMMENT '发送时间;10位数字时间戳',
  PRIMARY KEY (`sms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='短信发送记录资料';

DROP TABLE IF EXISTS  `stuff`;
CREATE TABLE `stuff` (
  `stuff_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '员工ID',
  `password` varchar(40) NOT NULL COMMENT '员工登陆密码',
  `lastname` varchar(9) NOT NULL COMMENT '姓氏',
  `firstname` varchar(6) DEFAULT NULL COMMENT '名',
  `gender` enum('女','男') DEFAULT NULL COMMENT '性别',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `email` varchar(40) NOT NULL COMMENT '电子邮箱地址',
  `role` enum('manager','finance','stuff','personnel','service','operator','editor','developer') DEFAULT 'stuff' COMMENT '角色；管理员manager，人事hr，财务finance，编辑editor，运营人员operator，客户服务service，其它stuff',
  `level` tinyint(3) unsigned DEFAULT '0' COMMENT '级别；0暂不授权10门店级20品牌级30企业级',
  `note` varchar(255) DEFAULT NULL COMMENT '备注',
  `time_joined` date DEFAULT NULL COMMENT '入职日期',
  `time_left` date DEFAULT NULL COMMENT '被辞退、离职日期',
  `time_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('0','1','2','3') NOT NULL DEFAULT '1' COMMENT '状态；0待入职1已入职2已辞退3已离职',
  PRIMARY KEY (`stuff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='员工信息表';

DROP TABLE IF EXISTS  `user`;
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `password` varchar(40) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(12) DEFAULT NULL COMMENT '昵称；最多12个字符',
  `lastname` varchar(9) NOT NULL COMMENT '姓氏；最多9个汉字“爨邯汕寺武穆云籍鞲”（这不是乱码，真的有这个姓氏啊我去……）',
  `firstname` varchar(6) DEFAULT NULL COMMENT '名；最多6个汉字中文最长名字是“欧阳成功奋发图强”，唉……',
  `gender` enum('女','男') DEFAULT NULL COMMENT '性别',
  `dob` date DEFAULT NULL COMMENT '出生日期；公历',
  `logo_url` varchar(255) DEFAULT NULL COMMENT '头像图片网址',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `email` varchar(40) DEFAULT NULL COMMENT '电子邮件地址',
  `wechat_open_id` varchar(28) DEFAULT NULL COMMENT '微信用户的openid',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间；即注册时间',
  `time_last_login` datetime DEFAULT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`user_id`),
  KEY `mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户资料';

DROP TABLE IF EXISTS  `wechat_reply`;
CREATE TABLE `wechat_reply` (
  `item_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动回复项编号',
  `biz_id` tinyint(11) NOT NULL COMMENT '企业ID',
  `keywords` varchar(255) NOT NULL COMMENT '关键字们；最多10个汉字，关键字之间用一个空格分隔',
  `type` varchar(10) NOT NULL DEFAULT 'text' COMMENT '回复消息类型',
  `content` varchar(255) DEFAULT NULL COMMENT '回复内容；文本类型有此项',
  `media_id` varchar(32) DEFAULT NULL COMMENT '多媒体资源ID；图片、语音、视频类型有此项',
  `title` varchar(32) DEFAULT NULL COMMENT '标题；视频、音乐、图文类型有此项',
  `description` varchar(32) DEFAULT NULL COMMENT '描述；视频、音乐、图文类型有此项',
  `music_url` varchar(255) DEFAULT NULL COMMENT '音乐链接；音乐类型有此项',
  `hq_music_url` varchar(255) DEFAULT NULL COMMENT '高质量音乐链接，WIFI环境优先使用该链接播放音乐；音乐类型有此项',
  `thumb_media_id` varchar(255) DEFAULT NULL COMMENT '缩略图的媒体id；音乐ID有此项',
  `pic_url` varchar(255) DEFAULT NULL COMMENT '图片链接；图文类型有此项，接受jpg或png格式',
  `url` varchar(255) DEFAULT NULL COMMENT '跳转链接；图文消息有此项',
  `time_create` datetime NOT NULL COMMENT '创建时间',
  `time_delete` datetime DEFAULT NULL COMMENT '删除时间',
  `time_edit` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `operator_id` varchar(3) NOT NULL COMMENT '最后编辑者stuff_id',
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '状态；0草稿1正常2已删除',
  PRIMARY KEY (`item_id`),
  FULLTEXT KEY `keywords` (`keywords`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微信公众平台自动回复信息表';

SET FOREIGN_KEY_CHECKS = 1;