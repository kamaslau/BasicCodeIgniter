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

<ol id=breadcrumb class="breadcrumb container">
	<li><?php echo $this->class_name_cn ?></li>
</ol>

<div id=content class=container>
	<ul class="nav nav-pills">
		<li role=presentation class=active><a title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list"></i> 所有<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation><a title="添加<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus"></i> 添加<?php echo $this->class_name_cn ?></a></li>
	  	<li role=presentation><a title="回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash"></i> 回收站</a></li>
	</ul>

	<?php if (empty($items)): ?>
	<blockquote>
		<p>这里空空如也，快点添加<?php echo $this->class_name_cn ?>吧。</p>
	</blockquote>

	<?php else: ?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th><?php echo $this->class_name_cn ?>ID</th>
				<?php
				foreach ($data_to_process as $key):
					echo '<th>'. $key[1]. '</th>';
				endforeach;
				?>
				<th>编辑记录</th><th>操作</th>
			</tr>
		</thead>

		<tbody>
		<?php foreach ($items as $item): ?>
			<tr>
				<td><?php echo $item[$this->id_name] ?></td>
				<?php
				foreach ($data_to_process as $key):
					echo '<td>'. $item[$key[0]]. '</th>';
				endforeach;
				?>
				<td>
					创建时间 <?php echo $item['time_create'] ?><br>
					创建者ID： <?php echo $item['creator_id'] ?>
				</td>
				<td>
					<ul class=list-unstyled>
						<li><a title="查看" href="<?php echo base_url($this->view_root.'/detail?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-eye"></i> 查看</a></li>
						<?php
						// 仅限本人进行操作
						if ($item['creator_id'] === $this->session->stuff_id):
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