<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Class_name 类
	 *
	 * 以文章的列表、详情等功能提供了常见功能的示例代码
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright SSEC <www.ssectec.com>
	 */
	class Class_name extends CI_Controller
	{
		/* 类名称小写，应用于多处动态生成内容 */
		public $class_name;

		/* 类名称中文，应用于多处动态生成内容 */
		public $class_name_cn;

		/* 主要相关表名 */
		public $table_name;

		/* 主要相关表的主键名*/
		public $id_name;

		/* 视图文件所在目录名 */
		public $view_root;

		public function __construct()
		{
			parent::__construct();

			// （可选）未登录用户转到登录页
			//if ($this->session->logged_in !== TRUE) redirect(base_url('login'));
			
			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '类名'; // 改这里……
			$this->table_name = 'table'; // 和这里……
			$this->id_name = 'table_id';  // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;

			// 设置并调用Basic核心库
			$basic_configs = array(
				'table_name' => $this->table_name,
				'id_name' => $this->id_name,
				'view_root' => $this->view_root,
			);
			$this->load->library('basic', $basic_configs);

			// （可选）某些用于此类的自定义函数
		    function function_name($parameter)
			{
				//...
		    }
		}

		/**
		 * 我的
		 *
		 * 限定获取的行的user_id（示例为通过session传入的user_id值），一般用于前台
		 */
		public function mine()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '我的', // 页面标题
				'class' => $this->class_name.' '. $this->class_name.'-mine', // 页面body标签的class属性值
				'keywords' => '关键词一,关键词二,关键词三', // （可选，后台功能可删除此行）页面关键词；每个关键词之间必须用半角逗号","分隔才能保证搜索引擎兼容性
				'description' => '这个页面的主要内容是一大波文章的列表', // （可选，后台功能可删除此行）页面内容描述
			);
			
			// 筛选条件
			$condition['user_id'] = $this->session->user_id;
			
			// 排序条件
			$order_by = NULL;
			//$order_by['name'] = 'value';
			
			// Go Basic！
			$this->basic->index($data, $condition, $order_by);
		}

		/**
		 * 列表页
		 */
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '列表',
				'class' => $this->class_name.' '. $this->class_name.'-index',
			);
			
			// 筛选条件
			$condition = NULL;
			//$condition['name'] = 'value';
			
			// 排序条件
			$order_by = NULL;
			//$order_by['name'] = 'value';
			
			// Go Basic！
			$this->basic->index($data, $condition, $order_by);
		}

		/**
		 * 详情页
		 */
		public function detail()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '详情',
				'class' => $this->class_name.' '. $this->class_name.'-detail',
				'keywords' => '关键词一,关键词二,关键词三',
				'description' => '这个页面的主要内容是一大波文章的列表',
			);
			
			// Go Basic！
			$this->basic->detail($data, 'title'); // 当传入第二个参数时，将使用相应的字段值与上方传入的$data['title']进行拼接；如想直接使用该字段作为页面的title，则$data['title']设为NULL即可；更多功能可见model/basic_model.php
		}

		/**
		 * 回收站
		 *
		 * 一般为后台功能
		 */
		public function trash()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '回收站',
				'class' => $this->class_name.' '. $this->class_name.'-trash',
				// 对于后台功能，一般不需要特别指定具体页面的keywords和description
			);
			
			// 筛选条件
			$condition = NULL;
			//$condition['name'] = 'value';
			
			// 排序条件
			$order_by = NULL;
			//$order_by['name'] = 'value';
			
			// Go Basic！
			$this->basic->trash($data, $condition, $order_by);
		}

		/**
		 * 创建
		 *
		 * 一般为后台功能
		 */
		public function create()
		{
			// 页面信息
			$data = array(
				'title' => '创建'.$this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-create',
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/

			// 待验证的表单项
			$this->form_validation->set_rules('title', '标题', 'trim|required');
			$this->form_validation->set_rules('content', '内容', 'trim|required');
			$this->form_validation->set_rules('excerpt', '摘要', 'trim');

			// 需要存入数据库的信息
			// 不建议直接用$this->input->post、$this->input->get等方法直接在此处赋值，向数组赋值前处理会保持最大的灵活性以应对图片上传等场景
			$data_to_create = array(
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'excerpt' => $this->input->post('excerpt'),
			);

			// Go Basic!
			$this->basic->create($data, $data_to_create);
		}

		/**
		 * 编辑单行
		 *
		 * 一般为后台功能
		 */
		public function edit()
		{
			// 页面信息
			$data = array(
				'title' => '编辑'.$this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-edit',
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/

			// 待验证的表单项
			$this->form_validation->set_rules('title', '标题', 'trim|required');
			$this->form_validation->set_rules('content', '内容', 'trim|required');
			$this->form_validation->set_rules('excerpt', '摘要', 'trim');

			// 需要编辑的信息
			// 不建议直接用$this->input->post、$this->input->get等方法直接在此处赋值，向数组赋值前处理会保持最大的灵活性以应对图片上传等场景
			$data_to_edit = array(
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'excerpt' => $this->input->post('excerpt'),
			);

			// Go Basic!
			$this->basic->edit($data, $data_to_edit);
		}

		/**
		 * 删除单行或多行项目
		 *
		 * 一般用于存为草稿、上架、下架、删除、恢复等状态变化，请根据需要修改方法名，例如delete、restore、draft等
		 */
		public function delete()
		{
			$op_name = '删除'; // 操作的名称
			$op_view = 'delete'; // 视图文件名

			// 页面信息
			$data = array(
				'title' => $op_name. $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-'. $op_view,
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/

			// 待验证的表单项
			$this->form_validation->set_rules('password', '密码', 'trim|required|is_natural|exact_length[6]');

			// 需要存入数据库的信息
			$data_to_edit = array(
				'time_delete' => date('y-m-d H:i:s'), // 批量删除
				// 'time_delete' => NULL, // 批量恢复
				// 'name' => 'value', // 批量修改其它数据
				// 'name' => 'value', // 多行可批量修改多个字段
			);

			// Go Basic!
			$this->basic->bulk($data, $data_to_edit, $op_name, $op_view);
		}
		
		/**
		 * 恢复单行或多行项目
		 *
		 * 一般用于存为草稿、上架、下架、删除、恢复等状态变化，请根据需要修改方法名，例如delete、restore、draft等
		 */
		public function restore()
		{
			$op_name = '恢复'; // 操作的名称
			$op_view = 'restore'; // 视图文件名

			// 页面信息
			$data = array(
				'title' => $op_name. $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-'. $op_view,
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/

			// 待验证的表单项
			$this->form_validation->set_rules('password', '密码', 'trim|required|is_natural|exact_length[6]');

			// 需要存入数据库的信息
			$data_to_edit = array(
				// 'time_delete' => date('y-m-d H:i:s'), // 批量删除
				'time_delete' => NULL, // 批量恢复
				// 'name' => 'value', // 批量修改其它数据
				// 'name' => 'value', // 多行可批量修改多个字段
			);

			// Go Basic!
			$this->basic->bulk($data, $data_to_edit, $op_name, $op_view);
		}
	}

/* End of file Class_name.php */
/* Location: ./application/controllers/Class_name.php */