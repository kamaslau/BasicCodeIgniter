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

		public $limit = NULL;
		public $offset = NULL;

		/**
		 * 构造函数
         *
         * @param void
		 */
		public function __construct()
		{
			// CI_Model类无构造函数，无需继承
		} // end __construct

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
		} // end find

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
		} // end match

		/**
		 * 统计数量
		 *
		 * @param array $condition 需要统计的行的条件
		 * @param boolean $include_deleted 是否计算被标记为已删除状态的行
		 * @return int 满足条件的行的数量
		 */
		public function count($condition = NULL, $include_deleted = TRUE)
		{
			// 拆分筛选条件（若有）
			if ($condition !== NULL):
				foreach ($condition as $name => $value):
					if ($value === 'NULL'):
						$this->db->where("$name IS NULL");

					elseif ($value === 'IS NOT NULL'):
						$this->db->where("$name IS NOT NULL");
					
					else:
						$this->db->where($name, $value);
					endif;
				endforeach;
			endif;

			// 默认不计算被标记为已删除状态的行
			if ($include_deleted === FALSE)
				$this->db->where("`time_delete` IS NULL");

			return $this->db->count_all_results($this->table_name);
		} // end count

		/**
		 * 根据条件获取列表，默认可返回已删除项
		 *
		 * @param int $limit 需获取的行数，通过get或post方式传入
		 * @param int $offset 需跳过的行数，与$limit参数配合做分页功能，通过get或post方式传入
		 * @param array $condition 需要获取的行的条件
		 * @param array $order_by 结果集排序方式，默认为按创建日期由新到旧排列
		 * @param bool $return_ids 是否仅返回ID列表；默认为FALSE
		 * @param bool $allow_deleted 是否在返回结果中包含被标注为删除状态的行；默认为FALSE
		 * @return array 结果数组（默认为多维数组，$return_ids为TRUE时返回一维数组）
		 */
		public function select($condition = NULL, $order_by = NULL, $return_ids = FALSE, $allow_deleted = TRUE)
		{
            // 需要从数据库获取的数据行数
            if ($this->limit === NULL && !empty($this->input->get_post('limit'))):
                $this->limit = $this->input->get_post('limit');
            endif;

            // 需要从数据库获取的数据起始行数（与$limit配合可用于分页等功能）
            if ($this->offset === NULL && !empty($this->input->get_post('offset'))):
                $this->offset = $this->input->get_post('offset');
            endif;

            $this->db->limit($this->limit, $this->offset);

			// 拆分筛选条件（若有）
			if ($condition !== NULL):
				foreach ($condition as $name => $value):
					if ($value === 'NULL'):
						$this->db->where("$name IS NULL");

					elseif ($value === 'IS NOT NULL'):
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
			endif;

			// 默认可返回已删除项
            if ($allow_deleted === FALSE && !isset($condition['time_delete']))
                $this->db->where("time_delete IS NULL");

            // 获取数据
            $query = $this->db->get($this->table_name);

            // 可选择仅返回符合条件项的ID列表
            if ($return_ids === FALSE):
                return $query->result_array();

            else:
                // 多维数组转换为一维数组
                $ids = array();
                $result = $query->result_array();

                foreach ($result as $item):
                    $ids[] = $item[$this->id_name]; // 返回当前行的主键
                endforeach;

                unset($result); // 释放原结果数组以节省内存

                // 返回数组
                return $ids;

            endif;
		} // end select

		/**
		 * 根据ID获取特定项，默认可返回已删除项
		 *
		 * @param int $id 需获取的行的ID
		 * @param bool $allow_deleted 是否可返回被标注为删除状态的行；默认为TRUE
		 * @return array 结果行（一维数组）
		 */
		public function select_by_id($id, $allow_deleted = TRUE)
		{
			// 默认可返回已删除项
			if ($allow_deleted === FALSE) $this->db->where('time_delete', NULL);

			$this->db->where($this->id_name, $id);

			$query = $this->db->get($this->table_name);
			return $query->row_array();
		} // end select_by_id

        /**
         * 根据CSV格式的ID们字符串获取列表，默认可返回已删除项
         *
         * @param string $ids
         * @param array $condition
         * @param bool $allow_deleted
         * @return mixed
         */
		public function select_by_ids($ids, $condition = NULL, $allow_deleted = TRUE)
		{
            // 拆分筛选条件（若有）
            if ($condition !== NULL):
                foreach ($condition as $name => $value):
                    if ($value === 'NULL'):
                        $this->db->where("$name IS NULL");

                    elseif ($value === 'IS NOT NULL'):
                        $this->db->where("$name IS NOT NULL");

                    else:
                        $this->db->where($name, $value);

                    endif;
                endforeach;
            endif;

            // 默认可返回已删除项
            if ($allow_deleted === FALSE && !isset($condition['time_delete']))
                $this->db->where("time_delete IS NULL");

			// 拆分字符串为数组
			$ids = explode(',', trim($ids, ',')); // 清除多余的前后半角逗号
            $this->db->group_start();
			foreach ($ids as $id):
				$this->db->or_where($this->id_name, $id);
			endforeach;
            $this->db->group_end();

			$query = $this->db->get($this->table_name);
			return $query->result_array();
		} // end select_by_ids

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
            // 需要从数据库获取的数据行数
            if ($this->limit === NULL && !empty($this->input->get_post('limit'))):
                $this->limit = $this->input->get_post('limit');
            endif;

            // 需要从数据库获取的数据起始行数（与$limit配合可用于分页等功能）
            if ($this->offset === NULL && !empty($this->input->get_post('offset'))):
                $this->offset = $this->input->get_post('offset');
            endif;

            $this->db->limit($this->limit, $this->offset);
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

			$this->db->where('time_delete IS NOT NULL');

            $query = $this->db->get($this->table_name);

            // 可选择仅返回符合条件项的ID列表
            if ($return_ids === FALSE):
                return $query->result_array();

            else:
                // 多维数组转换为一维数组
                $ids = array();
                $result = $query->result_array();

                foreach ($result as $item):
                    $ids[] = $item[$this->id_name]; // 返回当前行的主键
                endforeach;

                unset($result); // 释放原结果数组以节省内存

                // 返回数组
                return $ids;

            endif;
		} // end select_trash

		/**
		 * 创建
		 *
		 * @param array $data 待创建数据
		 * @param bool $return_id 若修改成功，是否返回被创建的行ID；默认不返回
		 * @return int|bool 创建结果
		 */
		public function create($data, $return_id = FALSE)
		{
			// 未传入创建时间时，默认创建时间为当前时间，创建者和最后操作者为当前用户
			if ( !isset($data['time_create']) )
				$data['time_create'] = date('Y-m-d H:i:s');

			// 尝试写入
			$insert_result = $this->db->insert($this->table_name, $data);

			// 直接返回结果，或返回写入后的行ID
			if ($return_id === TRUE && $insert_result === TRUE):
				return $this->db->insert_id();
			else:
				return $insert_result;
			endif;
		} // end create

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
			// 尝试更新
			$this->db->where($this->id_name, $id);
			$update_result = $this->db->update($this->table_name, $data);

			// 直接返回结果，或返回编辑过的行数量
			if ($return_rows === TRUE && $update_result === TRUE):
				$this->db->affected_rows();
			else:
				return $update_result;
			endif;
		} // end edit

        // TODO 待应用到具体业务并测试
        // 根据当前用户的id验证密码是否正确，用于操作验证等情景
        // 此方法应用频繁，不适合进一步抽象进前述match方法
        public function password_check($id_name = 'stuff')
        {
            $data = array(
                "{$id_name}_id" => $this->session->{$id_name.'_id'},
                'password' => sha1( $this->input->post('password') ),
            );

            $query = $this->db->get_where($id_name, $data);
            return $query->row_array();
        } // end password_check

	} // end Class Basic_model

/* End of file Basic_model.php */
/* Location: ./application/models/Basic_model.php */