<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * API_Template 类
	 *
	 * 以API服务形式返回数据列表、详情、创建、单行编辑、单/多行编辑（删除、恢复）等功能提供了常见功能的示例代码
	 * CodeIgniter官方网站 https://www.codeigniter.com/user_guide/
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class API_Template extends CI_Controller
	{
		/* 主要相关表名 */
		public $table_name;

		/* 主要相关表的主键名*/
		public $id_name;
		
		/**
		 * 可筛选字段名
		 *
		 * 可作为列表筛选条件的字段名数组
		 */
		protected $sorter_names = array(
			'time_create',
			'time_delete',
			'time_edit',
			// ...
		);

		public function __construct()
		{
			parent::__construct();
			
			// 统计业务逻辑运行时间起点
			$this->benchmark->mark('start');
			
			// 根据timestamp和token验证签名
			/*
			$timestamp = $this->input->post('timestamp');
			$sign = $this->input->post('sign');
			$this->load->library('verify');
			$is_valid = $this->verify->go($timestamp, $sign);
			if ($is_valid !== TRUE):
				$this->result['status'] = 444;
				$this->result['content'] = '签名不正确或未签名';
				exit;
			endif;
			*/
			
			// 向类属性赋值
			$this->basic_model->table_name = 'table'; // 这里……
			$this->basic_model->id_name = 'table_id';  // 还有这里，OK，这就可以了

			// （可选）某些用于此类的自定义函数
		    function function_name($parameter)
			{
				//...
		    }
		}

		/**
		 * 析构时将待输出的内容以json格式返回
		 * 截止3.1.3为止，CI_Controller类无析构函数，所以无需继承相应方法
		 */
		public function __destruct()
		{
			// 将请求参数一并返回以便调试
			$this->result['param']['get'] = $this->input->get();
			$this->result['param']['post'] = $this->input->post();

			// 统计业务逻辑运行时间终点
			$this->benchmark->mark('end');
			// 计算并输出业务逻辑运行时间
			$this->result['elapsed_time'] = $this->benchmark->elapsed_time('start', 'end'). ' s';

			header("Content-type:application/json;charset=utf-8");
			$output_json = json_encode($this->result);
			echo $output_json;
		}
		
		/**
		 * 0 计数
		 */
		public function count()
		{
			// （可选）遍历筛选条件
			foreach ($this->sorter_names as $sorter):
				if ( !empty($this->input->post_get($sorter)) ):
					// 对时间范围做特定处理
					if ($sorter === 'start_time'):
						$condition['time_create >='] = $this->input->post_get($sorter);
					elseif ($sorter === 'end_time'):
						$condition['time_create <='] = $this->input->post_get($sorter);
					else:
						$condition[$sorter] = $this->input->post_get($sorter);
					endif;

				endif;
			endforeach;

			// 获取列表；默认不获取已删除项
			$count = $this->basic_model->count($condition);

			if ($count !== FALSE):
				$this->result['status'] = 200;
				$this->result['content']['count'] = $count;

			else:
				$this->result['status'] = 400;
				$this->result['content'] = NULL;

			endif;
		}

		/**
		 * 1 列表页
		 */
		public function index()
		{	
			// 检查必要参数是否已传入
			$required_params = array();
			foreach ($required_params as $param):
				${$param} = $this->input->get_post($param);
				if ( empty( ${$param} ) ):
					$this->result['status'] = 400;
					$this->result['content'] = '必要的请求参数未全部传入';
					exit;
				endif;
			endforeach;

			// 筛选条件
			$condition = NULL;
			//$condition['name'] = 'value';
			
			// （可选）限制可筛选的字段名
			foreach ($this->sorter_names as $sorter):
				if ( !empty($this->input->post_get($sorter)) ):
					$condition[$sorter] = $this->input->post_get($sorter);
				endif;
			endforeach;
			
			// 排序条件
			$order_by = NULL;
			//$order_by['name'] = 'value';

			// 获取列表；默认不获取已删除项
			$items = $this->basic_model->select($condition, $order_by, FALSE, FALSE);
			if ( !empty($items) ):
				$this->result['status'] = 200;
				$this->result['content'] = $items;

			else:
				$this->result['status'] = 400;
				$this->result['content'] = NULL;
			
			endif;
		}

		/**
		 * 2 详情页
		 */
		public function detail()
		{
			// 检查必要参数是否已传入
			$id = $this->input->get_post('id');
			if ( empty( $id ) ):
				$this->result['status'] = 400;
				$this->result['content'] = '必要的请求参数未全部传入';
				exit;
			endif;

			// 获取特定项；默认可获取已删除项
			$item = $this->basic_model->select_by_id($id);
			if ( !empty($item) ):
				$this->result['status'] = 200;
				$this->result['content'] = $item;

			else:
				$this->result['status'] = 400;
				$this->result['content'] = NULL;
			
			endif;
		}

		/**
		 * 3 创建
		 */
		public function create()
		{
			
		}

		/**
		 * 4 编辑单行
		 *
		 * 可结合相关字段将相应数据行标记为已删除等状态
		 */
		public function edit()
		{
			
		}
	}

/* End of file API_Template.php */
/* Location: ./application/controllers/API_Template.php */
