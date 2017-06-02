<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Basic类
	 *
	 * 提供了常见功能的示例代码
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
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
		 * 错误提示页面
		 *
		 * @param int $code 错误代码
		 * @param string $content 错误提示文本
		 * @return void
		 */
		public function error($code, $content)
		{
			$data = array(
				'title' => $code,
				'class' => 'error '.$code,
				'content' => $content,
			);

			$this->CI->load->view('templates/header', $data);
			$this->CI->load->view('error/'.$code, $data);
			$this->CI->load->view('templates/footer', $data);
		}

		/**
		 * 根据以空格分隔的以空格分隔的多个ID值获取相应数据
		 *
		 * @params string $ids_string 以空格分隔的多个ID值
		 * @params string $table_name 数据库表名
		 * @params string $id_name 数据库表主键名
		 */
		public function get_by_ids($ids_string, $table_name, $id_name)
		{
			// 设置数据库参数
			$this->CI->basic_model->table_name = $table_name;
			$this->CI->basic_model->id_name = $id_name;

			// 返回的数据为数组格式
			$data_to_return = array();
			
			// 拆分出需获取的各ID为数组值
			$ids = explode(' ', $ids_string);

			// 根据ID获取相应数据
			foreach ($ids as $id):
				$data_to_return[] = $this->CI->basic_model->select_by_id($id);
			endforeach;
			
			// 还原原有数据库参数
			$this->CI->basic_model->table_name = $this->CI->table_name;
			$this->CI->basic_model->id_name = $this->CI->id_name;

			return $data_to_return;
		}
		
		/**
		 * 根据ID值获取相应数据
		 *
		 * @params string $id ID值
		 * @params string $table_name 数据库表名，默认为当前类属性相应值
		 * @params string $id_name 数据库表主键名，默认为当前类属性相应值
		 */
		public function get_by_id($id, $table_name, $id_name)
		{
			// 设置数据库参数
			$this->CI->basic_model->table_name = $table_name;
			$this->CI->basic_model->id_name = $id_name;

			// 根据ID获取相应数据
			$data_to_return = $this->CI->basic_model->select_by_id($id);
			
			// 还原原有数据库参数
			$this->CI->basic_model->table_name = $this->CI->table_name;
			$this->CI->basic_model->id_name = $this->CI->id_name;

			return $data_to_return;
		}
		
		/**
		 * 保存EXCEL文件中数据到数据库
		 *
		 * 集成了PHPExcel开源库
		 * TODO 将PHPexcel分离为一个独立的库
		 *
		 * @param string $file_url 文件路径
		 */
		public function upload_excel($data, $file_url)
		{
			$this->CI->load->view('templates/header', $data); // 载入视图文件，下同
			// 载入相关类文件
			require_once 'phpexcel/Classes/PHPExcel.php';
			require_once 'phpexcel/Classes/PHPExcel/IOFactory.php';

			// 解析文件并生成文件对象
			$objPHPExcel = PHPExcel_IOFactory::load($file_url); // 自动判断文件格式并解析文件流
			$sheet = $objPHPExcel->setActiveSheetIndex(0); // 获取第一个工作表为当前工作表
			$sheet = $objPHPExcel->getActiveSheet(); // 获取当前工作表
			$row_count = $sheet->getHighestRow(); // 表格最大行号（例如10），用于循环读取每行数据
			$column_max = $sheet->getHighestColumn(); // 表格最大列名（例如D）
			$column_count = PHPExcel_Cell::columnIndexFromString($column_max);

			echo '<p>此表共有'.$row_count.'行，'.$column_count.'列（'.$column_max.'）</p>';
?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<?php
				$data_to_process = $this->CI->data_to_process;
				foreach ($data_to_process as $key):
					echo '<th>'. $key[1]. '</th>';
				endforeach;
				?>
				<th>上传结果</th>
			</tr>
		</thead>

		<tbody>
<?php
			// 循环读取并写入每行数据到数据库
			// 可以通过设置$i=2的初始值来跳过表头；无表头$i=1
			$data_to_process = $this->CI->data_to_process; // 获取EXCEL表中需要的列信息
			for ($i = 2; $i <= $row_count; $i++)
			{
				// 跳过第一列没有内容的行（视为空行）
				$first_cell = $sheet->getCell('A'.$i)->getValue();
				if ( isset($first_cell) ):
					$data_to_create = array(); // 保存当前行的数据
					// 当前行每列的值
					for ($column = 0; $column < count($data_to_process); $column++):
						$current_cell = $sheet->getCellByColumnAndRow($column,$i);
						$tr[$column] = $current_cell->getValue();
						// 按键值对保存每行，检查是否遗漏了未填项
						if ( empty($tr[$column]) && ( $data_to_process[$column][3] === TRUE) )exit($data_to_process[$column][1].'项不可留空，请完善原表后重试^_^。');
						$data_to_create[$data_to_process[$column][0]] = $current_cell->getValue();
					endfor;

					// 使用当前行数据在数据库中创建记录，并返回数据库中的行ID
					$row_id = $this->CI->basic_model->create($data_to_create, TRUE);
		
					// 生成当前行数据为视图需要的数据
					$item = $data_to_create;
					$item[$this->CI->id_name] = $row_id;
					$data['items'][] = $item;
				endif;
			}

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
			$current_role = $this->CI->session->role;
			$current_level = $this->CI->session->level;

			// 检查执行此操作的角色及权限要求
			if ( ! in_array($current_role, $role_allowed)):
				redirect( base_url('error/permission_role') );
			elseif ( $current_level < $min_level):
				redirect( base_url('error/permission_level') );
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
		 * 获取多行数据
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param int $limit 需获取的行数
		 * @param int $offset 需跳过的行数，与$limit参数配合做分页功能
		 * @param array $condition 需要获取的行的条件
		 * @param array $order_by 结果集排序方式，默认为按创建日期由新到旧排列
		 * @return void
		 */
		public function index($data, $condition, $order_by)
		{
			// 调用模型类，获取相应数据，下略
			$data['items'] = $this->CI->basic_model->select($condition, $order_by);
			$data['ids'] = $this->CI->basic_model->select($condition, $order_by, TRUE);

			// 调用视图类，生成页面HTML，下略
			$this->CI->load->view('templates/header', $data); // 载入视图文件，下同
			$this->CI->load->view($this->view_root.'index', $data);
			$this->CI->load->view('templates/footer', $data);
		}

		/**
		 * 获取单行数据
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param int $id 需获取的数据ID（一般为主键值）
		 * @param string $title_name 用于页面标题的字段名
		 * @param string $position 拼接页面标题的位置，'after'为拼接到$data['title']之后，'before'是拼接到$data['title']之前
		 * @return void
		 */
		public function detail($data, $title_name = NULL, $position = 'after')
		{
			// 检查是否已传入必要参数
			$id = $this->CI->input->get_post('id')? $this->CI->input->get_post('id'): NULL;
			if ( empty($id) )
				redirect(base_url('error/code_404'));

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
		public function trash($data, $condition, $order_by)
		{
			$data['items'] = $this->CI->basic_model->select_trash($condition, $order_by);
			$data['ids'] = $this->CI->basic_model->select_trash($condition, $order_by, TRUE);

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
				$data['error'] = validation_errors();

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
		 * @param array $id 需编辑的数据ID，用post或get方式传入
		 * @return void
		 */
		public function edit($data, $data_to_edit, $view_file_name = NULL)
		{
			// 检查是否已传入必要参数
			$id = $this->CI->input->get_post('id')? $this->CI->input->get_post('id'): NULL;
			if ( empty($id) )
				redirect(base_url('error/code_404'));

			// 获取待编辑信息
			$data['item'] = $this->CI->basic_model->select_by_id($id);

			// 验证表单值格式
			if ($this->CI->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

				$this->CI->load->view('templates/header', $data);
				if ($view_file_name === NULL):
					$this->CI->load->view($this->view_root.'edit', $data);
				else:
					$this->CI->load->view($this->view_root.$view_file_name, $data);
				endif;

			else:
				$result = $this->CI->basic_model->edit($id, $data_to_edit);
				if ($result !== FALSE):
					$data['content'] = '<p class="alert alert-success">保存成功。</p>';
				else:
					$data['content'] = '<p class="alert alert-warning">保存失败。</p>';
				endif;

				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root.'result', $data);

			endif;
			
			// 载入页尾视图
			$this->CI->load->view('templates/footer', $data);
		}

		/**
		 * 编辑多行数据
		 *
		 * 一般为后台功能，单独或批量编辑多行数据的单独或多个字段；
		 * 简单修改359行即可应用于单独或批量删除、恢复、上架、下架、发布、存为草稿等场景
		 *
		 * @param array $data 从控制器中直接传入的数据
		 * @param array $ids 需编辑的数据ID们，用post方式传入，单独编辑时只传入1个ID即可
		 * @param array $op_name 批量操作的名称，例如“删除”、“下架”、“恢复”等等
		 * @param array $op_view 视图文件名
		 * @return void
		 */
		public function bulk($data, $data_to_edit, $op_name, $op_view) // 视图文件名)
		{
			// 从表单获取待修改项ID数组，或从URL获取待修改单项ID后转换为数组
			$this->CI->input->post('ids')? $ids = $this->CI->input->post('ids'): $ids[0] = $this->CI->input->get('ids');
			if (count($ids) === 1 && strpos($ids[0], '|') !== FALSE):
				$ids = explode('|', $ids[0]);
			endif;

			// 验证表单值格式
			if ($this->CI->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

				$data['ids'] = $ids;
				foreach ($ids as $id):
					$data['items'][] = $this->CI->basic_model->select_by_id($id);
				endforeach;

				$this->CI->load->view('templates/header', $data);
				$this->CI->load->view($this->view_root. $op_view, $data);
				$this->CI->load->view('templates/footer', $data);

			else:
				// 核对管理员密码
				if ($this->CI->basic_model->password_check() === NULL):
					$data = array(
						'title' => '密码错误',
						'content' => '<p>您的操作密码错误，请重试。</p>',
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
