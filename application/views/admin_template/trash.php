<link rel=stylesheet media=all href="/css/trash.css">
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

<script defer src="/js/trash.js"></script>

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php
	// 需要特定角色和权限进行该操作
	$current_role = $this->session->role; // 当前用户角色
	$current_level = $this->session->level; // 当前用户级别
	$role_allowed = array('管理员', '经理');
	$level_allowed = 30;
	if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
	?>
	<div class="btn-group btn-group-justified" role=group>
		<a class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>">所有</a>
	  	<a class="btn btn-primary" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>">回收站</a>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>">创建</a>
	</div>
	<?php endif ?>

	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>没有任何<?php echo $this->class_name_cn ?>曾经被删除。</p>
	</blockquote>

	<?php else: ?>
	<form method=get target=_blank>
        <?php if (count($items) > 1): ?>
        <div id=bulk_action class=action_bottom>
            <span id=bulk_selector data-bulk-selector=off>
                <i class="fa fa-circle-o" aria-hidden=true></i>全选
            </span>
            <ul class=horizontal>
                <li>
                    <button class=bg_primary formaction="<?php echo base_url($this->class_name.'/restore') ?>" type=submit>恢复</button>
                </li>
            </ul>
        </div>
        <?php endif ?>

        <ul id=item-list class=row>
            <?php foreach ($items as $item): ?>
            <li>

                <a href="<?php echo base_url($this->class_name.'/detail?id='.$item[$this->id_name]) ?>">
                    <p><?php echo $this->class_name_cn ?>ID <?php echo $item[$this->id_name] ?></p>
                    <p><?php echo $item['name'] ?></p>
                    <p><?php echo trim($item['province']. ''.$item['city']. ''.$item['county']) ?></p>
                </a>

                <div class=item-actions>
                <span>
                    <input name=ids[] class=form-control type=checkbox value="<?php echo $item[$this->id_name] ?>">
                </span>

                    <ul class=horizontal>
                        <?php
                        // 需要特定角色和权限进行该操作
                        if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
                            ?>
                            <li><a title="恢复" href="<?php echo base_url($this->class_name.'/restore?ids='.$item[$this->id_name]) ?>" target=_blank>恢复</a></li>

                            <li class=color_primary><a title="编辑" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank>编辑</a></li>
                        <?php endif ?>
                    </ul>
                </div>

            </li>
            <?php endforeach ?>
        </ul>

	</form>
	<?php endif ?>
</div>