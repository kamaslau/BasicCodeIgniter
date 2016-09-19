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

		public function __construct()
		{
			parent::__construct();

			// （可选）未登录用户转到登录页
			//if ($this->session->logged_in !== TRUE) redirect(base_url('login'));

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);

			// 设置并调用Basic核心库
			$basic_configs = array(
				'table_name' => 'article',
				'id_name' => 'article_id',
				'view_root' => $this->class_name
			);
			$this->load->library('basic', $basic_configs);

			// （可选）某些用于此类的自定义函数
		    function function_name($parameter)
			{
				//...
		    }
		}

		// 列表页
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => '', // 页面标题
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
				'title' => '文章详情',
				'class' => $this->class_name.' '. $this->class_name.'-detail',
				'keywords' => '关键词一,关键词二,关键词三',
				'description' => '这个页面的主要内容是一大波文章的列表'
			);
			
			// Go Basic！
			$this->basic->detail($data, 'title'); // 当传入第二个参数时，将使用相应的字段值与上方传入的$data['title']进行拼接；如想直接使用该字段作为页面的title，则$data['title']设为NULL即可；更多功能可见model/basic_model.php
		}
		
		// 回收站（一般为后台功能）
		public function trash()
		{
			// 页面信息
			$data = array(
				'title' => '回收站',
				'class' => 'class' => $this->class_name.' '. $this->class_name.'-trash'
				// 对于后台功能，一般不需要特别指定具体页面的keywords和description
			);
			
			// Go Basic！
			$this->basic->trash($data);
		}
	}

/* End of file Class_name.php */
/* Location: ./application/controllers/Class_name.php */