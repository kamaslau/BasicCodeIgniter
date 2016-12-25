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
	<li><a href="<?php echo base_url() ?>">首页</a></li>
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
		<a type=button class="btn btn-primary" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
	</div>
	<?php endif ?>

	<?php
		if (isset($error)) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-create form-horizontal', 'role' => 'form');
		echo form_open($this->class_name.'/create', $attributes);
	?>
		<fieldset>
			<legend>表单分区标题</legend>
			
			<div class=form-group>
				<label for=flow_stuff class="col-sm-2 control-label">各阶段参与人</label>
				<div class=col-sm-10>
					<input class=form-control name=flow_stuff type=text value="<?php echo set_value('flow_stuff') ?>" placeholder="各阶段参与人stuff_id；如有多个项目，各项目间用一个空格分隔">
					<?php echo form_error('flow_stuff') ?>
				</div>
			</div>
			<div class=form-group>
				<label for=flow_type class="col-sm-2 control-label">各阶段任务类别</label>
				<div class=col-sm-10>
					<input class=form-control name=flow_type type=text value="<?php echo set_value('flow_type') ?>" placeholder="各阶段任务类别；如有多个项目，各项目间用一个空格分隔；完善信息、同意、不同意、知悉等">
					<?php echo form_error('flow_type') ?>
				</div>
			</div>
			<div class=form-group>
				<label for=flow_mission class="col-sm-2 control-label">各阶段任务简述</label>
				<div class=col-sm-10>
					<input class=form-control name=flow_mission type=text value="<?php echo set_value('flow_mission') ?>" placeholder="各阶段任务简述；如有多个项目，各项目间用一个空格分隔">
					<?php echo form_error('flow_mission') ?>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-primary" type=submit>确定</button>
		    </div>
		</div>
	</form>
</div>