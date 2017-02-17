<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	* Curl类
	*
	* @version 1.0.0
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright ICBG <www.bingshankeji.com>
	*/
	class Curl
	{
		/**
		* 执行CURL
		*
		* @param string $url 待请求的URL
		* @param string $method 待发送的CURL请求类型；默认为get，可设为'post'
		* @param array $params 待发送的CURL请求参数数组，当且以POST方式发送的时候需传入此数组
		* @param string $return 需返回的数据格式；默认为数组格式，可传入'object'以设置为以对象格式返回
		* @return object|array 返回的CURL请求结果
		*/
		public function go($url, $method = 'get', $params = NULL, $return = 'array')
		{
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);

		    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
			
			// 需要通过POST方式发送的数据
			if ($method === 'post'):
				curl_setopt($curl, CURLOPT_POST, count($params));
				curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			endif;
			
		    // 运行cURL，请求API
			$result = curl_exec($curl);

			// 关闭URL请求
		    curl_close($curl);

			// 转换返回的json数据为相应格式并返回
			if ($return === 'object'):
				$result = json_decode($result);
			elseif ($return === 'array'):
				$result = json_decode($result, TRUE);
			endif;

			return $result;
		}
	}
	
/* End of file Curl.php */
/* Location: ./application/libraries/Curl.php */