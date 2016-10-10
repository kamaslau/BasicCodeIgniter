<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Article Class
	 *
	 * 以文章的列表、详情等功能提供了常见功能的示例代码
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright SSEC <www.ssectec.com>
	 */
	class Article extends CI_Controller
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

			// 未登录用户转到登录页
			if ($this->session->logged_in !== TRUE) redirect(base_url('login'));

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '文章'; // 改这里……
			$this->table_name = 'article'; // 和这里……
			$this->id_name = 'article_id';  // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 特殊情况下可能需要修改视图文件所在目录名，注意不要以'/'结尾。

			// 设置并调用Basic核心库
			$basic_configs = array(
				'table_name' => $this->table_name,
				'id_name' => $this->id_name,
				'view_root' => $this->view_root
			);
			$this->load->library('basic', $basic_configs);
		}

		// 列表页
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn.'列表', // 页面标题
				'class' => $this->class_name.' '. $this->class_name.'-index', // 页面body标签的class属性值
				'keywords' => '关键词一,关键词二,关键词三', // （可选，后台功能可删除此行）页面关键词；每个关键词之间必须用半角逗号","分隔才能保证搜索引擎兼容性
				'description' => '这个页面的主要内容是一大波文章的列表' // （可选，后台功能可删除此行）页面内容描述
			);

			// Go Basic！
			$this->basic->index($data);
		}

		// 详情页
		public function detail()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn.'详情',
				'class' => $this->class_name.' '. $this->class_name.'-detail', // 一般均直接将类名、类名与方法名的组合作为页面body元素的class值，但为了尊重前端工程师的选择权，此处不做进一步抽象；若确需直接进一步抽象，则直接将此行在libraries/Basic.php文件的相应方法中体现即可。
				'keywords' => '关键词一,关键词二,关键词三',
				'description' => '这个页面的主要内容是一大波文章的列表'
			);

			// （可选）为侧边栏获取列表，此行仅作为示例
			$data['items'] = $this->basic_model->select();

			// Go Basic！
			$this->basic->detail($data, 'title', 'before'); // 当传入第二个参数时，将使用相应的字段值与上方传入的$data['title']进行拼接作为页面标题；如想直接使用该字段作为页面的标题，则$data['title']赋值为NULL即可；更多功能可见model/basic_model.php
		}

		// 回收站（一般为后台功能）
		public function trash()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn.'回收站',
				'class' => $this->class_name.' '. $this->class_name.'-trash'
				// 对于后台功能，一般不需要特别指定具体页面的keywords和description，下同
			);

			// Go Basic！
			$this->basic->trash($data);
		}

		// 创建项目（一般为后台功能）
		public function create()
		{
			// 页面信息
			$data = array(
				'title' => '创建'.$this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-create'
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
			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$excerpt = $this->input->post('excerpt');
			$data_to_create = array(
				'title' => $title, // 不建议直接用$this->input->post、$this->input->get等方法直接在此处赋值，分开处理会保持最大的灵活性以应对图片上传等场景
				'content' => $content,
				'excerpt' => $excerpt
			);

			// Go Basic!
			$this->basic->create($data, $data_to_create);
		}

		/**
		 * 编辑项目详情（一般为后台功能）
		 *
		 *
		 */
		public function edit()
		{
			// 页面信息
			$data = array(
				'title' => '编辑'.$this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-edit'
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
			$data_to_edit = array(
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'excerpt' => $this->input->post('excerpt')
			);

			// Go Basic!
			$this->basic->edit($data, $data_to_edit);
		}

		/**
		 * 批量处理单行或多行项目
		 *
		 * 一般用于存为草稿、上架、下架、删除、恢复等状态变化，请根据需要修改方法名，例如delete、restore、draft等
		 */
		public function delete()
		{
			$op_name = '删除'; // 操作的名称

			// 页面信息
			$data = array(
				'title' => $op_name. $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-delete'
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
				'time_delete' => date('y-m-d H:i:s')
				// 此处换为'time_delete' => NULL即可批量恢复
				// 此处换为'name' => 'value'即可批量修改其它数据
				// 添加多行'name' => 'value', 最后一行去掉逗号即可批量修改多个字段
			);

			// Go Basic!
			$this->basic->bulk($data, $data_to_edit, $op_name);
		}
	}

/* End of file Article.php */
/* Location: ./application/controllers/Article.php */
