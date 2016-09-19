<style>


	/* 宽度在640像素以上的设备 */
	@media only screen and (min-width:641px)
	{

	}
	
	/* 宽度在960像素以上的设备 */
	@media only screen and (min-width:961px)
	{

	}

	/* 宽度在1280像素以上的设备 */
	@media only screen and (min-width:1281px)
	{

	}
</style>

<ol id=breadcrumb class="container horizontal">
	<li><?php echo $this->class_name_cn ?></li>
</ol>

<div id=content class=container>
	<div id=article-content>
		<?php
			// 如果是列表页，默认显示第一项的详情
			if (empty($item)) $item = $items[0];
		?>
		<h3 class=article-title><?php echo $item['title'] ?></h3>
		<section class=article-content><?php echo $item['content'] ?></section>
	</div>

	<div id=article-nav>
		<ul>
		<?php
			foreach ($items as $current_item):
			if ($current_item['article_id'] === $item['article_id']):
				$item_class = 'active';
			else:
				$item_class = NULL;
			endif;
		?>
			<li<?php echo $item_class === 'active'? ' class=active': NULL; ?>>
			    <a href="<?php echo base_url('article/detail?id='.$current_item['article_id']) ?>" target=_blank><?php echo $current_item['title'] ?></a>
			</li>
		<?php endforeach ?>
		</ul>
	</div>
</div>