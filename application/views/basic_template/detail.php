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
	<li class=active><?php echo $title ?></li>
</ol>

<div id=content class=container>
	<?php
	// 需要特定角色和权限进行该操作
	$current_role = $this->session->role; // 当前用户角色
	$current_level = $this->session->level; // 当前用户权限
	$role_allowed = array('管理员');
	$level_allowed = 1;
	if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
	?>
	<div class=btn-group role=group>
		<a type=button class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a type=button class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
		<a type=button class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
	</div>
	<?php endif ?>

	<dl id=list-info class=dl-horizontal>
		<dt><?php echo $this->class_name_cn ?>ID</dt>
		<dd><?php echo $item[$this->id_name] ?></dd>
		
		<?php
			$data_to_display = array(
				'name' => '名称',
				'description' => '说明',
				'description' => '说明',
				'flow_stuff' => '各阶段参与人',
				'flow_type' => '各阶段任务类别',
				'flow_mission' => '各阶段任务简述',
			);

			foreach ($data_to_display as $name => $name_cn):
				$html = '<dt>'. $name_cn. '</dt>';
				$html .= '<dd>'. $item[$name]. '</dd>';
				echo $html;
			endforeach;
		?>
	</dl>
	
	<div id=flow class=container-fluid>
		<h3>流程设置</h3>
		<ul class="list-group col-md-4">
		<?php
			$flow_stuff = explode(' ', $item['flow_stuff']);
			$flow_type = explode(' ', $item['flow_type']);
			$flow_mission = explode(' ', $item['flow_mission']);
			for ($i = 0; $i < count($flow_stuff); $i++):
				$current_stuff = ($flow_stuff[$i] !== 'me')? '查看审核者': '发起者';
				$html = '<li class=list-group-item>';
				if ($flow_stuff[$i] !== 'me'):
					$html .= '	<a href="'.base_url('stuff/detail?id='.$flow_stuff[$i]).'" target=new>'. $current_stuff. '</a>';
				else:
					$html .= $current_stuff;
				endif;
				$html .= ' '. $flow_type[$i].'</li>';

				echo $html;
			endfor;
		?>
		</ul>
	</div>

	<dl id=list-record class=dl-horizontal>
		<dt>创建时间</dt>
		<dd>
			<?php echo $item['time_create'] ?>
			<a href="<?php echo base_url('stuff/detail?id='.$item['creator_id']) ?>" target=new>查看创建者</a>
		</dd>
		<?php if ( ! empty($item['time_delete'])): ?>
		<dt>删除时间</dt>
		<dd>
			<?php echo $item['time_delete'] ?>
			<a href="<?php echo base_url('stuff/detail?id='.$item['operator_id']) ?>" target=new>查看删除者</a>
		</dd>
		<?php endif ?>
		<dt>最后编辑时间</dt>
		<dd>
			<?php echo $item['time_edit'] ?>
			<a href="<?php echo base_url('stuff/detail?id='.$item['operator_id']) ?>" target=new>查看最后操作者</a>
		</dd>
	</dl>
</div>