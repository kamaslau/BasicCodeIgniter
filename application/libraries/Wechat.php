<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Wechat 类
	 *
	 * 微信相关功能
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
     * @copyright Kamas <www.kamaslau.com>
	 */
	class Wechat
	{
		// 原始CodeIgniter对象
		private $CI;

		// 微信相关参数
        public $access_token;
        public $wesign;
        public $sns_info;

		// 构造函数
		public function __construct()
		{
			// (可选)引用原始CodeIgniter对象
			$this->CI =& get_instance();

            // 获取access_token；若已获得授权则一并获取微信用户资料
            $this->access_token = $this->get_access_token();

            // 生成微信网页API签名参数
            $wesign['timestamp'] = time();
            $wesign['noncestr'] = 'Wm3WZYTPz0wzccnW'; // 随机生成的字符串
            $wesign['jsapi_ticket'] = $this->get_jsapi_ticket();
            $current_url = (strpos(CURRENT_URL, '#') === FALSE)? CURRENT_URL: substr(CURRENT_URL, 0, strpos(CURRENT_URL, '#'));
            $wesign['url'] = $current_url;
            $this->wesign = $wesign;
		}

		// 获取微信用户资料
		public function grab_user()
        {
            // 获取用户微信资料
            $code = $this->CI->input->get('code');
            $last_code_used = get_cookie('last_code_used');
            if ( !empty($code) && ($last_code_used <> $code)):
                // 清除当前登录信息
                //$this->session->sess_destroy();

                // 获取微信用户资料
                $sns_token = $this->get_sns_token($code);
                $this->sns_info = $sns_info = $this->get_user_info($this->access_token, $sns_token['openid']);
                //set_cookie('last_code_used', $code);
                $this->instant_cookie('last_code_used', $code); // 标记当前code为已使用

                // 若当前用户已订阅微信公众号，尝试使用微信union_id登录本站账户
                if ($sns_info['subscribe'] == 1 && !empty($sns_token['unionid'])):
                    /*
                    // 尝试使用微信union_id登录
                    $user_info = login_wechat($sns_token['unionid'], $sns_info);
                    var_dump($user_info);

                    if ($user_info !== FALSE):
                        // 将信息键值对写入session
                        foreach ($user_info as $key => $value):
                            $user_data[$key] = $value;
                        endforeach;
                        $user_data['time_expire_login'] = time() + 60*60*24 *30; // 默认登录状态保持30天
                        $this->session->set_userdata($user_data);
                        $this->session->sns_info = json_encode($sns_info);

                        //set_cookie('wechat_subscribe', 1);
                        instant_cookie('wechat_subscribe', 1); // 标记当前已关注微信公众号
                    endif;
                    */
                    //set_cookie('wechat_subscribe', 1);
                    $this->instant_cookie('wechat_subscribe', 1); // 标记当前已关注微信公众号
                else:
                    //set_cookie('wechat_subscribe', 0);
                    $this->instant_cookie('wechat_subscribe', 0); // 标记当前未关注微信公众号
                endif;
            endif;
        } // end grab_user

        // 使修改的COOKIE即时生效
        public function instant_cookie($var, $value = '', $time = 0, $path = '', $domain = '', $s = false)
        {
            $_COOKIE[$var] = $value;
            setcookie($var, $value, $time, $path, $domain, $s);
        }

        // 发送CURL请求
        public function curl($url, $params = NULL, $return = 'array', $method = 'get')
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);

            // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');

            // 需要通过POST方式发送的数据
            if ($method === 'post'):
                $params['app_type'] = 'client'; // 应用类型默认为client
                curl_setopt($curl, CURLOPT_POST, count($params));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            endif;

            // 运行cURL，请求API
            $result = curl_exec($curl);

            // 输出CURL请求头以便调试
            //var_dump(curl_getinfo($curl));

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

        // 获取access_token
        public function get_access_token()
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APP_ID.'&secret='.WECHAT_APP_SECRET;
            //var_dump($url);
            $result = $this->curl($url);
            //var_dump($result);
            return $result['access_token'];
        }

        // 获取jsapi_ticket
        public function get_jsapi_ticket()
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token='.$this->access_token;
            $result = $this->curl($url);
            return $result['ticket'];
        }

        // 微信JSAPI签名过程
        public function wechat_sign_generate($params)
        {
            // 对参与签名的参数进行排序
            ksort($params);

            // 拼接字符串
            $param_string = '';
            foreach ($params as $key => $value)
                $param_string .= '&'. $key.'='.$value;
            $param_string = trim($param_string, '&'); // 清除冗余的“&”

            // 计算字符串SHA1值
            $sign = SHA1($param_string);
            return $sign;
        }

        // 获取sns_token
        public function get_sns_token($code)
        {
            $url =  'https://api.weixin.qq.com/sns/oauth2/access_token?grant_type=authorization_code&appid='.WECHAT_APP_ID.'&secret='.WECHAT_APP_SECRET.'&code='.$code;
            $result = $this->curl($url);
            return $result;
        }

        // 重新获取sns_token
        public function refresh_sns_token($refresh_token)
        {
            $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?grant_type=refresh_token&appid='.WECHAT_APP_ID.'&refresh_token='.$refresh_token;
            $result = $this->curl($url);
            return $result;
        }

        // 获取用户资料
        public function get_user_info($access_token, $openid)
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?lang=zh_CN&access_token='.$access_token.'&openid='.$openid;
            $result = $this->curl($url);
            return $result;
        }

        // 使用微信union_id登录，并传入微信用户信息以更新用户信息
        public function login_wechat($union_id, $sns_info = array())
        {
            $params = array(
                'wechat_union_id' => $union_id,
                'sns_info' => $sns_info,
            );
            $url = api_url('account/login_wechat');
            $result = $this->curl($url, $params, 'array', 'post');
            return ($result['status'] === 200)? $result['content']: FALSE;
        }
	} // end class Wechat

/* End of file Wechat.php */
/* Location: ./application/libraries/Wechat.php */