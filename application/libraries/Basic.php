<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Basic类
	 *
	 * 提供了常见功能的示例代码
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright SSEC <www.ssectec.com>
	 */
	class Basic
	{
		/**
		 * 视图文件根目录名
		 *
		 * 相对于view文件夹的路径，默认为类名小写，在构造函数中赋值
		 */
		public $view_root;

		// 原始CodeIgniter对象
		private $CI;

		/**
		 * 构造函数
		 *
		 * 继承CI_Controller类并添加自定义功能
		 *
		 */
		public function __construct($configs)
		{
			// 配置类属性
			$this->view_root = $configs['view_root']. '/';

			// 引用原始CodeIgniter对象
			$this->CI =& get_instance();

			// 配置数据库参数
			$this->CI->basic_model->table_name = $configs['table_name']; // 表名
			$this->CI->basic_model->id_name = $configs['id_name']; // 主键名
		}

		/**
		 * 文件上传
		 *
		 *
		 *
		 *
		 */
		public function upload()
		{

		}

		/**
		 * 调用错误提示页面
		 *
		 * @param int $code 错误代码
		 * @param string $content 错误提示文本
		 * @return void
		 */
		public function error($code, $content)
		{
			$data = array(
				'title' => $code,
				'class' => $code,
				'content' => $content
			);

			$this->CI->load->view('templates/header', $data); // 载入视图文件，下同
			$this->CI->load->view('error/'.$code, $data);
			$this->CI->load->view('templates/footer', $data);
		}

		/**
		 * 权限检查
		 *
		 * @param array $role_allowed 拥有相应权限的角色
		 * @param int $min_level 最低级别要求
		 * @return void
		 */
		public function permission_check($role_allowed, $min_level)
		{
			// 目前管理员角色和级别
			$current_role = $this->session->role;
			$current_level = $this->session->level;

			// 执行此操作的角色及权限要求
			if ( ! in_array($current_role, $role_allowed) || ! $current_level < $min_level):
				$data['content'] = '抱歉，您的员工角色不符或权限不足。';
				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root.'result', $data);
				$this->CI->load->view('templates/footer', $data);
				exit;
			endif;
		}

		/**
		 * 创建/编辑文件
		 *
		 * @param string $url 待创建为的，或待编辑的文件路径（含路径名）
		 * @param string $data 需写入的内容
		 * @return void
		 */
		public function file_edit($url, $data)
		{
			$this->CI->load->helper('file');
			if ( ! write_file($url, $data, 'w+'))
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}

		/**
		 * 获取数据列表
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param int $limit 需获取的行数
		 * @param int $offset 需跳过的行数，与$limit参数配合做分页功能
		 * @param array $condition 需要获取的行的条件
		 * @param array $order_by 结果集排序方式，默认为按创建日期由新到旧排列
		 * @return void
		 */
		public function index($data)
		{
			// 获取参数
			$limit = $this->CI->input->get_post('limit')? $this->CI->input->get_post('limit'): NULL; // 需要从数据库获取的数据行数
			$offset = $this->CI->input->get_post('offset')? $this->CI->input->get_post('offset'): NULL; // 需要从数据库获取的数据起始行数（与$limit配合可用于分页等功能）
			$condition = $this->CI->input->get_post('condition')? $this->CI->input->get_post('condition'): NULL; // 筛选条件键值对，一般用于AJAX
			$order_by = $this->CI->input->get_post('order_by')? $this->CI->input->get_post('order_by'): NULL; // 排序方式键值对，一般用于AJAX

			// 调用模型类，获取相应数据，下略
			$data['items'] = $this->CI->basic_model->select($limit, $offset, $condition, $order_by);
			$data['ids'] = $this->CI->basic_model->select($limit, $offset, $condition, $order_by, TRUE);

			// 调用视图类，生成页面HTML，下略
			$this->CI->load->view('templates/header', $data); // 载入视图文件，下同
			$this->CI->load->view($this->view_root.'index', $data);
			$this->CI->load->view('templates/footer', $data);
		}

		/**
		 * 获取数据详情
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param int $id 需获取的数据ID（一般为主键值）
		 * @param string $title_name 用于页面标题的字段名
		 * @param string $position 拼接页面标题的位置，'after'为拼接到$data['title']之后，'before'是拼接到$data['title']之前
		 * @return void
		 */
		public function detail($data, $title_name = NULL, $position = 'after')
		{
			$id = $this->CI->input->get_post('id')? $this->CI->input->get_post('id'): NULL;

			// 检查是否已传入必要参数
			if (empty($id)):
				$this->error(404, '网址不完整');
				exit;
			endif;

			// 获取项目
			$data['item'] = $this->CI->basic_model->select_by_id($id);

			// 生成最终页面标题
			$dynamic_title = $title_name !== NULL? $data['item'][$title_name]: NULL;
			$data['title'] = $position === 'before'? $dynamic_title. $data['title']: $data['title']. $dynamic_title;

			$this->CI->load->view('templates/header', $data);
			$this->CI->load->view($this->view_root.'detail', $data);
			$this->CI->load->view('templates/footer', $data);
		}

		/**
		 * 回收站（一般为后台功能）
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param int $limit 需获取的行数
		 * @param int $offset 需跳过的行数，与$limit参数配合做分页功能
		 * @param array $condition 需要获取的行的条件
		 * @param array $order_by 结果集排序方式，默认为按创建日期由新到旧排列
		 * @return void
		 */
		public function trash($data)
		{
			$limit = $this->CI->input->get_post('limit')? $this->CI->input->get_post('limit'): NULL;
			$offset = $this->CI->input->get_post('offset')? $this->CI->input->get_post('offset'): NULL;
			$condition = $this->CI->input->get_post('condition')? $this->CI->input->get_post('condition'): NULL;
			$order_by = $this->CI->input->get_post('order_by')? $this->CI->input->get_post('order_by'): NULL;

			$data['items'] = $this->CI->basic_model->select_trash($limit, $offset, $condition, $order_by);
			$data['ids'] = $this->CI->basic_model->select_trash($limit, $offset, $condition, $order_by, TRUE);

			$this->CI->load->view('templates/header', $data);
			$this->CI->load->view($this->view_root.'trash', $data);
			$this->CI->load->view('templates/footer', $data);
		}

		/**
		 * 创建数据（一般为后台功能）
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param array $data_to_create 需要存入数据库的信息
		 * @param void 按需传入
		 * @return void
		 */
		public function create($data, $data_to_create)
		{
			// 若表单提交不成功
			if ($this->CI->form_validation->run() === FALSE):
				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root.'create', $data);
				$this->CI->load->view('templates/footer', $data);

			else:
				$result = $this->CI->basic_model->create($data_to_create);
				if ($result !== FALSE):
					$data['content'] = '<p class="alert alert-success">创建成功。</p>';
				else:
					$data['content'] = '<p class="alert alert-warning">创建失败。</p>';
				endif;

				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root.'result', $data);
				$this->CI->load->view('templates/footer', $data);
			endif;
		}

		/**
		 * 编辑单行数据
		 *
		 * 一般为后台功能，编辑单行数据的多个字段
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param array $data_to_edit 需要存入数据库的信息
		 * @param string $view_file_name 视图文件名（不含后缀）
		 * @param int $id 需编辑的数据ID，用post或get方式传入
		 * @param void 按需传入
		 * @return void
		 */
		public function edit($data, $data_to_edit, $view_file_name = NULL)
		{
			$id = $this->CI->input->get_post('id')? $this->CI->input->get_post('id'): $data['id'];

			// 检查是否已传入必要参数
			if (empty($id)):
				$this->error(404, '网址不完整');
				exit;
			endif;

			// 获取待编辑信息
			$data['item'] = $this->CI->basic_model->select_by_id($id);

			// 验证表单值格式
			if ($this->CI->form_validation->run() === FALSE):
				$this->CI->load->view('templates/header', $data);
				if ($view_file_name === NULL):
					$this->CI->load->view($this->view_root.'edit', $data);
				else:
					$this->CI->load->view($this->view_root.$view_file_name, $data);
				endif;
				$this->CI->load->view('templates/footer', $data);

			else:
				// 核对管理员密码
				if ( isset($this->session->user_id) && $this->CI->basic_model->password_check() === NULL ):
					$data = array(
						'title' => '密码错误',
						'content' => '<p>您的操作密码错误，请重试。</p>'
					);
					$this->CI->load->view('templates/header', $data);
					$this->CI->load->view($this->view_root.'result', $data);
					$this->CI->load->view('templates/footer', $data);
					exit;
				endif;

				$result = $this->CI->basic_model->edit($id, $data_to_edit);
				if ($result !== FALSE):
					$data['content'] = '<p class="alert alert-success">保存成功。</p>';
				else:
					$data['content'] = '<p class="alert alert-warning">保存失败。</p>';
				endif;

				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root.'result', $data);
				$this->CI->load->view('templates/footer', $data);

			endif;
		}

		/**
		 * 编辑多行数据
		 *
		 * 一般为后台功能，单独或批量编辑多行数据的单独或多个字段；
		 * 简单修改359行即可应用于单独或批量删除、恢复、上架、下架、发布、存为草稿等场景
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param array $ids 需编辑的数据ID们（单独编辑时只传入1个ID即可）
		 * @param array $op_name 批量操作的名称，例如“删除”、“下架”、“恢复”等等
		 * @param void 按需传入
		 * @return void
		 */
		public function bulk($data, $data_to_edit, $op_name)
		{
			// 从表单获取待修改项ID数组，或从URL获取待修改单项ID后转换为数组
			$this->CI->input->post('ids')? $ids = $this->CI->input->post('ids'): $ids[0] = $this->CI->input->get('ids');
			if (count($ids) === 1 && strpos($ids[0], '|') !== FALSE):
				$ids = explode('|', $ids[0]);
			endif;

			// 验证表单值格式
			if ($this->CI->form_validation->run() === FALSE):
				$data['ids'] = $ids;
				foreach ($ids as $id):
					$data['items'][] = $this->CI->basic_model->select_by_id($id);
				endforeach;

				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root.'bulk', $data);
				$this->CI->load->view('templates/footer', $data);

			else:
				// 核对管理员密码
				if ($this->CI->basic_model->password_check() === NULL):
					$data = array(
						'title' => '密码错误',
						'content' => '<p>您的操作密码错误，请重试。</p>'
					);
					$this->CI->load->view('templates/header', $data);
					$this->CI->load->view($this->view_root.'result', $data);
					$this->CI->load->view('templates/footer', $data);
					exit;
				endif;

				// 更新数据
				$ids = explode('|', $ids);
				foreach ($ids as $id):
					$result = $this->CI->basic_model->edit($id, $data_to_edit);
				endforeach;

				if ($result === FALSE):
					$data['content'] = '<p class="alert alert-warning">'.$data['title'].'失败，请重试。</p>';
				else:
					$data['content'] = '<p class="alert alert-success">'.$data['title'].'成功。</p>';
				endif;

				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root.'result', $data);
				$this->CI->load->view('templates/footer', $data);
			endif;
		}
	}

/* End of file Basic.php */
/* Location: ./application/controllers/Basic.php */
