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
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<div class=btn-group role=group>
		<a class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
	</div>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-edit form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/edit?id='.$item[$this->id_name], $attributes);
	?>
		<fieldset>
			<legend>基本信息</legend>
			
			<input name=id type=hidden value="<?php echo $item[$this->id_name] ?>">

			<div class=form-group>
				<label for=name class="col-sm-2 control-label">名称</label>
				<div class=col-sm-10>
					<input class=form-control name=name type=text value="<?php echo $item['name'] ?>" placeholder="名称" required>
					<?php echo form_error('name') ?>
				</div>
			</div>
			
			<div class=form-group>
				<label for=tag_price class="col-sm-2 control-label">参考价（万元）</label>
				<div class=col-sm-10>
					<input class=form-control name=tag_price type=number step=0.01 min=1.00 max=99999.99 value="<?php echo $item['tag_price'] ?>" placeholder="保留两位小数">
				</div>
			</div>

			<div class=form-group>
				<label for=price class="col-sm-2 control-label">商城价（万元）</label>
				<div class=col-sm-10>
					<input class=form-control name=price type=number step=0.01 min=0.00 max=99999.99 value="<?php echo $item['price'] ?>" placeholder="保留两位小数" required>
				</div>
			</div>
			
			<div class=form-group>
				<label for=userfile class="col-sm-2 control-label">主图</label>
				<div class=col-sm-10>
					<input class=form-control name=userfile type=file value="<?php echo $item['userfile'] ?>" placeholder="车版图片">
				</div>
			</div>

			<div class=form-group>
				<label for=description class="col-sm-2 control-label">详情</label>
				<div class=col-sm-10>
					<textarea class=form-control name=description rows=10 placeholder="详情" required><?php echo $item['description'] ?></textarea>
				</div>
			</div>

			<div class=form-group>
				<label for=delivery class="col-sm-2 control-label">库存状态</label>
				<div class=col-sm-10>
					<select class=form-control name=delivery required>
						<?php
							$input_name = 'delivery';
							$options = array('现货','期货');
							foreach ($options as $option):
						?>
						<option value="<?php echo $option ?>" <?php if ($option === $item[$input_name]) echo 'selected'; ?>><?php echo $option ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class=form-group>
				<label for=private class="col-sm-2 control-label">需登录</label>
				<div class=col-sm-10>
					<label class=radio-inline>
						<input type=radio name=private value="是" required <?php if ($item['private'] === '1') echo 'checked'; ?>> 是
					</label>
					<label class=radio-inline>
						<input type=radio name=private value="否" required <?php if ($item['private'] === '0') echo 'checked'; ?>> 否
					</label>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>保存</button>
		    </div>
		</div>

	</form>

</div>