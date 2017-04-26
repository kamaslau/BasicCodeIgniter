<?php
	/**
	 * 基础模型类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 * @copyright Basic <https://github.com/kamaslau/BasicCodeIgniter>
	 */
	class Basic_model extends CI_Model
	{
		/**
		 * 数据库表名
		 *
		 * @var string $table_name 表名
		 */
		public $table_name;

		/**
		 * 数据库主键名
		 *
		 * @var string $id_name 数据库主键名
		 */
		public $id_name;

		/**
		 * 初始化类
		 * @param void
		 * @return void
		 */
		public function __construct()
		{
			parent::__construct();
		}

		/**
		 * 返回符合单一条件的数据（单行）
		 *
		 * 一般用于根据手机号或Email查找用户是否存在等
		 *
		 * @param string $name 需要查找的字段名
		 * @param string $value 需要查找的字段值
		 * @return array 满足条件的结果数组
		 */
		public function find($name, $value)
		{
			$this->db->where($name, $value);

			$query = $this->db->get($this->table_name);
			return $query->row_array();
		}

		/**
		 * 返回符合多个条件的数据（单行）
		 *
		 * 一般用于根据手机号、密码查找用户并进行登录等
		 *
		 * @param array $data_to_search 需要查找的键值对
		 * @return array 满足条件的结果数组
		 */
		public function match($data_to_search)
		{
			$query = $this->db->get_where($this->table_name, $data_to_search);
			return $query->row_array();
		}

		// 根据当前用户的id验证密码是否正确，用于操作验证等情景
		// 应用于后台时，需要将user_id替换为stuff_id
		// 此方法应用频繁，不适合进一步抽象进前述match方法
		public function password_check()
		{
			$data = array(
				'stuff_id' => $this->session->stuff_id,
				'password' => sha1( $this->input->post('password') ),
			);

			$query = $this->db->get_where('stuff', $data);
			return $query->row_array();
		}

		/**
		 * 统计数量
		 *
		 * @param array $condition 需要统计的行的条件
		 * @param boolean $include_deleted 是否计算被标记为已删除状态的行
		 * @return int 满足条件的行的数量
		 */
		public function count($condition = NULL, $include_deleted = FALSE)
		{
			// 若存在统计条件，则按条件统计数量
			if ($condition !== NULL):
				foreach($condition as $name => $value):
					if ($value === 'IS NOT NULL'):
						$this->db->where("$name IS NOT NULL");
					else:
						$this->db->where($name, $value);
					endif;
				endforeach;
			endif;

			// 默认不计算被标记为已删除状态的行
			if ($include_deleted === TRUE)
				$this->db->where("`time_delete` IS NOT NULL");

			return $this->db->count_all_results($this->table_name);
		}

		/**
		 * 根据条件获取列表，默认不返回已删除项
		 *
		 * @param int $limit 需获取的行数，通过get或post方式传入
		 * @param int $offset 需跳过的行数，与$limit参数配合做分页功能，通过get或post方式传入
		 * @param array $condition 需要获取的行的条件
		 * @param array $order_by 结果集排序方式，默认为按创建日期由新到旧排列
		 * @param bool $return_ids 是否仅返回ID列表；默认为FALSE
		 * @param bool $allow_deleted 是否在返回结果中包含被标注为删除状态的行；默认为FALSE
		 * @return array 结果数组（默认为多维数组，$return_ids为TRUE时返回一维数组）
		 */
		public function select($condition = NULL, $order_by = NULL, $return_ids = FALSE, $allow_deleted = FALSE)
		{
			$limit = $this->input->get_post('limit')? $this->input->get_post('limit'): NULL; // 需要从数据库获取的数据行数
			$offset = $this->input->get_post('offset')? $this->input->get_post('offset'): NULL; // 需要从数据库获取的数据起始行数（与$limit配合可用于分页等功能）

			// 拆分筛选条件（若有）
			if ($condition !== NULL):
				foreach ($condition as $name => $value):
					if ($value === 'IS NOT NULL'):
						$this->db->where("$name IS NOT NULL");
					else:
						$this->db->where($name, $value);
					endif;
				endforeach;
			endif;

			// 拆分排序条件（若有）
			if ($order_by !== NULL):
				foreach ($order_by as $column_name => $value):
					$this->db->order_by($column_name, $value);
				endforeach;
			// 若未指定排序条件，则默认按照ID倒序排列
			else:
				$this->db->order_by($this->id_name, 'DESC');
			endif;
			
			// 默认不返回已删除项
			if ($allow_deleted === FALSE) $this->db->where('time_delete', NULL);

			if ($return_ids === TRUE) $this->db->select($this->id_name);

			$this->db->limit($limit, $offset);

			$query = $this->db->get($this->table_name);
			return $query->result_array();

			if ($return_ids === TRUE):
				// 多维数组转换为一维数组
				$ids = array();
				foreach ($results as $item):
					$ids[] = $item[$this->id_name]; // 返回当前行的主键
				endforeach;

				// 释放原结果数组以节省内存
				unset($results);

				// 返回数组
				return $ids;
			endif;
		}

		/**
		 * 根据ID获取特定项，默认不返回已删除项
		 *
		 * @param int $id 需获取的行的ID
		 * @param bool $allow_deleted 是否可返回被标注为删除状态的行；默认为TRUE
		 * @return array 结果行（一维数组）
		 */
		public function select_by_id($id, $allow_deleted = TRUE)
		{
			// 默认不返回已删除项
			if ($allow_deleted === FALSE) $this->db->where('time_delete', NULL);

			$this->db->where($this->id_name, $id);

			$query = $this->db->get($this->table_name);
			return $query->row_array();
		}

		/**
		 * 获取已删除项列表
		 *
		 * @param int $limit 需获取的行数，通过get或post方式传入
		 * @param int $offset 需跳过的行数，与$limit参数配合做分页功能，通过get或post方式传入
		 * @param array $condition 需要统计的行的条件
		 * @param array $order_by 结果集排序方式，默认为按创建日期由新到旧排列
		 * @param bool $return_ids 是否仅返回ID列表
		 * @return array 结果数组（默认为多维数组，$return_ids为TRUE时返回一维数组）
		 */
		public function select_trash($condition = NULL, $order_by = NULL, $return_ids = FALSE)
		{
			$limit = $this->input->get_post('limit')? $this->input->get_post('limit'): NULL; // 需要从数据库获取的数据行数
			$offset = $this->input->get_post('offset')? $this->input->get_post('offset'): NULL; // 需要从数据库获取的数据起始行数（与$limit配合可用于分页等功能）

			// 拆分筛选条件（若有）
			if ($condition !== NULL):
				foreach ($condition as $column_name => $value):
					$this->db->where($column_name, $value);
				endforeach;
			endif;

			// 拆分排序条件（若有）
			if ($order_by !== NULL):
				foreach ($order_by as $column_name => $value):
					$this->db->order_by($column_name, $value);
				endforeach;
			// 若未指定排序条件，则默认按照创建时间倒序排列
			else:
				$this->db->order_by('time_create', 'DESC');
			endif;

			if ($return_ids === TRUE) $this->db->select($this->id_name);

			$this->db->where('time_delete !=', NULL)
					->limit($limit, $offset);

			$query = $this->db->get($this->table_name);
			return $query->result_array();
			
			if ($return_ids === TRUE):
				// 多维数组转换为一维数组
				$ids = array();
				foreach ($results as $item):
					$ids[] = $item[$this->id_name]; // 返回当前行的主键
				endforeach;

				// 释放原结果数组以节省内存
				unset($results);

				// 返回数组
				return $ids;
			endif;
		}

		/**
		 * 创建
		 *
		 * @param array $data 待创建数据
		 * @param bool $return_id 若修改成功，是否返回被创建的行ID；默认不返回
		 * @return int|bool 创建结果
		 */
		public function create($data, $return_id = FALSE)
		{
			// 更新创建时间为当前时间，创建者和最后操作者为当前用户
			$data['time_create'] = date('Y-m-d H:i:s');
			if ( isset($this->session->stuff_id)):
				$data['creator_id'] = $this->session->stuff_id;
				$data['operator_id'] = $this->session->stuff_id;
			endif;

			// 尝试写入
			$insert_result = $this->db->insert($this->table_name, $data);

			// 直接返回结果，或返回写入后的行ID
			if ($return_id === TRUE && $insert_result === TRUE):
				return $this->db->insert_id();
			else:
				return $insert_result;
			endif;
		}

		/**
		 * 修改
		 *
		 * @param int $id 待修改项ID
		 * @param array $data 待修改数据
		 * @param bool $return_rows 若修改成功，是否返回被编辑的行数量；默认不返回
		 * @return int|bool 修改结果
		 */
		public function edit($id, $data, $return_rows = FALSE)
		{
			// 更新最后操作者为当前用户
			if (isset($this->session->stuff_id)):
				$data['operator_id'] = $this->session->stuff_id;
			endif;

			// 尝试更新
			$this->db->where($this->id_name, $id);
			$update_result = $this->db->update($this->table_name, $data);

			// 直接返回结果，或返回编辑过的行数量
			if ($return_rows === TRUE && $update_result === TRUE):
				$this->db->affected_rows();
			else:
				return $update_result;
			endif;
		}
	}

/* End of file Basic_model.php */
/* Location: ./application/models/Basic_model.php */