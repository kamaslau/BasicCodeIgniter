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
		 * 输出表单各输入项
		 *
		 * @param array $input 字段数据
		 * @param string $type 表单类型；edit编辑，create创建
		 * @param array $item 需要编辑/修改的数据
		 */
		public function generate_input($input, $type = 'edit', $item = NULL)
		{
			?>
		<div class=form-group>
		<?php echo '<label for='. $input[0]. ' class="col-sm-2 control-label">'. $input['1']. (( $input[3] === FALSE )? '（选填）': NULL). '</label>' ?>
			<div class=col-sm-10>
		<?php
			// 生成输入字段
			$input_type = array('text', 'number', 'email', 'tel', 'date', 'datetime', 'password', 'color');
			if ( in_array($input[5], $input_type) ):
				$input_html = '<input class=form-control name='. $input[0].' type='. $input[5];
				$input_html .= ( isset($input[6]) )? ' '.$input[6]: NULL;
				$input_html .= ( isset($input[4]) )? ' placeholder="'.$input[4].'"': NULL;
				$input_html .= ( $input[3] === TRUE )? ' required': NULL;
				
				if ($type === 'edit'):
					$input_html .= ' value="'. $item[$input[0]] .'"';
				else:
					$input_html .= ' value="'. set_value($input[0]) .'"';
				endif;
				$input_html .= '>';

			elseif ($input[5] === 'select'):
				$input_html = '<select class=form-control name='. $input[0]. (( $input[3] === TRUE )? ' required': NULL). '>';
				foreach ($input[7] as $option):
					if ($type === 'edit'):
						$selected = ($option === $item[$input[0]])? ' selected': NULL;
						$input_html .= '<option value="'.$option.'"'.$selected.'>'.$option.'</option>';
					else:
						$input_html .= '<option value="'.$option.'">'.$option.'</option>';
					endif;
				endforeach;
				$input_html .= '</select>';

			elseif ($input[5] === 'textarea'):
				$input_html = '<textarea class=form-control name='. $input[0]. (( $input[3] === TRUE )? ' required': NULL);
				if ($type === 'edit'):
					$input_html .= ' value="'. $item[$input[0]] .'"';
				else:
					$input_html .= ' value="'. set_value($input[0]) .'"';
				endif;
				$input_html .= '>';
				$input_html .= '</textarea>';

			endif;

			echo $input_html;
			echo form_error($input[0]);
		?>
			</div>
		</div>
		<?php
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
		 * 保存EXCEL文件中数据到数据库
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
			for ($i = 2; $i <= count($data_to_process); $i++)
			{
				// 跳过第一个单元格没有内容的行（视为空行）
				$first_cell = $sheet->getCell('A'.$i)->getValue();
				if ( isset($first_cell) ):
					$data_to_create = array(); // 保存当前行的数据
					// 当前行每列的值
					for ($column = 0; $column < $column_count; $column++):
						$current_cell = $sheet->getCellByColumnAndRow($column,$i);
						$tr[$column] = $current_cell->getValue();
						// 按键值对保存每行
						$data_to_create[$data_to_process[$column][0]] = $current_cell->getValue();
					endfor;
			
					// 使用当前行数据在数据库中创建记录
					$result = $this->CI->basic_model->create($data_to_create);

					// 输出HTML
					echo '<tr>';
					foreach ($tr as $item):
						echo '<td>'.$item.'</td>';
					endforeach;
					echo '	<td>'. ($result !== FALSE? '上传成功': '上传失败'). '</td>'; // 上传结果
					echo '</tr>';
				endif;
			}

			$this->CI->load->view('templates/footer', $data);
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
			$id = $this->CI->input->get_post('id')? $this->CI->input->get_post('id'): $data['id'];

			// 检查是否已传入必要参数
			if ( empty($id) ):
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