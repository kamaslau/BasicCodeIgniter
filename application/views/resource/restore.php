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

	<table class="table table-striped table-condensed table-responsive">
		<thead>
			<tr>
				<th><?php echo $this->class_name_cn ?>ID</th>
				<?php
				foreach ($data_to_process as $key):
					echo '<th>'. $key[1]. '</th>';
				endforeach;
				?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($items as $item): ?>
			<tr>
				<td><?php echo $item[$this->id_name] ?></td>
				<?php
				foreach ($data_to_process as $key):
					echo '<td>'. $item[$key[0]]. '</td>';
				endforeach;
				?>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<blockquote>
		<p>确定要<?php echo $title ?>？</p>
	</blockquote>

	<?php
		if (isset($error)) echo $error;
		$attributes = array('class' => 'form-'.$this->class_name.'-restore form-horizontal', 'role' => 'form');
		echo form_open($this->class_name.'/restore', $attributes);
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