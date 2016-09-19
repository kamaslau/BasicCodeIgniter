<ol class=breadcrumb>
	<li><a href="<?php echo base_url() ?>">首页</a></li>
	<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
	<li class=active><?php echo $title ?></li>
</ol>

<ul class="nav nav-pills">
	<li role=presentation><a title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list"></i> 所有<?php echo $this->class_name_cn ?></a></li>
  	<li role=presentation><a title="添加<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus"></i> 添加<?php echo $this->class_name_cn ?></a></li>
  	<li role=presentation class=active><a title="回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash"></i> 回收站</a></li>
</ul>

	<?php if (empty($items)): ?>
	<blockquote>
		<p>没有任何<?php echo $this->class_name_cn ?>曾经被删除。</p>
	</blockquote>

	<?php else: ?>
	<form method=post target=_blank>
		<div class=form-group>
			<input name="ids[]" type=checkbox value="<?php echo implode('|', $ids) ?>">
			<label>全选</label>
		</div>
		<div class=btn-group role=group>
			<button formaction="<?php echo base_url('color/restore') ?>" type=submit class="btn btn-default">恢复</button>
		</div>
		<table class="table table-condensed table-hover table-responsive table-striped sortable">
			<thead>
				<tr>
					<th>颜色ID</th><th>名称</th><th>颜色码</th><th>编辑记录</th><th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($colors as $color): ?>
				<tr>
					<td><input name="ids[]" type=checkbox value="<?php echo $color['color_id']?>"></td>
					<td><?php echo $color['color_id'] ?></td>
				    <td>
						<span style="background-color:#<?php echo $color['hex'] ?>">&nbsp;</span>
						<?php echo $color['name'] ?>
					</td>
				    <td>
						16进制 #<?php echo $color['hex'] ?><br>
						RGB rgb(<?php echo $color['rgb']? $color['rgb']: '未设置，应为'.hex2rgb($color['hex']) ?>)
					</td>
					<td>
						删除时间 <?php echo $color['time_delete'] ?>
						<hr>
						新建时间 <?php echo $color['time_create'] ?><br>
						最后编辑 <?php echo $color['time_edit'] ?>
						最后操作员工 <a href="<?php echo base_url('stuff/'.$color['operator_id']) ?>" target=_blank>ID <?php echo $color['operator_id'] ?></a>
					</td>
					<td>
						<ul class=list-unstyled>
							<li><a title="查看" href="<?php echo base_url('color/'.$color['color_id']) ?>" target=_blank><i class="fa fa-eye"></i> 查看</a></li>
						<?php
						// 需要特定角色权限进行该操作
						$manager_role = $this->session->role;
						$role_allowed = array('manager', 'editor', 'operator');
						if (in_array($manager_role, $role_allowed)):
						?>
							<li><a title="编辑" href="<?php echo base_url('color/edit/'.$color['color_id']) ?>"><i class="fa fa-edit"></i> 编辑</a></li>
							<li><button name=ids[] value="<?php echo $color['color_id']?>" formaction="<?php echo base_url('color/restore') ?>" type=submit class="btn btn-default">恢复</button></li>
						<?php endif ?>
						</ul>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	
	</form>
	<?php endif ?>
</div>