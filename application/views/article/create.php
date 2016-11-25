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

<ol class=breadcrumb>
	<li><a href="<?php echo base_url() ?>">首页</a></li>
	<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
	<li class=active><?php echo $title ?></li>
</ol>

<div id=content>
	<ul class="nav nav-pills">
		<li role=presentation><a title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list"></i> 所有<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation class=active><a title="添加<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus"></i> 添加<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation><a title="回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash"></i> 回收站</a></li>
	</ul>

	<?php
		if (isset($error)) echo $error;
		$attributes = array('class' => 'form-'.$this->class_name.'-create form-horizontal', 'role' => 'form');
		echo form_open($this->class_name.'/create', $attributes);
	?>
		<fieldset>
			<div class=form-group>
				<label for=category_id class="col-sm-2 control-label">分类ID</label>
				<div class=col-sm-10>
					<input class=form-control name=category_id type=text value="<?php echo isset($category_id)? $category_id: set_value('category_id') ?>" placeholder="分类ID" required>
					<?php echo form_error('category_id') ?>
				</div>
			</div>
			<div class=form-group>
				<label for=title class="col-sm-2 control-label">标题</label>
				<div class=col-sm-10>
					<input class=form-control name=title type=text value="<?php echo set_value('title') ?>" placeholder="标题" required>
					<?php echo form_error('title') ?>
				</div>
			</div>
			<div class=form-group>
				<label for=excerpt class="col-sm-2 control-label">摘要</label>
				<div class=col-sm-10>
					<input class=form-control name=excerpt type=text value="<?php echo set_value('excerpt') ?>" placeholder="摘要（可留空）">
					<?php echo form_error('excerpt') ?>
				</div>
			</div>
			<div class=form-group>
				<label for=content class="col-sm-2 control-label">详情</label>
				<div class=col-sm-10>
					<textarea id=ueditor name=content placeholder="详情" rows=5 required><?php echo set_value('content') ?></textarea>
					<link rel="stylesheet" media=all href="<?php echo base_url('ueditor/themes/default/css/ueditor.min.css') ?>">
					<script src="<?php echo base_url('ueditor/ueditor.config.js') ?>"></script>
					<script src="<?php echo base_url('ueditor/ueditor.all.min.js') ?>"></script>
					<script src="<?php echo base_url('ueditor/lang/zh-cn/zh-cn.js') ?>"></script>
					<script>var ue = UE.getEditor('ueditor');</script>
					<?php echo form_error('content') ?>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-primary" type=submit>完成</button>
		    </div>
		</div>
	</form>
</div>