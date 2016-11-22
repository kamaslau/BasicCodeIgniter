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
	<li><?php echo $this->class_name_cn ?>详情</li>
</ol>

<div id=content class=container>
	<ul class="nav nav-pills">
		<li role=presentation class=active><a title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list"></i> 所有<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation><a title="添加<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus"></i> 添加<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation><a title="回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash"></i> 回收站</a></li>
	</ul>

	<h2><?php echo $this->class_name_cn ?>详情</h2>
	<ul id=list-action class="list-unstyled list-inline">
		<?php
		// 仅限本人进行操作
		if ($item['creator_id'] === $this->session->stuff_id):
		?>
		<li><a title="编辑" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-edit"></i> 编辑</a></li>
		<li><a title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-trash"></i> 删除</a></li>
	<?php endif ?>
	</ul>

	<dl id=list-info class=dl-horizontal>
		<dt><?php echo $this->class_name_cn ?>ID</dt>
		<dd><?php echo $item[$this->id_name] ?></dd>

		<?php
		foreach ($data_to_process as $key):
			echo '<dt>'.$key[1].'</dt>';
			echo '<dd>'. $item[$key[0]]. '</dd>';
		endforeach;
		?>
	</dl>

	<dl id=list-record class=dl-horizontal>
		<dt>创建时间</dt>
		<dd><?php echo $item['time_create'] ?></dd>
		<dt>创建者ID</dt>
		<dd><?php echo $item['creator_id'] ?></dd>
		<?php if ( ! empty($item['time_delete'])): ?>
		<dt>删除时间</dt>
		<dd><?php echo $item['time_delete'] ?></dd>
		<?php endif ?>
		<dt>最后编辑时间</dt>
		<dd><?php echo $item['time_edit'] ?></dd>
		<dt>最后编辑者ID</dt>
		<dd><?php echo $item['operator_id'] ?></dd>
	</dl>
</div>