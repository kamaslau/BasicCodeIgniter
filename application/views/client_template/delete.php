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
	</div>

	<table class="table table-striped table-condensed table-responsive">
		<thead>
			<tr>
				<th><?php echo $this->class_name_cn ?>ID</th>
				<?php
					$thead = array_values($data_to_display);
					foreach ($thead as $th):
						echo '<th>' .$th. '</th>';
					endforeach;
				?>
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
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<div class="alert alert-warning" role=alert>
		<p>确定要<?php echo $title ?>？</p>
	</div>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-delete form-horizontal', 'role' => 'form');
		echo form_open($this->class_name.'/delete', $attributes);
	?>
		<fieldset>
			<input name=ids type=hidden value="<?php echo implode(',', $ids) ?>">
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-danger btn-lg btn-block" type=submit>删除</button>
		    </div>
		</div>

	</form>

</div>