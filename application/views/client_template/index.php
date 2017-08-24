<style>


	/* 宽度在750像素以上的设备 */
	@media only screen and (min-width:751px)
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

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li class=active><?php echo $this->class_name_cn ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php if ( isset($content) ) echo '<div class="alert alert-warning" role=alert>'.$content.'</div>'; ?>

	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>这里空空如也……</p>
	</blockquote>

	<?php else: ?>
		<ul id=item-list class=row>
		<?php foreach ($items as $item): ?>

			<li class="item col-xs-6 col-sm-4 col-md-3" data-item-id="<?php echo $item[$this->id_name] ?>">
				<?php if ( strpos(DEVELOPER_MOBILES, ','.$this->session->mobile.',') !== FALSE ): ?>
				<span>ID <?php echo $item[$this->id_name] ?></span>
				<?php endif ?>

				<section class=row>
					<a title="<?php echo $item['name'] ?>" href="<?php echo base_url($this->class_name. '/detail?id='.$item[$this->id_name]) ?>">
						<h2 class=biz-name><?php echo $item['name'] ?></h2>
					</a>
				</section>

				<ul class=row>
					<li class="col-xs-6">
						<a class=delete data-op-class=<?php echo $this->class_name ?> data-op-name=delete data-id="<?php echo $item[$this->id_name] ?>" title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-trash"></i> 删除</a>
					</li>
				</ul>
			</li>

		<?php endforeach ?>
		</ul>
	<?php endif ?>
</div>