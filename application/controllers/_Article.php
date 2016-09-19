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

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '文章'; // 改这里……
			$this->table_name = 'article'; // 和这里……
			$this->id_name = 'article_id';  // 还有这里，OK，这就可以了。

			// 设置并调用Basic核心库
			$basic_configs = array(
				'table_name' => $this->table_name,
				'id_name' => $this->id_name,
				'view_root' => $this->class_name
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
				'class' => $this->class_name.' '. $this->class_name.'-detail',
				'keywords' => '关键词一,关键词二,关键词三',
				'description' => '这个页面的主要内容是一大波文章的列表'
			);

			// （可选）为侧边栏获取列表
			$data['items'] = $this->basic_model->select();

			// Go Basic！
			$this->basic->detail($data, 'title', 'before'); // 当传入第二个参数时，将使用相应的字段值与上方传入的$data['title']进行拼接作为页面标题；如想直接使用该字段作为页面的标题，则$data['title']赋值为NULL即可；更多功能可见model/basic_model.php
		}
	}

/* End of file Article.php */
/* Location: ./application/controllers/Article.php */