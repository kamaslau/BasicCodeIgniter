<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');
	
	/**
	 * MY_Controller 基础控制器类
	 *
	 * 针对API服务，对Controller类进行了扩展
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class MY_Controller extends CI_Controller
	{
		// 初始化返回结果
		public $result = array(
			'status' => null, // 请求响应状态
			'content' => null, // 返回内容
			'param' => array(
				'get' => array(), // GET请求参数
				'post' => array(), // POST请求参数
			), // 接收到的请求参数
			'timestamp' => null, // 返回时时间戳
			'datetime' => null, // 返回时可读日期
			'timezone' => null, // 服务器本地市区
			'elapsed_time' => null, // 处理业务请求时间
		);

		/* 主要相关表名 */
		public $table_name;

		/* 主要相关表的主键名*/
		public $id_name;

		// 客户端类型
		protected $app_type;

		// 客户端版本号
		protected $app_version;

		// 设备操作系统平台ios/android；非移动客户端传空值
		protected $device_platform;

		// 设备唯一码；全小写
		protected $device_number;

		// 请求时间戳
		protected $timestamp;

		// 请求签名
		private $sign;

		public function __construct()
	    {
	        parent::__construct();

			// 统计业务逻辑运行时间起点
			$this->benchmark->mark('start');

			// 若无任何通过POST方式传入的请求参数，提示并退出
			if ( empty($_POST) ):
				$this->result['status'] = 000;
				$this->result['content']['error']['message'] = '请求方式不正确';
				exit();
			endif;

			// 向类属性赋值
			$this->timestamp = time();
			$this->app_type = $this->input->post('app_type');
			$this->app_version = $this->input->post('app_version');
			$this->device_platform = $this->input->post('device_platform');
			$this->device_number = $this->input->post('device_number');

			// 签名有效性检查
			// 测试环境可跳过签名检查
			if ( ENVIRONMENT !== 'development' && $this->input->post('skip_sign') !== 'please' )
				$this->sign_check();
	    }

		public function __destruct()
		{
			// 将请求参数一并返回以便调试
			$this->result['param']['get'] = $this->input->get();
			$this->result['param']['post'] = $this->input->post();

			// 返回服务器端时间信息
			$this->result['timestamp'] = time();
			$this->result['datetime'] = date('Y-m-d H:i:s');
			$this->result['timezone'] = date_default_timezone_get();

			// 统计业务逻辑运行时间终点
			$this->benchmark->mark('end');
			// 计算并输出业务逻辑运行时间（秒）
			$this->result['elapsed_time'] = $this->benchmark->elapsed_time('start', 'end');

			header("Content-type:application/json;charset=utf-8");
			$output_json = json_encode($this->result);
			echo $output_json;
		}

		/**
		 * 签名有效性检查
		 *
		 * 依次检查签名的时间是否过期、参数是否完整、签名是否正确
		 */
		public function sign_check()
		{
			$this->sign_check_exits();
			$this->sign_check_time();
			$this->sign_check_params();
			$this->sign_check_string();
		}

		// 检查签名是否传入
		public function sign_check_exits()
		{
			$this->sign = $this->input->post('sign');

			if ( empty($this->sign) ):
				$this->result['status'] = 444;
				$this->result['content']['error']['message'] = '未传入签名';
				exit();
			endif;
		}

		// 签名时间检查
		public function sign_check_time()
		{
			$timestamp_sign = $this->input->post('timestamp');

			if ( empty($timestamp_sign) ):
				$this->result['status'] = 440;
				$this->result['content']['error']['message'] = '必要的签名参数未全部传入；安全起见不做具体提示，请参考开发文档。';
				exit();

			else:
				$time_difference = ($this->timestamp - $timestamp_sign);

				// 测试阶段签名有效期为600秒，生产环境应为60秒
				if ($time_difference > 600):
					$this->result['status'] = 441;
					$this->result['content']['error']['message'] = '签名时间已超过有效区间。';
					exit();

				else:
					return TRUE;

				endif;

			endif;
		}

		// 签名参数检查
		public function sign_check_params()
		{
			// 检查需要参与签名的必要参数；
			$params_required = array(
				'app_type',
				'app_version',
				'device_platform',
				'device_number',
				'timestamp',
				'random',
			);

			// 获取传入的参数们
			$params = $_POST;

			// 检查必要参数是否已传入
			if ( array_intersect_key($params_required, array_keys($params)) !== $params_required ):
				$this->result['status'] = 440;
				$this->result['content']['error']['message'] = '必要的签名参数未全部传入；安全起见不做具体提示，请参考开发文档。';
			else:
				return TRUE;
			endif;
		}

		// 签名正确性检查
		public function sign_check_string()
		{
			// 获取传入的参数们
			$params = $_POST;
			unset($params['sign']); // sign本身不参与签名计算

			// 生成参数
			$sign = $this->sign_generate($params);

			// 对比签名是否正确
			if ($this->sign !== $sign):
				$this->result['status'] = 449;
				$this->result['content']['error']['message'] = '签名错误，请参考开发文档。';
				$this->result['content']['sign_expected'] = $sign;
				$this->result['content']['sign_offered'] = $this->sign;
				exit();

			else:
				return TRUE;

			endif;
		}

		/**
		 * 生成签名
		 */
		public function sign_generate($params)
		{
			// 对参与签名的参数进行排序
			ksort($params);

			// 对随机字符串进行SHA1计算
			$params['random'] = SHA1( $params['random'] );

			// 拼接字符串
			$param_string = '';
			foreach ($params as $key => $value)
				$param_string .= '&'. $key.'='.$value;

			// 拼接密钥
			$param_string .= '&key='. API_TOKEN;

			// 计算字符串SHA1值并转为大写
			$sign = strtoupper( SHA1($param_string) );

			return $sign;
		}

		/**
		 * 客户端检查
		 *
		 * 根据客户端类型、版本号、平台等进行权限检查
		 */
		public function client_check($type_allowed, $platform_allowed = NULL, $min_version = NULL)
		{
			if ( !in_array($this->app_type, $type_allowed) ):
				$this->result['status'] = 450;
				$this->result['content']['error']['message'] = '当前类型的客户端不可进行该操作';
				exit();

			elseif ( isset($platform_allowed) && !in_array($this->device_platform, $platform_allowed) ):
				$this->result['status'] = 451;
				$this->result['content']['error']['message'] = '当前软件平台的客户端不可进行该操作';
				exit();

			endif;

			// 若已限制最低版本，进行检查
			if ( isset($min_version) ):
				$min_version_array = explode('.', $min_version);
				$current_version_array = explode('.', $this->app_version);
				
				// 依次进行营销版本、功能版本、维护版本的版本号对比并进行提示
				for ($i=0; $i<3; $i++):
					if ($current_version_array[$i] < $min_version_array[$i]):
						$this->result['status'] = 452;
						$this->result['content']['error']['message'] = '当前版本的客户端不可进行该操作';
						exit();
					endif;
				endfor;

			else:
				return TRUE;

			endif;
		}

		/**
		 * TODO 权限检查
		 *
		 * 对已登录用户，根据所需角色、所需等级等进行权限检查
		 */
		public function permission_check($role_allowed, $min_level)
		{
			return TRUE;
		}

		/**
		 * 操作者有效性检查；通过操作者类型、ID、密码进行验证
		 */
		public function operator_check()
		{
			$table_name = $this->input->post('operator_type');

			// 设置数据库参数
			$this->basic_model->table_name = $table_name;
			$this->basic_model->id_name = $table_name.'_id';
			
			// 尝试获取复合条件的数据
			$data_to_search = array(
				$table_name.'_id' => $this->input->post('operator_id'),
				'password' => $this->input->post('password'),
			);
			$result = $this->basic_model->match($data_to_search);

			// 还原原有数据库参数
			$this->basic_model->table_name = $this->table_name;
			$this->basic_model->id_name = $this->id_name;

			if ( !empty($result) ):
				return TRUE;
			else:
				return FALSE;
			endif;
		}
	}