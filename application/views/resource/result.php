<ol class=breadcrumb>
  	<li><a href="<?php echo base_url() ?>">首页</a></li>
  	<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
	<li class=active><?php echo $title ?></li>
</ol>

<div id=content>
	<h2><?php echo $title ?></h2>
	<p><?php echo $content ?></p>
	<p>
		<a class="btn btn-primary" title="<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?>首页</a>
		<a class="btn btn-secondary" title="<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>/create">创建<?php echo $this->class_name_cn ?></a>
	</p>
</div>