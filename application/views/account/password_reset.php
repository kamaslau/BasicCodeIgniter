<style>

/* 宽度在960像素以上的设备 */
@media only screen and (min-width:961px)
{

}
</style>

<script>
	$(function(){

	});
</script>

<noscript>您的浏览器目前不支持JavaScript，请更换浏览器或检查相关设置。</noscript>

<div id=content class=container>
	<h2><?php echo $title ?></h2>
	<?php
		if (isset($error)) echo $error; //若有错误提示信息则显示
		$attributes = array('class' => 'form-password-reset', 'role' => 'form');
		echo form_open('password_reset', $attributes);
	?>
		<fieldset>
			<div class=input-group>
				<label for=password_new>新密码</label>
				<div>
					<input name=password_new type=password placeholder="新密码" required>
					<?php echo form_error('password_new') ?>
				</div>
			</div>

			<div class=input-group>
				<label for=password2>确认新密码</label>
				<div>
					<input name=password2 type=password placeholder="确认新密码" required>
					<?php echo form_error('password2') ?>
				</div>
			</div>
		</fieldset>

		<button type=submit>确定</button>
	</form>
</div>
