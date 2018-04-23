<link rel=stylesheet media=all href="/css/edit.css">
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

<script defer src="/js/edit.js"></script>

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
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-edit form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/edit?id='.$item[$this->id_name], $attributes);
	?>
		<p class=help-block>必填项以“※”符号标示</p>
	
		<fieldset>
			<div class=form-group>
				<label for=url_image_main class="col-sm-2 control-label">主图</label>
                <div class=col-sm-10>
                    <p class=help-block>正方形图片视觉效果最佳</p>

                    <?php $name_to_upload = 'url_image_main' ?>
                    <ul class=upload_preview>
                        <?php if ( !empty($item[$name_to_upload]) ): ?>

                            <li data-input-name="<?php echo $name_to_upload ?>" data-item-url="<?php echo $item[$name_to_upload] ?>">
                                <i class="remove fa fa-minus"></i>
                                <i class="left fa fa-arrow-left"></i>
                                <i class="right fa fa-arrow-right"></i>
                                <figure>
                                    <img src="<?php echo $item[$name_to_upload] ?>">
                                </figure>
                            </li>

                        <?php endif ?>
                    </ul>

                    <div class=selector_zone>
                        <input id=<?php echo $name_to_upload ?> class=form-control type=file>
                        <input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

                        <div class=file_selector><i class="fa fa-plus" aria-hidden=true></i></div>
                    </div>

                    <button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="<?php echo $this->class_name.'/'.$name_to_upload ?>" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> data-max-count=1 type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>
                </div>
			</div>

			<div class=form-group>
				<label for=figure_image_urls class="col-sm-2 control-label">形象图</label>
                <div class=col-sm-10>
                    <?php $name_to_upload = 'figure_image_urls' ?>
                    <ul class=upload_preview>
                        <?php if ( !empty($item[$name_to_upload]) ): ?>

                            <?php
                            $figure_image_urls = explode(',', $item[$name_to_upload]);
                            foreach($figure_image_urls as $url):
                                ?>
                                <li data-input-name="<?php echo $name_to_upload ?>" data-item-url="<?php echo $url ?>">
                                    <i class="remove fa fa-minus"></i>
                                    <i class="left fa fa-arrow-left"></i>
                                    <i class="right fa fa-arrow-right"></i>
                                    <figure>
                                        <img src="<?php echo $url ?>">
                                    </figure>
                                </li>
                            <?php endforeach ?>

                        <?php endif ?>
                    </ul>

                    <div class=selector_zone>
                        <input id=<?php echo $name_to_upload ?> class=form-control type=file multiple>
                        <input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

                        <div class=file_selector><i class="fa fa-plus" aria-hidden=true></i></div>
                    </div>

                    <button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="<?php echo $this->class_name.'/'.$name_to_upload ?>" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> data-max-count=4 type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>
					
					<p class=help-block>最多可上传4张</p>
                </div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>基本信息</legend>
			
			<input name=id type=hidden value="<?php echo $item[$this->id_name] ?>">

			<div class=form-group>
				<label for=name class="col-sm-2 control-label">名称</label>
				<div class=col-sm-10>
					<input class=form-control name=name type=text value="<?php echo $item['name'] ?>" placeholder="名称" required>
					<?php echo form_error('name') ?>
				</div>
			</div>
			
			<div class=form-group>
				<label for=tag_price class="col-sm-2 control-label">参考价（万元）</label>
				<div class=col-sm-10>
					<input class=form-control name=tag_price type=number step=0.01 min=1.00 max=99999.99 value="<?php echo $item['tag_price'] ?>" placeholder="保留两位小数">
				</div>
			</div>

			<div class=form-group>
				<label for=price class="col-sm-2 control-label">商城价（万元）</label>
				<div class=col-sm-10>
					<input class=form-control name=price type=number step=0.01 min=0.00 max=99999.99 value="<?php echo $item['price'] ?>" placeholder="保留两位小数" required>
				</div>
			</div>
			
			<div class=form-group>
				<label for=userfile class="col-sm-2 control-label">主图</label>
				<div class=col-sm-10>
					<input class=form-control name=userfile type=file value="<?php echo $item['userfile'] ?>" placeholder="车版图片">
				</div>
			</div>

			<div class=form-group>
				<label for=description class="col-sm-2 control-label">详情</label>
				<div class=col-sm-10>
					<textarea class=form-control name=description rows=10 placeholder="详情" required><?php echo $item['description'] ?></textarea>
				</div>
			</div>

			<div class=form-group>
				<?php $input_name = 'delivery' ?>
				<label for="<?php echo $input_name ?>" class="col-sm-2 control-label">库存状态</label>
				<div class=col-sm-10>
					<select class=form-control name="<?php echo $input_name ?>" required>
						<?php
							$options = array('现货','期货');
							foreach ($options as $option):
						?>
						<option value="<?php echo $option ?>" <?php if ($option === $item[$input_name]) echo 'selected'; ?>><?php echo $option ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			
            <div class=form-group>
				<?php $input_name = 'home_m1_ace_id' ?>
                <label for="<?php echo $input_name ?>" class="col-sm-2 control-label">模块一首推商品</label>
                <div class=col-sm-10>
                    <select class=form-control name="<?php echo $input_name ?>">
                        <?php
                        $options = $comodities;
                        foreach ($options as $option):
                            if ( empty($option['time_delete']) ):
                                ?>
                                <option value="<?php echo $option['item_id'] ?>" <?php if ($option['item_id'] === $item[$input_name]) echo 'selected'; ?>><?php echo $option['name'] ?></option>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </select>

                    <p class=help-block>点击形象图后跳转到的商品，下同</p>
                </div>
            </div>

            <div class=form-group>
				<?php $input_name = 'home_m1_ids[]' ?>
                <label for=home_m1_ids class="col-sm-2 control-label">模块一陈列商品</label>
                <div class=col-sm-10>
                    <select class=form-control name="<?php echo $input_name ?>" multiple>
                        <?php
                        $options = $comodities;
                        $current_array = explode(',', $item['home_m1_ids']);
                        foreach ($options as $option):
                            if ( empty($option['time_delete']) ):
                                ?>
                                <option value="<?php echo $option['item_id'] ?>" <?php if ( in_array($option['item_id'], $current_array) ) echo 'selected'; ?>><?php echo $option['name'] ?></option>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </select>

                    <p class=help-block>需要进行展示的1-3款商品，下同；桌面端按住Ctrl（Windows）或⌘（Mac）可多选；如果选择了3款以上，将仅示前3款</p>
                </div>
            </div>

			<div class=form-group>
				<label for=private class="col-sm-2 control-label">需登录</label>
				<div class=col-sm-10>
					<label class=radio-inline>
						<input type=radio name=private value="是" required <?php if ($item['private'] === '1') echo 'checked' ?>> 是
					</label>
					<label class=radio-inline>
						<input type=radio name=private value="否" required <?php if ($item['private'] === '0') echo 'checked' ?>> 否
					</label>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>保存</button>
		    </div>
		</div>

	</form>

</div>