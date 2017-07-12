// 外部容器
<div class=form-group>
	<label for=name class="col-sm-2 control-label">名称</label>
	<div class=col-sm-10>
		
	</div>
</div>

// 仅显示文本
<p class="form-control-static">email@example.com</p>

【创建】
// 一般文本输入域
<input class=form-control name=name type=text value="<?php echo set_value('name') ?>" placeholder="名称" required>

// 文件
<input class=form-control name=userfile type=file value="<?php echo set_value('userfile') ?>" placeholder="车版图片">

// 长文本输入域
<textarea class=form-control name=description rows=10 placeholder="详情" required><?php echo set_value('description') ?></textarea>

// 数字（货币）
<input class=form-control name=price type=number step=0.01 min=0.00 max=99999.99 value="<?php echo set_value('price') ?>" placeholder="保留两位小数" required>

// 下拉列表
<?php
	$input_name = 'delivery';
?>
<select class=form-control name="<?php echo $input_name ?>" required>
	<option value="" <?php echo set_select($input_name, '') ?>>请选择</option>
	<?php
		$options = array('现货', '期货',);
		foreach ($options as $option):
	?>
	<option value="<?php echo $option ?>" <?php echo set_select($input_name, $option) ?>><?php echo $option ?></option>
	<?php endforeach ?>
</select>

// 单选组
<?php
	$input_name = 'private';
	$options = array('是', '否',);
	foreach ($options as $option):
?>
<label class=radio-inline>
	<input type=radio name="<?php echo $input_name ?>" value="<?php echo $option ?>" required <?php echo set_radio($input_name, $option, TRUE) ?>> <?php echo $option ?>
</label>


【编辑】
// 一般文本输入域
<input class=form-control name=name type=text value="<?php echo $item['name'] ?>" placeholder="名称" required>

// 文件
<input class=form-control name=userfile type=file value="<?php echo $item['userfile'] ?>" placeholder="车版图片">

// 长文本输入域
<textarea class=form-control name=description rows=10 placeholder="详情" required><?php echo $item['description'] ?></textarea>

// 数字（货币）
<input class=form-control name=price type=number step=0.01 min=0.00 max=99999.99 value="<?php echo $item['price'] ?>" placeholder="保留两位小数" required>

// 下拉列表
<?php
	$input_name = 'delivery';
?>
<select class=form-control name="<?php echo $input_name ?>" required>
	<?php
		$options = array('现货', '期货',);
		foreach ($options as $option):
	?>
	<option value="<?php echo $option ?>" <?php if ($option === $item[$input_name]) echo 'selected'; ?>><?php echo $option ?></option>
	<?php endforeach ?>
</select>

// 单选组
<?php
	$input_name = 'private';
	$options = array('是', '否',);
	foreach ($options as $option):
?>
<label class=radio-inline>
	<input type=radio name="<?php echo $input_name ?>" value="<?php echo $option ?>" required <?php if ($item[$input_name] === $option) echo 'checked'; ?>> <?php echo $option ?>
</label>