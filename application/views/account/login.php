<style>

/* 宽度在960像素以上的设备 */
@media only screen and (min-width:961px)
{

}
</style>

<noscript>您的浏览器目前不支持JavaScript，请更换浏览器或检查相关设置。</noscript>

<script>
	$(function(){

	});
</script>

<div id=content class=container>
	<h2><?php echo $title ?></h2>
	<?php
		if (isset($error)) echo $error; //若有错误提示信息则显示
		$attributes = array('class' => 'form-login col-sm-12 col-md-4 col-lg-3', 'role' => 'form');
		echo form_open('login', $attributes);
	?>
		<fieldset>
			<div class=form-group>
				<label for=mobile>手机号</label>
				<div class=input-group>
					<span class="input-group-addon"><i class="fa fa-mobile fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=mobile type=tel value="<?php echo $this->input->post('mobile')? set_value('mobile'): $this->input->cookie('mobile') ?>" size=11 pattern="\d{11}" placeholder="手机号" required>
					<?php echo form_error('mobile') ?>
				</div>
			</div>

			<div class=form-group>
				<label for=password>密码</label>
				<div class=input-group>
					<span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=password type=password <?php if ($this->input->cookie('mobile')) echo 'autofocus '; ?>size=6 pattern="\d{6}" placeholder="密码（6位数字）" required>
					<?php echo form_error('password') ?>
				</div>
			</div>
		</fieldset>

		<button class="btn btn-primary btn-lg btn-block" type=submit role=button>登录</button>
	</form>

	<ul class=hide>
		<li><a title="注册" href="<?php echo base_url('register') ?>">注册</a></li>
		<li><a title="找回密码" href="<?php echo base_url('password_reset') ?>">找回密码</a></li>
	</ul>
</div>
