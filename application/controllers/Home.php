<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Home 类
	 *
	 * 首页的示例代码示例代码
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright SSEC <www.ssectec.com>
	 */
	class Home extends CI_Controller
	{
		/* 类名称小写，应用于多处动态生成内容 */
		public $class_name;

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
		}

		// 首页
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => NULL, // 直接使用默认标题
				'class' => $this->class_name.' '. $this->class_name.'-index' // 页面body标签的class属性值
			);
			
			// 载入视图
			$this->load->view('templates/header', $data);
			$this->load->view('home', $data);
			$this->load->view('templates/footer', $data);
		}
	}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */