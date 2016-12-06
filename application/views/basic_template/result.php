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

<ol id=breadcrumb class=breadcrumb>
  	<li><a href="<?php echo base_url() ?>">首页</a></li>
  	<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
	<li class=active><?php echo $title ?></li>
</ol>

<div id=content>
	<div class=btn-group role=group>
		<a type=button class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
		<?php
		// 需要特定角色和权限进行该操作
		$role_allowed = array('管理员');
		$level_allowed = 1;
		if (in_array($this->session->role, $role_allowed) & $this->session->level >= $level_allowed):
		?>
	  	<a type=button class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
	  	<a type=button class="btn btn-default" title="回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
		<?php endif ?>
	</div>

	<h2><?php echo $title ?></h2>
	<?php echo $content ?>
</div>