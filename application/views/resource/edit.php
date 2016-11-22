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

	<?php
		if (isset($error)) echo $error;
		$attributes = array('class' => 'form-'.$this->class_name.'-edit form-horizontal', 'role' => 'form');
		echo form_open($this->class_name.'/edit?id='.$item[$this->id_name], $attributes);
	?>
		<fieldset>
			<legend>经销商</legend>
			<?php
			for ($i=0; 0 <= $i && $i <= 3; $i++):
				$input = $data_to_process[$i];
				$this->basic->generate_input($input, 'edit', $item);
			endfor;
			?>
		</fieldset>
		<fieldset>
			<legend>车况</legend>
			<?php
			for ($i=4; 4 <= $i && $i <= 9; $i++):
				$input = $data_to_process[$i];
				$this->basic->generate_input($input, 'edit', $item);
			endfor;
			?>
		</fieldset>
		<fieldset>
			<legend>价格</legend>
			<?php
			for ($i=10; 10 <= $i && $i < count($data_to_process); $i++):
				$input = $data_to_process[$i];
				$this->basic->generate_input($input, 'edit', $item);
			endfor;
			?>
		</fieldset>

		<div class=form-group>
		    <div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-primary" type=submit>保存</button>
		    </div>
		</div>
	</form>
</div>