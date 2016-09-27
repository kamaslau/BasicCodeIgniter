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
		if (isset($error)) echo $error; // 若有错误提示信息则显示
		$attributes = array('class' => 'form-register form-horizontal', 'role' => 'form');
		echo form_open('register', $attributes);
	?>
		<fieldset>
			<div class=input-group>
				<label for=mobile>手机号</label>
				<div>
					<i class="prepend fa fa-mobile"></i>
					<input name=mobile type=tel size=11 pattern="\d{11}" autofocus required>
					<?php echo form_error('mobile') ?>
				</div>
			</div>

			<div class=input-group>
				<label for=password>密码</label>
				<div>
					<input name=password type=password placeholder="密码" required>
					<?php echo form_error('password') ?>
				</div>
			</div>

			<div class=input-group>
				<label for=password2>确认密码</label>
				<div>
					<input name=password2 type=password placeholder="确认密码" required>
					<?php echo form_error('password2') ?>
				</div>
			</div>
		</fieldset>

		<button type=submit>注册</button>
		<p>点击“注册”，即表示您同意<a title="查看用户协议详细内容" href="<?php echo base_url('article/user-agreement') ?>" target=_blank>用户协议</a>。</p>
	</form>
</div>
