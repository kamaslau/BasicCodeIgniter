<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * 短信发送（luosimao）类
	 * http://luosimao.com/docs/api
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright Iceberg <www.bingshankeji.com>
	 */
	class Luosimao
	{
		// API_key
		protected $api_key = 'api:key-';

		/**
		 * 发送单条短信
		 *
		 * @param string $mobile 收信人手机号
		 * @param string $content 短信内容
		 * @return json 发送状态码及返回字符串
		*/
		public function send($mobile, $content)
		{
			$url = 'http://sms-api.luosimao.com/v1/send.json';
			$params = array('mobile' => $mobile, 'message' => $content);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
			curl_setopt($ch, CURLOPT_HEADER, FALSE);

			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->api_key);

			curl_setopt($ch, CURLOPT_POST, count($params));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

			$res = curl_exec($ch);
			curl_close($ch);

			return $res;
		}
		
		/**
		 * 发送批量短信
		 *
		 * @params string $mobile_list 目标手机号码列表，多个号码间使用1个半角逗号分隔
		 * @params string $content 待发送短信内容
		 * @params string $time 待发送时间；2016-04-01 12:30:00
		 * @return json 发送状态码及返回字符串
		 */
		public function send_bulk($mobile_list, $content, $time)
		{
			$url = 'http://sms-api.luosimao.com/v1/send_batch.json';
			$params = array(
				'mobile_list' => $mobile_list,
				'message' => $content,
			);
			if ( $time !== NULL ) $params['time'] = $time; // 定时时间

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
			curl_setopt($ch, CURLOPT_HEADER, FALSE);

			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->api_key);

			curl_setopt($ch, CURLOPT_POST, count($params));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

			$res = curl_exec($ch);
			curl_close($ch);

			return $res;
		}
		
		/**
		 * 查询余额
		 *
		 * @param void
		 * @return json $balance 剩余可发送条数
		*/
		public function balance()
		{
			$url = 'http://sms-api.luosimao.com/v1/status.json';

			$ch = curl_init();			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 

			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->api_key);

			$res =  curl_exec($ch);
			curl_close($ch); 
			return $res;
		}

		/**
		 * 错误码可读化
		 */
		public function error_text($error)
		{
			$text = array(
				'-10' => '验证信息失败；检查api key是否和各种中心内的一致，调用传入是否正确',
				'-11' => '用户接口被禁用；滥发违规内容，验证码被刷等，请联系客服解除',
				'-20' => '短信余额不足',
				'-30' => '短信内容为空',
				'-31' => '短信内容存在敏感词',
				'-32' => '短信内容缺少签名信息',
				'-33' => '短信过长，超过300字（含签名）；需调整短信内容或拆分为多条',
				'-34' => '签名不可用；需在签名管理中添加签名',
				'-40' => '请检查手机号格式',
				'-41' => '该号码因发送频繁被暂停发送',
				'-42' => '验证码短信发送频率过高',
				'-43' => '单次最多只接受10万个手机号码',
				'-50' => '请求发送IP不在白名单内；查看触发短信IP白名单的设置',
				'-60' => '定时时间需要为将来的时间',
			);
			
			// 生成可读的提示
			$text_to_return = $text[$error->error];
			
			// 对敏感词相关提示，补充具体敏感词信息
			if ($error->error === '-31') $text_to_return .= $error->hit;

			return $text_to_return;
		}
	}

/* End of file Luosimao.php */
/* Location: ./application/libraries/Luosimao.php */
