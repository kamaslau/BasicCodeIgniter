<link rel=stylesheet media=all href="/css/create.css">
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

<script defer src="/js/create.js"></script>

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
		$attributes = array('class' => 'form-'.$this->class_name.'-create form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/create', $attributes);
	?>
		<p class=help-block>必填项以“※”符号标示</p>
		
		<fieldset>
			<div class=form-group>
				<label for=url_image_main class="col-sm-2 control-label">主图</label>
                <div class=col-sm-10>
                    <p class=help-block>推荐上传正方形图片以达到最佳视觉效果</p>

                    <?php $name_to_upload = 'url_image_main' ?>
                    <ul class="upload_preview"></ul>

                    <div class=selector_zone>
                        <input id=<?php echo $name_to_upload ?> class=form-control type=file>
                        <input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo set_value($name_to_upload) ?>" >

                        <div class=file_selector><i class="fa fa-plus" aria-hidden=true></i></div>
                    </div>

                    <button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="<?php echo $this->class_name ?>/<?php echo $name_to_upload ?>" data-selector-id="<?php echo $name_to_upload ?>" data-input-name="<?php echo $name_to_upload ?>" data-max-count=1 type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>
                </div>
			</div>

			<div class=form-group>
				<label for=figure_image_urls class="col-sm-2 control-label">形象图</label>
                <div class=col-sm-10>
                    <p class=help-block>最多可上传4张</p>

                    <?php $name_to_upload = 'figure_image_urls' ?>
                    <ul class="upload_preview"></ul>

                    <div class=selector_zone>
                        <input id=<?php echo $name_to_upload ?> class=form-control type=file multiple>
                        <input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo set_value($name_to_upload) ?>">

                        <div class=file_selector><i class="fa fa-plus" aria-hidden=true></i></div>
                    </div>

                    <button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="<?php echo $this->class_name ?>/<?php echo $name_to_upload ?>" data-selector-id="<?php echo $name_to_upload ?>" data-input-name="<?php echo $name_to_upload ?>" data-max-count=4 type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>
                </div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>基本信息</legend>

			<div class=form-group>
				<label for=name class="col-sm-2 control-label">名称</label>
				<div class=col-sm-10>
					<input class=form-control name=name type=text value="<?php echo set_value('name') ?>" placeholder="名称" required>
				</div>
			</div>
			
			<div class=form-group>
				<label for=tag_price class="col-sm-2 control-label">参考价（万元）</label>
				<div class=col-sm-10>
					<input class=form-control name=tag_price type=number step=0.01 min=1.00 max=99999.99 value="<?php echo set_value('tag_price') ?>" placeholder="保留两位小数">
				</div>
			</div>

			<div class=form-group>
				<label for=price class="col-sm-2 control-label">商城价（万元）</label>
				<div class=col-sm-10>
					<input class=form-control name=price type=number step=0.01 min=0.00 max=99999.99 value="<?php echo set_value('price') ?>" placeholder="保留两位小数" required>
				</div>
			</div>

			<div class=form-group>
				<label for=userfile class="col-sm-2 control-label">主图</label>
				<div class=col-sm-10>
					<input class=form-control name=userfile type=file value="<?php echo set_value('userfile') ?>" placeholder="车版图片">
				</div>
			</div>

			<div class=form-group>
				<label for=description class="col-sm-2 control-label">详情</label>
				<div class=col-sm-10>
					<textarea class=form-control name=description rows=10 placeholder="详情" required><?php echo set_value('description') ?></textarea>
				</div>
			</div>

			<div class=form-group>
				<?php $input_name = 'delivery' ?>
				<label for="<?php echo $input_name ?>" class="col-sm-2 control-label">库存状态</label>
				<div class=col-sm-10>
                    <select class=form-control name="<?php echo $input_name ?>" required>
						<option value="" <?php echo set_select($input_name, '') ?>>请选择</option>
						<?php
							$options = array('现货','期货');
							foreach ($options as $option):
						?>
						<option value="<?php echo $option ?>" <?php echo set_select($input_name, $option) ?>><?php echo $option ?></option>
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
                                <option value="<?php echo $option['item_id'] ?>" <?php echo set_select($input_name, $option['item_id']) ?>><?php echo $option['name'] ?></option>
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
                <label for="<?php echo $input_name ?>" class="col-sm-2 control-label">模块一陈列商品</label>
                <div class=col-sm-10>
                    <select class=form-control name="<?php echo $input_name ?>" multiple>
                        <?php
                        $options = $comodities;
                        $current_array = $this->input->post($input_name);
                        foreach ($options as $option):
                            if ( empty($option['time_delete']) ):
                        ?>
						<option value="<?php echo $option['item_id'] ?>" <?php if ( in_array($option['item_id'], $current_array) ) echo 'selected'; ?>><?php echo $option['name'] ?></option>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </select>

                    <p class=help-block>需要进行展示的1-3款商品，下同；桌面端按住Ctrl或⌘键可多选；如果选择了3款以上，将仅示前3款</p>
                </div>
            </div>

			<div class=form-group>
				<label for=private class="col-sm-2 control-label">需登录</label>
				<div class=col-sm-10>
					<label class=radio-inline>
						<input type=radio name=private value="是" required <?php echo set_radio('private', '是', TRUE) ?>> 是
					</label>
					<label class=radio-inline>
						<input type=radio name=private value="否" required <?php echo set_radio('private', '否') ?>> 否
					</label>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>确定</button>
		    </div>
		</div>

	</form>

</div>