<?php
	// 生成SEO相关变量，一般为页面特定信息与在config/config.php中设置的站点通用信息拼接
	$title = isset($title)? $title.' - '.SITE_NAME: SITE_NAME.' - '.SITE_SLOGAN;
	$keywords = isset($keywords)? $keywords.',': NULL;
	$keywords .= SITE_KEYWORDS;
	$description = isset($description)? $description: NULL;
	$description .= SITE_DESCRIPTION;
?>
<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<!--<link rel=dns-prefetch href="http://cdn.key2all.com">-->
		<title><?php echo $title ?></title>
		<meta name=description content="<?php echo $description ?>">
		<meta name=keywords content="<?php echo $keywords ?>">
		<meta name=version content="revision20161207">
		<meta name=author content="作者">
		<meta name=copyright content="版权信息">
		<meta name=contact content="联系方式">

		<?php
			// 对于iOS和Android设备，放大1倍以适应普遍采用的高清分辨率
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$is_ios = strpos($user_agent, 'iPhone')? TRUE: FALSE;
			if ($is_ios):
			//$is_android = strpos($user_agent, 'Android')? TRUE: FALSE;
			//if ($is_ios || $is_android):
		?>
		<meta name=viewport content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=0">
		<?php else: ?>
		<meta name=viewport content="width=device-width">
		<?php endif ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!--[if (lt IE 9) & (!IEMobile)]>
			<script src="//cdn.key2all.com/js/html5.js"></script>
			<script src="//cdn.key2all.com/js/css3-mediaqueries.js"></script>
		<![endif]-->
		<script src="//cdn.key2all.com/js/jquery/new.js"></script>
		<!--<script src="<?php echo base_url() ?>js/xx.js"></script>-->

		<link rel=stylesheet media=all href="//cdn.key2all.com/css/normalize.css">
		<link rel=stylesheet media=all href="//cdn.key2all.com/css/reset.css">
		<link rel=stylesheet media=all href="//cdn.key2all.com/font-awesome/css/font-awesome.min.css">
		<link rel=stylesheet media=all href="<?php echo base_url() ?>css/style.css">

		<link rel="shortcut icon" href="//images.guangchecheng.com/logos/logo_32x32.png">
		<link rel=apple-touch-icon href="//images.guangchecheng.com/logos/logo_120x120.png">

		<link rel=canonical href="<?php echo current_url() ?>">

		<meta name=format-detection content="telephone=yes, address=no, email=no">
	</head>
<?php
	// 将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
	ob_flush();flush();
?>
<!-- 内容开始 -->
<?php
	/**
	 * APP中调用webview时配合URL按需显示相应部分
	 * 此处以在APP中以WebView打开页面时不显示页面header部分为例
	 */
	if ($this->input->get('from') != 'app'):
?>
	<body<?php echo (isset($class))? ' class="'.$class.'"': NULL; ?>>
		<header id=header role=banner>
			<div class=container>
				<h1>
					<a id=logo title="<?php echo SITE_NAME ?>" href="<?php echo base_url() ?>"><?php echo SITE_NAME ?></a>
				</h1>

				<a id=nav-switch class=nav-icon href="#header">
					<i class="fa fa-bars" aria-hidden=true></i>
				</a>
				<a class=nav-icon href="<?php echo base_url('order') ?>">
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
						<?php if ($this->session->logged_in != TRUE): ?>
						<li><a title="登录" href="<?php echo base_url('login') ?>">登录</a></li>
						<li><a title="注册" href="<?php echo base_url('register') ?>">注册</a></li>
						<?php else: ?>
						<li><a title="个人中心" href="<?php echo base_url('account') ?>">个人中心</a></li>
						<li><a title="退出" href="<?php echo base_url('logout') ?>">退出</a></li>
						<?php endif ?>
					</ul>
					<p id=tel-header>
						<i class="fa fa-phone" aria-hidden=true></i> 400-xxxx-xxx
					</p>
				</div>
			</div>
		</header>
<?php endif ?>

		<main id=maincontainer role=main>