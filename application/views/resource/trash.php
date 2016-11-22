<ol class=breadcrumb>
	<li><a href="<?php echo base_url() ?>">首页</a></li>
	<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
	<li class=active><?php echo $title ?></li>
</ol>

<div id=content class=container>
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
			<?php
			$ids_value = '';
			for ($i=0;$i<count($ids);$i++):
				$ids_value .= $ids[$i][$this->id_name];
				if ($i < (count($ids) - 1)) $ids_value .= '|';
			endfor;
			?>
			<input name="ids[]" type=checkbox value="<?php echo $ids_value ?>">
			<label>全选</label>
		</div>
		<div class=btn-group role=group>
			<button formaction="<?php echo base_url($this->class_name.'/restore') ?>" type=submit class="btn btn-default">恢复</button>
		</div>
		<table class="table table-condensed table-hover table-responsive table-striped sortable">
			<thead>
				<tr>
					<th>&nbsp;</th>
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
					<td>
						<input name="ids[]" type=checkbox value="<?php echo $item[$this->id_name] ?>">
					</td>
					<td><?php echo $item[$this->id_name] ?></td>
					<?php
					foreach ($data_to_process as $key):
						echo '<td>'. $item[$key[0]]. '</td>';
					endforeach;
					?>
					<td>
						删除时间 <?php echo $item['time_delete'] ?>
						<hr>
						创建时间 <?php echo $item['time_create'] ?><br>
						创建者ID： <?php echo $item['creator_id'] ?><br>
						最后编辑 <?php echo $item['time_edit'] ?>
						最后操作者ID <a href="<?php echo base_url('stuff/'.$item['operator_id']) ?>" target=_blank>查看</a>
					</td>
					<td>
						<ul class=list-unstyled>
							<li><a title="查看" href="<?php echo base_url($this->view_root.'/detail?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-eye"></i> 查看</a></li>
							<?php
							// 仅限本人进行操作
							if ($item['creator_id'] === $this->session->stuff_id):
							?>
							<li><a title="编辑" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-edit"></i> 编辑</a></li>
							<li><a title="恢复" href="<?php echo base_url($this->class_name.'/restore?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-level-up"></i> 恢复</a></li>
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