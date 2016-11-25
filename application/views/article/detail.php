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

<ol id=breadcrumb class="breadcrumb container">
	<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
	<li><?php echo $item['title'] ?></li>
</ol>

<div id=content class=container>
	<div id=article-content>
		<h3 id=article-title><?php echo $item['title'] ?></h3>
		<ul id=meta-list>
			<li>创建时间 <?php echo $item['time_create'] ?></li>
			<li>最后编辑 <?php echo $item['time_edit'] ?></li>
			<li>最后编辑者ID <?php echo $item['operator_id'] ?></li>
		</ul>
		<section class=article-content><?php echo $item['content'] ?></section>
	</div>

	<aside id=article-nav>
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
			    <a href="<?php echo base_url('article/'.$current_item['article_id']) ?>"><?php echo $current_item['title'] ?></a>
			</li>
		<?php endforeach ?>
		</ul>
	</aside>
</div>