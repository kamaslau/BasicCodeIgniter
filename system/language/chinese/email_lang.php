<?php
	defined('BASEPATH') OR exit('不可直接访问此文件');

	$lang['email_must_be_array'] = '验证Email时必须以数组格式传入';
	$lang['email_invalid_address'] = "%s是无效的邮箱地址";
	$lang['email_attachment_missing'] = "附件%s无法找到";
	$lang['email_attachment_unreadable'] = "附件%s无法打开";
	$lang['email_no_from'] = '未指定发件人';
	$lang['email_no_recipients'] = '收件人（或抄送人、密送人等）未指定';
	$lang['email_send_failure_phpmail'] = '无法通过PHP的mail()函数发送邮件，你的服务器可能不允许使用此方式发送邮件';
	$lang['email_send_failure_sendmail'] = '无法通过PHP的Sendmail函数发送邮件，你的服务器可能不允许使用此方式发送邮件';
	$lang['email_send_failure_smtp'] = '无法通过PHP的SMTP函数发送邮件，你的服务器可能不允许使用此方式发送邮件';
	$lang['email_sent'] = "你的信息已使用下述协议成功发送 %s";
	$lang['email_no_socket'] = "无法打开发送端口，请检查设置";
	$lang['email_no_hostname'] = "你未指定SMTP服务器";
	$lang['email_smtp_error'] = "发生下述SMTP错误 %s";
	$lang['email_no_smtp_unpw'] = "错误: 你必须指定SMTP用户名及密码。";
	$lang['email_failed_smtp_login'] = "AUTH LOGIN 命令发送失败。错误: %s";
	$lang['email_smtp_auth_un'] = "用户名验证失败。错误: %s";
	$lang['email_smtp_auth_pw'] = "密码验证失败。错误: %s";
	$lang['email_smtp_data_failure'] = "无法发送数据 %s";
	$lang['email_exit_status'] = "Exit状态码: %s";