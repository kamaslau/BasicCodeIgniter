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

<div id=content class=container>
	<ul class="nav nav-pills">
		<li role=presentation><a title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list"></i> 所有<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation class=active><a title="添加<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus"></i> 添加<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation><a title="回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash"></i> 回收站</a></li>
	</ul>
	
	<p>请确保你正在使用<a class="btn btn-default" href="<?php echo base_url('每日资源表.xlsx') ?>" target=_blank>最新的每日资源表</a>；如果你觉得通过上传EXCEL表的方式管理车源信息是件麻烦事，不妨试试<a class="btn btn-default" title="添加<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>" target=_blank>直接创建单条车源信息</a></p>

	<?php
		if (isset($error)) echo $error;
		$attributes = array('class' => 'form-'.$this->class_name.'-upload form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/upload', $attributes);
	?>
		<fieldset>
			<div class=form-group>
				<label for=userfile class="col-sm-2 control-label">每日资源表</label>
				<div class=col-sm-10>
					<input class=form-control name=userfile type=file value="<?php echo set_value('userfile') ?>" placeholder="请确保你正在使用最新的每日资源表" required>
					<?php echo form_error('userfile') ?>
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