<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    // 生成SEO相关信息
    $title = (ENVIRONMENT !== 'production'? '[演示]': NULL). (isset($title)? $title: SITE_NAME.' - '.SITE_SLOGAN); // 页面标题
    $keywords = (isset($keywords)? $keywords.',': NULL). SITE_KEYWORDS; // 页面关键词
    $description = (isset($description)? $description: NULL). SITE_DESCRIPTION; // 页面描述

    // 生成body的class
    $body_class = isset($class)? $class: NULL;
	// 移动端设备
	if ( $this->user_agent['is_mobile'] ):
		$body_class .= ' is_mobile';
	    $body_class .= ($this->user_agent['is_wechat'])? ' is_wechat': NULL;
	    $body_class .= ($this->user_agent['is_ios'])? ' is_ios': NULL;
	    $body_class .= ($this->user_agent['is_android'])? ' is_android': NULL;
		
	// 桌面端设备
	elseif ( $this->user_agent['is_desktop'] ):
		$body_class .= ' is_desktop';
	    $body_class .= ($this->user_agent['is_macos'])? ' is_macos': NULL;
	    $body_class .= ($this->user_agent['is_windows'])? ' is_windows': NULL;
		
	endif;
?>
<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="<?php echo CDN_URL ?>">
		<title><?php echo $title ?></title>
		<meta name=description content="<?php echo $description ?>">
		<meta name=keywords content="<?php echo $keywords ?>">
		<!--<meta name=robots content="noindex, nofollow">-->
		<meta name=version content="revision20180716">
		<meta name=author content="作者">
		<meta name=copyright content="版权信息">
		<meta name=contact content="联系方式">

		<meta name=viewport content="width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<link rel=stylesheet media=all href="<?php echo CDN_URL ?>css/reset.css">
		<link rel=stylesheet media=all href="<?php echo VIEWPATH ?>css/style.css">

		<script src="<?php echo CDN_URL ?>js/jquery/jquery-3.3.1.min.js"></script>
		<script defer src="<?php echo CDN_URL ?>font-awesome/v5.0.13/fontawesome-all.min.js"></script>
		<!--<script defer src="/js/xx.js"></script>-->
		<!--<script asnyc src="/js/xx.js"></script>-->
		<script>
            console.log('人才招聘' + "\n" + '176-6407-3966' + "\n\n");

            // UserAgent
            var user_agent = <?php echo json_encode($this->user_agent) ?>;

            // 当前用户信息
            var user_id = '<?php echo $this->session->user_id ?>';

            // 全局参数
            var api_url = '<?php echo API_URL ?>'; // API根URL
            var base_url = '<?php echo BASE_URL ?>'; // 页面根URL
            var cdn_url = '<?php echo CDN_URL ?>'; // CDN根URL
            var media_url = '<?php echo MEDIA_URL ?>'; // 媒体文件根URL
            var class_name = '<?php echo $this->class_name ?>'; // 当前类名称，例如“user”
            var class_name_cn = '<?php echo $this->class_name_cn ?>'; // 当前类中文名，例如“用户”
            
            // AJAX参数
            var common_params = new Object()
            common_params.app_type = 'client' // 默认为客户端请求
            common_params.user_id = user_id
            $.ajaxSetup({
                type: 'post',
                dataType: 'json',
            });
		</script>
		
        <?php
            // 微信相关功能
            if ($this->user_agent['is_wechat']) require_once(VIEWS_PATH.'templates/wechat.php');
        ?>

		<!--<link rel="shortcut icon" href="<?php echo CDN_URL ?>icon/icon_32x32.png">-->
		<!--<link rel=apple-touch-icon href="<?php echo CDN_URL ?>icon/icon_120x120.png">-->

		<link rel=canonical href="<?php echo current_url() ?>">

		<meta name=format-detection content="telephone=yes, email=no, address=no">
        <?php if (!empty(IOS_APP_ID) && $this->user_agent['is_ios']): ?>
        <meta name=apple-itunes-app content="app-id=<?php echo IOS_APP_ID ?>">
        <?php endif ?>
	</head>
<?php
	// 将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
	ob_flush();flush();
?>

<!-- 页面开始 -->
	<body class="<?php echo $body_class ?>">
		<noscript>
			<p>您的浏览器功能加载出现问题，请刷新浏览器重试；如果仍然出现此提示，请考虑更换浏览器。</p>
		</noscript>

		<header id=header role=banner>
			<div class=container>
				<h1>
					<a id=logo title="<?php echo SITE_NAME ?>" href="<?php echo base_url() ?>"><?php echo SITE_NAME ?></a>
				</h1>

				<a id=nav-switch class=nav-icon href="#header">
					<i class="fa fa-bars" aria-hidden=true></i>
				</a>
				<a class=nav-icon href="<?php echo base_url('mine') ?>">
					<span class="fa-stack fa-lg">
					  <i class="fa fa-circle-thin fa-stack-2x"></i>
					  <i class="fa fa-user fa-stack-1x"></i>
					</span>
				</a>
				<script>
				// 手机版菜单的显示和隐藏
				$(function(){
					$('#nav-switch').click(
						function(){
							var nav_icon = $(this).children('i');
							if (nav_icon.attr('class') == 'fa fa-bars'){
								nav_icon.attr('class', 'fa fa-chevron-up');
							} else {
								nav_icon.attr('class', 'fa fa-bars');
							}
							$('#nav-header').toggle();
							return false;
						}
					);
				});
				</script>

				<nav id=nav-header role=navigation>
					<ul id=main-nav class=horizontal>
						<li<?php if (strpos($class, 'home') !== FALSE) echo ' class=active' ?>><a title="首页" href="<?php echo base_url() ?>">首页</a></li>
						<li<?php if (strpos($class, 'article') !== FALSE) echo ' class=active' ?>><a title="文章" href="<?php echo base_url('article') ?>">文章</a></li>
					</ul>
				</nav>
				
				<div id=user-panel>
					<ul id=user-actions class=horizontal>
						<?php if ($this->session->time_expire_login < time()): ?>
						<li><a title="登录" href="<?php echo base_url('login') ?>">登录</a></li>
						<li><a title="注册" href="<?php echo base_url('register') ?>">注册</a></li>
						<?php else: ?>
						<li><a title="个人中心" href="<?php echo base_url('mine') ?>">我的</a></li>
						<li><a title="退出" href="<?php echo base_url('logout') ?>">退出</a></li>
						<?php endif ?>
					</ul>
					<p id=tel-header>
						<i class="fa fa-phone" aria-hidden=true></i> 400-xxxx-xxx
					</p>
				</div>
			</div>
		</header>

		<main id=maincontainer role=main>
