<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Home 类
	 *
	 * 首页的示例代码示例代码
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Home extends CI_Controller
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
        
        /* 需要显示的字段 */
        public $data_to_display;
        
        public function __construct()
        {
            parent::__construct();
            
            // 向类属性赋值
            $this->class_name = strtolower(__CLASS__);
            $this->class_name_cn = '类名'; // 改这里……
            $this->table_name = 'table'; // 和这里……
            $this->id_name = 'table_id';  // 还有这里，OK，这就可以了
            $this->view_root = $this->class_name;
            
            // 设置并调用Basic核心库
            $basic_configs = array(
               'table_name' => $this->table_name,
               'id_name' => $this->id_name,
               'view_root' => $this->view_root,
            );
            // 设置需要显示的字段
            $this->data_to_display = array(
               'name' => '名称',
               'description' => '描述',
            );
            
            // 载入Basic库
            $this->load->library('basic', $basic_configs);
            
            // （可选）某些用于此类的自定义函数
            function function_name($parameter)
            {
                //...
            }
        }

		// 首页
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => NULL, // 直接使用默认标题
				'class' => $this->class_name.' '. $this->class_name.'-index', // 页面body标签的class属性值
			);
			
			// 载入视图
			$this->load->view('templates/header', $data);
			$this->load->view('home', $data);
			$this->load->view('templates/footer', $data);
		}
	}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
