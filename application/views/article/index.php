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

<ol id=breadcrumb class="container horizontal">
	<li><?php echo $this->class_name_cn ?></li>
</ol>

<div id=content class=container>
	<?php
		// 需要特定角色权限进行该操作
		$manager_role = $this->session->role;
		$role_allowed = array('manager', 'editor');
		if (in_array($manager_role, $role_allowed)):
	?>
	<a class="btn btn-primary" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list"></i> 所有<?php echo $this->class_name_cn ?></a>
	<a class="btn btn-default" title="回收站" href="<?php echo base_url($this->view_root. 'trash') ?>"><i class="fa fa-trash"></i> 回收站</a>
	<a class="btn btn-primary" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->view_root.'/create') ?>"><i class="fa fa-plus"></i> 创建<?php echo $this->class_name_cn ?></a>
	<?php endif ?>

	<?php if (empty($items)): ?>
	<blockquote>
		<p>这里空空如也，快点添加<?php echo $this->class_name_cn ?>吧</p>
	</blockquote>

	<?php else: ?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th><?php echo $this->class_name_cn ?>ID</th><th>所属分类ID</th><th>标题</th><th>编辑记录</th><th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($items as $item): ?>
			<tr>
				<td><?php echo $item[$this->id_name] ?></td>
			    <td><?php echo $item['category_id'] ?></td>
			    <td><?php echo $item['title'] ?></td>
				<td>
					新建时间 <?php echo $item['time_create'] ?><br>
					最后编辑 <?php echo $item['time_edit'] ?><br>
					最后编辑者ID <?php echo $item['operator_id'] ?>
				</td>
				<td>
					<ul class=list-unstyled>
						<li><a title="查看" href="<?php echo base_url('article/detail?id='.$item['article_id']) ?>" target=_blank><i class="fa fa-eye"></i> 查看</a></li>
					<?php
					// 需要特定角色权限进行该操作
					$manager_role = $this->session->role;
					$role_allowed = array('manager', 'editor', 'operator');
					if (in_array($manager_role, $role_allowed)):
					?>
						<li><a title="编辑" href="<?php echo base_url($this->view_root.'edit?id='.$item['article_id']) ?>"><i class="fa fa-edit"></i> 编辑</a></li>
						<?php if ($article['status'] == 1): ?>
						<li><a title="转为草稿" href="<?php echo base_url($this->view_root.'draft?id='.$item['article_id']) ?>">&nbsp;<i class="fa fa-level-down"></i> 转为草稿</a></li>
						<?php else: ?>
						<!--
						<li><a title="公开发布" href="<?php echo base_url($this->view_root.'restore/'.$item['article_id'].'/1') ?>">&nbsp;<i class="fa fa-level-up"></i> 公开发布</a></li>
						-->
							<?php if ($article['status'] != 2): ?>
						<li><a title="删除" href="<?php echo base_url($this->view_root.'delete/'.$item['article_id']) ?>"><i class="fa fa-trash"></i> 删除</a></li>
							<?php endif ?>
						<?php endif ?>
					<?php endif ?>
					</ul>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>
</div>