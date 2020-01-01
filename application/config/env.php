<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	// 当前版本号，仅适用于生产环境
	define('CURRENT_VERSION', '0.0.1');
	define('CURRENT_VERSION_MAJOR', 0); // 主版本号
	define('CURRENT_VERSION_MINOR', 0); // 副版本号，功能新增
	define('CURRENT_VERSION_SUPPORT', 1); // 支持版本号，功能调整
	
	// 需要自定义的常量
	define('SITE_NAME', ''); // 站点名称
	define('SITE_SLOGAN', ''); // 站点广告语
	define('SITE_KEYWORDS', ''); // 站点关键词
	define('SITE_DESCRIPTION', ''); // 站点描述
	define('ICP_NUMBER', ''); // ICP备案号码（若有）
    define('APP_SCHEME', ''); // 原生应用scheme（若有）
    define('IOS_APP_ID', ''); // iOS应用ID（若有）
	
	// 根域名及URL
	if (ENVIRONMENT !== 'production'): // 测试环境
	    define('ROOT_DOMAIN', '.123.com');
	else: // 生产环境
	    define('ROOT_DOMAIN', '.abc.com');
	endif;
	define('ROOT_URL', ROOT_DOMAIN.'/');
	
	define('BASE_URL', 'https://'.ROOT_URL); // 可对外使用的站点URL
	define('CURRENT_URL', 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	define('API_URL', 'https://api'.ROOT_URL); // API URL
	define('WEB_URL', 'https://www'.ROOT_URL); // 客户端 URL
	define('BIZ_URL', 'https://biz'.ROOT_URL); // 商家端 URL
	define('ADMIN_URL', 'https://admin'.ROOT_URL); // 管理端 URL
	function api_url($api_name)
	{
	    return API_URL. $api_name;
	}

	// JS、CSS、非样式图片等非当前站点特有资源所在URL，可用于配合又拍云等第三方存储
	define('CDN_URL', 'https://cdn'.ROOT_URL); // CDN
	define('MEDIA_URL', 'https://medias'.ROOT_URL); // 媒体文件，即非样式图片、视频、音频存储的根目录所在URL，可用于配合又拍云等第三方存储
	define('DEFAULT_IMAGE', CDN_URL.'default_avatar.png'); // 默认图片URL

    // 微信公众平台
    define('WECHAT_APP_ID', '');
    define('WECHAT_APP_SECRET', '');
    define('WECHAT_TOKEN', '');
    define('AES_KEY', '');
    define('WECHAT_AUTH_URL', 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WECHAT_APP_ID.'&redirect_uri='.urlencode(CURRENT_URL).'&response_type=code&scope=snsapi_userinfo#wechat_redirect');

    // 微信支付（常用JS调起支付方式及被扫支付方式根路径）
    define('WEPAY_URL_JSAPI', BASE_URL.'payment/wepay/example/jsapi.php?showwxpaytitle=1&');
    define('WEPAY_URL_NATIVE', BASE_URL.'payment/wepay/example/native.php?showwxpaytitle=1&');

    // 支付宝
    define('ALIPAY_URL', BASE_URL.'payment/alipay/alipayapi.php?');

    // 又拍云
    if (ENVIRONMENT !== 'production'): // 测试环境
        define('UPYUN_BUCKETNAME', '');
        define('UPYUN_USERNAME', '');
        define('UPYUN_USERPASSWORD', '');
    else: // 生产环境
        define('UPYUN_BUCKETNAME', '');
        define('UPYUN_USERNAME', '');
        define('UPYUN_USERPASSWORD', '');
    endif;

/* End of file env.php */
/* Location: ./application/config/env.php */
	