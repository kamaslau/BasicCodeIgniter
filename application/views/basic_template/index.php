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

<ol id=breadcrumb class=breadcrumb>
	<li><a href="<?php echo base_url() ?>">首页</a></li>
	<li class=active><?php echo $this->class_name_cn ?></li>
</ol>

<div id=content>
	<div class=btn-group role=group>
		<a type=button class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
		<?php
		// 需要特定角色和权限进行该操作
		$role_allowed = array('管理员');
		$level_allowed = 1;
		if (in_array($this->session->role, $role_allowed) & $this->session->level >= $level_allowed):
		?>
	  	<a type=button class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
	  	<a type=button class="btn btn-default" title="回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
		<?php endif ?>
	</div>

	<?php if (empty($items)): ?>
	<blockquote>
		<p>这里空空如也，快点添加<?php echo $this->class_name_cn ?>吧</p>
	</blockquote>

	<?php
		else:
			$data_to_display = array(
				'name' => '名称',
				'name' => '名称',
				'name' => '名称',
			);
	?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th><?php echo $this->class_name_cn ?>ID</th>
				<?php
					$thead = array_values($data_to_display);
					foreach ($thead as $th):
						echo '<th>' .$th. '</th>';
					endforeach;
				?>
				<th>编辑记录</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
		<?php foreach ($items as $item): ?>
			<tr>
				<td><?php echo $item[$this->id_name] ?></td>
				<?php
					$tr = array_keys($data_to_display);
					foreach ($tr as $td):
						echo '<td>' .$item[$td]. '</td>';
					endforeach;
				?>
				<td>
					创建时间 <?php echo $item['time_create'] ?><br>
					<a href="<?php echo base_url('stuff/detail?id='.$item['creator_id']) ?>" target=new>查看创建者</a><br>
					最后编辑 <?php echo $item['time_edit'] ?><br>
					<a href="<?php echo base_url('stuff/detail?id='.$item['operator_id']) ?>" target=new>查看最后操作者</a>
				</td>
				<td>
					<ul class=list-unstyled>
						<li><a title="查看" href="<?php echo base_url($this->view_root.'/detail?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-eye"></i> 查看</a></li>
					<?php
					// 需要本人，或特定角色和权限进行该操作
					$role_allowed = array('管理员');
					$level_allowed = 1;
					if ( ($item['creator_id'] === $this->session->stuff_id) OR (in_array($this->session->role, $role_allowed) AND $this->session->level >= $level_allowed) ):
					?>
						<li><a title="编辑" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-edit"></i> 编辑</a></li>
						<li><a title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-trash"></i> 删除</a></li>
					<?php endif ?>
					</ul>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>
</div>