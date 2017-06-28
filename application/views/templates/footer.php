		</main>
<!-- End #maincontainer -->

		<footer id=footer role=contentinfo>
		<?php
			// 若通过微信访问，则不显示部分内容
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$is_wechat = strpos($user_agent, 'MicroMessenger')? TRUE: FALSE;
			if ( ! $is_wechat):
		?>
			<div class=container>
				<!-- 页面底部导航、文章列表等 -->
				<p>这个容器中的内容在微信中会被隐藏。</p>
			</div>
		<?php endif ?>

			<div id=copyright>
				<div class=container>
					<p>&copy;<?php echo date('Y') ?>
					
					<a title="<?php echo SITE_DESCRIPTION ?>" href="<?php echo base_url() ?>"><?php echo SITE_NAME ?></a>

					<?php if ( !empty(ICP_NUMBER)): ?>
					<a title="工业和信息化部网站备案系统" href="http://www.miitbeian.gov.cn/" target=_blank rel=nofollow><?php echo ICP_NUMBER ?></a>
					<?php endif ?>

					<a id=support title="访问BasicCodeigniter的Github主页" href="https://github.com/kamaslau/BasicCodeigniter" target=_blank>此站点由BasicCodeigniter驱动</a></p>
				</div>
			</div>

			<a id=totop title="回到页首" href="#"><i class="fa fa-chevron-up" aria-hidden=true></i></a>
		</footer>

		<script>
			$(function(){
				// 回到页首按钮
				$('a#totop').click(function()
				{
					$('body,html').stop(false, false).animate({scrollTop:0}, 800);
					return false;
				});
			});
		</script>
	</body>
</html>