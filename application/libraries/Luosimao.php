<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	* 短信发送（luosimao）类
	* http://luosimao.com/docs/api
	*
	* @version 1.0.0
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SSEC <www.ssectec.com>
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
	}

/* End of file Luosimao.php */
/* Location: ./application/libraries/Luosimao.php */