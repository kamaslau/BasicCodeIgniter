<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Resource Class
	 *
	 * 以车源的列表、详情等功能提供了常见功能的示例代码
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright SSEC <www.ssectec.com>
	 */
	class Resource extends CI_Controller
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
		
		/* 需要处理的主要数据 */
		public $data_to_process;

		public function __construct()
		{
			parent::__construct();

			// 未登录用户转到登录页
			if ($this->session->logged_in !== TRUE) redirect(base_url('login'));

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '车源'; // 改这里……
			$this->table_name = 'resource'; // 和这里……
			$this->id_name = 'resource_id';  // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 特殊情况下可能需要修改视图文件所在目录名，注意不要以'/'结尾。
			// 需要验证并处理（例如存入数据库等）的数据
			// 格式为 array(字段名, 字段汉语名称，适用于CI表单验证功能的验证内容，是否为必填项，视图中使用的placeholder内容（可选），视图中使用的input类型，视图中使用的字段属性（可选），视图中若使用select、option等输入类型时可用的选项值（可选）);
			$this->data_to_process = array(
				array('province', '所在省份', 'trim|required', TRUE, '仅需填写简称，如山东、内蒙古、西藏等，最多3个汉字', 'text'),
				array('city', '所在地级市', 'trim', FALSE, '仅需填写简称，如青岛、拉萨等，最多10个汉字', 'text'),
				array('brand', '品牌', 'trim|required', TRUE, '最多10个汉字', 'text'),
				array('biz', '企业/经销商名称', 'trim|required', TRUE, '最多30个汉字', 'text'),
				array('model', '车型', 'trim|required', TRUE, '最多255个字符', 'text'),
				array('color_outer', '车身颜色', 'trim', TRUE, '主要车身颜色名，不加“色”字', 'text'),
				array('color_inner', '内饰颜色', 'trim', TRUE, '主要内饰颜色名，不加“色”字', 'text'),
				array('year', '出厂年份', 'trim|required', TRUE, '最早允许填写1900，最多允许填写未来2年内的年份，例如'. date('Y', strtotime("+2year")), 'number', 'step=1 min=1900 max='.date('Y', strtotime("+2year"))),
				array('month', '出厂月份', 'trim', FALSE, NULL, 'number', 'step=1 min=1 max=12'),
				array('count', '数量（台）', 'trim|required', TRUE, '最多“999”', 'number', 'step=1 min=1 max=999'),
				array('tag_price', '指导价/市场价（万元）', 'trim|required', TRUE, '中规车请填写指导价，平行进口车、二手车等请填写市场价', 'number', 'step=0.01 min=0.01 max=9999.99'),
				array('price', '不开票价格（万元）', 'trim|required', TRUE, '不含费、税等的供应价', 'number', 'step=0.01 min=0.01 max=9999.99'),
				array('voucher_type', '凭据种类', 'trim|required', TRUE, '例如普通发票、增值税发票、可增可普、可议等', 'select', NULL, array('普通发票', '增值税发票', '可增可普', '可议')),
				array('voucher_price', '开票价格（万元）', 'trim|required', TRUE, '含费、税等的供应价', 'number', 'step=0.01 min=0.01 max=9999.99'),
				array('note', '备注', 'trim', FALSE, '最多255个字符', 'textarea')
			);

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
				'description' => '这个页面的主要内容是一大波车源的列表' // （可选，后台功能可删除此行）页面内容描述
			);

			// 将需要处理的数据传到视图以备使用
			$data['data_to_process'] = $this->data_to_process;

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
				'description' => '这个页面的主要内容是一大波车源的列表'
			);
			
			// 将需要处理的数据传到视图以备使用
			$data['data_to_process'] = $this->data_to_process;

			// Go Basic！
			$this->basic->detail($data); // 当传入第二个参数时，将使用相应的字段值与上方传入的$data['title']进行拼接作为页面标题；如想直接使用该字段作为页面的标题，则$data['title']赋值为NULL即可；更多功能可见model/basic_model.php
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
			
			// 将需要处理的数据传到视图以备使用
			$data['data_to_process'] = $this->data_to_process;

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

			// 将需要处理的数据传到视图以备使用
			$data['data_to_process'] = $this->data_to_process;
			
			// 循环进行表单验证并整理需要存入数据库的信息
			foreach ($this->data_to_process as $item):
				$this->form_validation->set_rules($item[0], $item[1], $item[2]);
				
				${$item[0]} = $this->input->post($item[0]);
				$data_to_create[$item[0]] = ${$item[0]};
			endforeach;
			
			// 对需要特别处理的数据进行修改，如此例；不需要则可以直接删除改行
			//$data_to_create['password'] = SHA1($password); // FYI：$password变量已在上一步进行创建和赋值

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
				'title' => '编辑'. $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-edit'
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/

			// 将需要处理的数据传到视图以备使用
			$data['data_to_process'] = $this->data_to_process;

			// 循环进行表单验证并整理需要存入数据的信息
			foreach ($this->data_to_process as $item):
				$this->form_validation->set_rules($item[0], $item[1], $item[2]);
				
				${$item[0]} = $this->input->post($item[0]);
				$data_to_edit[$item[0]] = ${$item[0]};
			endforeach;
			
			// 对需要特别处理的数据进行修改，如此例；不需要则可以直接删除改行
			//$data_to_create['password'] = SHA1($password); // FYI：$password变量已在上一步进行创建和赋值

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
				'class' => $this->class_name.' '. $this->class_name.'-delete'
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/

			// 将需要处理的数据传到视图以备使用
			$data['data_to_process'] = $this->data_to_process;

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
				'class' => $this->class_name.' '. $this->class_name.'-restore'
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/

			// 将需要处理的数据传到视图以备使用
			$data['data_to_process'] = $this->data_to_process;

			// 待验证的表单项
			$this->form_validation->set_rules('password', '密码', 'trim|required|is_natural|exact_length[6]');

			// 需要存入数据库的信息
			$data_to_edit = array(
				'time_delete' => NULL
				// 此处换为'time_delete' => NULL即可批量恢复
				// 此处换为'name' => 'value'即可批量修改其它数据
				// 添加多行'name' => 'value', 最后一行去掉逗号即可批量修改多个字段
			);

			// Go Basic!
			$this->basic->bulk($data, $data_to_edit, $op_name, $op_view);
		}

		// 上传并保存EXCEL表格中内容到数据库
		public function upload()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '上传',
				'class' => $this->class_name.' '. $this->class_name.'-upload'
			);

			// 检查操作权限
			/*
			$role_allowed = array('editor', 'manager'); // 员工角色要求
			$min_level = 0; // 员工最低权限
			$this->basic->permission_check($role_allowed, $min_level);
			*/
			$this->form_validation->set_rules('userfile', '每日资源表', 'trim');
			
			// 若上传不成功
			if ($this->form_validation->run() === FALSE || $_FILES['userfile']['error'] != '0'):
				if ($_SERVER['REQUEST_METHOD'] === 'POST'):
					$data['error'] = '请上传每日资源表！';
				endif;
				
				// 调用视图类，生成页面HTML，下略
				$this->load->view('templates/header', $data); // 载入视图文件，下同
				$this->load->view($this->view_root.'/upload', $data);
				$this->load->view('templates/footer', $data);

			else:
				//尝试上传
				$config['upload_path'] = './uploads/excel/';
				$config['file_name'] = date('Ymd_His');
				$config['file_ext_tolower'] = TRUE; // 文件名后缀转换为小写
				$config['allowed_types'] = 'xls|xlsx';
				$config['max_size'] = '2048'; // 文件不得大于2M
				$this->load->library('upload', $config);
				
				// 若上传不成功
				if ( ! $this->upload->do_upload()):
				    $data['error'] = $this->upload->display_errors();
					echo $upload_path;
					$this->load->view('templates/header', $data); // 载入视图文件，下同
					$this->load->view($this->view_root.'/upload', $data);
					$this->load->view('templates/footer', $data);
				else:
					$data['upload_data'] = $this->upload->data();

					// 获取上传的文件路径
					$file_url = $config['upload_path'].$data['upload_data']['file_name'];
					// Go Basic!
					$this->basic->upload_excel($data, $file_url);
				endif;
			endif;
		}
	}

/* End of file Resource.php */
/* Location: ./application/controllers/Resource.php */
