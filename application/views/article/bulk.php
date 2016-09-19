<ol class=breadcrumb>
	<li><a href="<?php echo base_url() ?>">首页</a></li>
	<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
	<li class=active><?php echo $title ?></li>
</ol>

<div id=content>
	<table class="table table-striped table-condensed table-responsive">
		<thead>
			<tr><th><?php echo $this->class_name_cn ?>ID</th><th>标题</th></tr>
		</thead>
		<tbody>
			<?php foreach ($items as $current_item): ?>
			<tr>
				<td><?php echo $current_item[$this->id_name] ?></td>
				<td><?php echo $current_item['title'] ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<blockquote>
		<p>确定要将上述<?php echo $this->class_name_cn ?>进行<?php echo $title ?></p>
	</blockquote>

	<?php
		if (isset($error)) echo $error;
		$attributes = array('class' => 'form-'.$this->class_name.'-delete form-horizontal', 'role' => 'form');
		echo form_open($this->class_name.'/delete', $attributes);
	?>
		<fieldset>
			<input name=ids type=hidden value="<?php echo implode('|', $ids) ?>">
			<div class=form-group>
				<label for=url_cn class="col-sm-2 control-label">密码</label>
				<div class=col-sm-10>
					<input class=form-control name=password type=password size=6 pattern="\d{6}" placeholder="请输入您的登录密码" autofocus required>
					<?php echo form_error('password') ?>
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