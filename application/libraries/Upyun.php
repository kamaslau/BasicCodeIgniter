<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	* 又拍云类
	* http://docs.upyun.com/api/rest_api/
	*
	* @version 1.0.0
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SSEC <www.ssectec.com>
	*/
	class Upyun
	{
	    const VERSION            = '2.0';

	/*{{{*/
	    const ED_AUTO            = 'v0.api.upyun.com';
	    const ED_TELECOM         = 'v1.api.upyun.com';
	    const ED_CNC             = 'v2.api.upyun.com';
	    const ED_CTT             = 'v3.api.upyun.com';

	    const CONTENT_TYPE       = 'Content-Type';
	    const CONTENT_MD5        = 'Content-MD5';
	    const CONTENT_SECRET     = 'Content-Secret';

	    // 缩略图
	    const X_GMKERL_THUMBNAIL = 'x-gmkerl-thumbnail';
	    const X_GMKERL_TYPE      = 'x-gmkerl-type';
	    const X_GMKERL_VALUE     = 'x-gmkerl-value';
	    const X_GMKERL_QUALITY   = 'x­gmkerl-quality';
	    const X_GMKERL_UNSHARP   = 'x­gmkerl-unsharp';
	/*}}}*/

		// 以下为需要手动填写的又拍云空间名、操作员名、操作员密码
	    public $_bucketname = '空间名';
	    private $_username = '操作员名';
	    private $_password = '操作员密码';
		
	    private $_timeout = 30;
	    protected $endpoint;

	    /**
	    * @var string: UPYUN 请求唯一id, 出现错误时, 可以将该id报告给 UPYUN,进行调试
	    */
	    private $x_request_id;

		/**
		* 初始化 UpYun 存储接口
	    *
		* @return object
		*/
		public function __construct($endpoint = NULL)
		{/*{{{*/
	        $this->endpoint = is_null($endpoint) ? self::ED_AUTO : $endpoint;
		}/*}}}*/

	    /** 
	     * 创建目录
	     * @param $path 路径
	     * @param $auto_mkdir 是否自动创建父级目录，最多10层次
	     *
	     * @return void
	     */
	    public function makeDir($path, $auto_mkdir = false)
		{/*{{{*/
	        $headers = array('Folder' => 'true');
	        if ($auto_mkdir) $headers['Mkdir'] = 'true';
	        return $this->_do_request('PUT', $path, $headers);
	    }/*}}}*/

	    /**
	     * 删除目录和文件
	     * @param string $path 路径
	     *
	     * @return boolean
	     */
	    public function delete($path)
		{/*{{{*/
	        return $this->_do_request('DELETE', $path);
	    }/*}}}*/

	    /**
	     * 上传文件
	     * @param string $path 存储路径
	     * @param mixed $file 需要上传的文件，可以是文件流或者文件内容
	     * @param boolean $auto_mkdir 自动创建目录
	     * @param array $opts 可选参数
	     */
	    public function writeFile($path, $file, $auto_mkdir = False, $opts = NULL)
		{/*{{{*/
	        if (is_null($opts)) $opts = array();

	        if ($auto_mkdir === True) $opts['Mkdir'] = 'true';

	        $this->_file_infos = $this->_do_request('PUT', $path, $opts, $file);

	        return $this->_file_infos;
	    }/*}}}*/

	    /**
	     * 下载文件
	     * @param string $path 文件路径
	     * @param mixed $file_handle
	     *
	     * @return mixed
	     */
	    public function readFile($path, $file_handle = NULL)
		{/*{{{*/
	        return $this->_do_request('GET', $path, NULL, NULL, $file_handle);
	    }/*}}}*/

	    /**
	     * 获取目录文件列表
	     *
	     * @param string $path 查询路径
	     *
	     * @return mixed
	     */
	    public function getList($path = '/')
		{/*{{{*/
	        $rsp = $this->_do_request('GET', $path);

	        $list = array();
	        if ($rsp) {
	            $rsp = explode("\n", $rsp);
	            foreach($rsp as $item) {
	                @list($name, $type, $size, $time) = explode("\t", trim($item));
	                if (!empty($time)) {
	                    $type = $type == 'N' ? 'file' : 'folder';
	                }

	                $item = array(
	                    'name' => $name,
	                    'type' => $type,
	                    'size' => intval($size),
	                    'time' => intval($time),
	                );
	                array_push($list, $item);
	            }
	        }

	        return $list;
	    }/*}}}*/

	    /**
	     * 获取文件、目录信息
	     *
	     * @param string $path 路径
	     *
	     * @return mixed
	     */
	    public function getFileInfo($path)
		{/*{{{*/
	        $rsp = $this->_do_request('HEAD', $path);

	        return $rsp;
	    }/*}}}*/

		/**
		* 连接签名方法
		* @param $method 请求方式 {GET, POST, PUT, DELETE}
		* return 签名字符串
		*/
		private function sign($method, $uri, $date, $length)
		{/*{{{*/
	        //$uri = urlencode($uri);
			$sign = "{$method}&{$uri}&{$date}&{$length}&{$this->_password}";
			return 'UpYun '.$this->_username.':'.md5($sign);
		}/*}}}*/

	    /**
	     * HTTP REQUEST 封装
	     * @param string $method HTTP REQUEST方法，包括PUT、POST、GET、OPTIONS、DELETE
	     * @param string $path 除Bucketname之外的请求路径，包括get参数
	     * @param array $headers 请求需要的特殊HTTP HEADERS
	     * @param array $body 需要POST发送的数据
	     *
	     * @return mixed
	     */
	    protected function _do_request($method, $path, $headers = NULL, $body = NULL, $file_handle= NULL)
		{/*{{{*/
	        $uri = "/{$this->_bucketname}{$path}";
	        $ch = curl_init("http://{$this->endpoint}{$uri}");

	        $_headers = array('Expect:');
	        if (!is_null($headers) && is_array($headers)){
	            foreach($headers as $k => $v) {
	                array_push($_headers, "{$k}: {$v}");
	            }
	        }

	        $length = 0;
			$date = gmdate('D, d M Y H:i:s \G\M\T');

	        if (!is_null($body)) {
	            if(is_resource($body)){
	                fseek($body, 0, SEEK_END);
	                $length = ftell($body);
	                fseek($body, 0);

	                array_push($_headers, "Content-Length: {$length}");
	                curl_setopt($ch, CURLOPT_INFILE, $body);
	                curl_setopt($ch, CURLOPT_INFILESIZE, $length);
	            } else {
	                $length = @strlen($body);
	                array_push($_headers, "Content-Length: {$length}");
	                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	            }
	        } else {
	            array_push($_headers, "Content-Length: {$length}");
	        }

	        array_push($_headers, "Authorization: {$this->sign($method, $uri, $date, $length)}");
	        array_push($_headers, "Date: {$date}");

	        curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
	        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
	        curl_setopt($ch, CURLOPT_HEADER, 1);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

	        if ($method == 'PUT' || $method == 'POST') {
				curl_setopt($ch, CURLOPT_POST, 1);
	        } else {
				curl_setopt($ch, CURLOPT_POST, 0);
	        }

	        if ($method == 'GET' && is_resource($file_handle)) {
	            curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_FILE, $file_handle);
	        }

	        if ($method == 'HEAD') {
	            curl_setopt($ch, CURLOPT_NOBODY, true);
	        }

	        $response = curl_exec($ch);
	        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	        if ($http_code == 0) echo '连接失败';

	        curl_close($ch);

	        $header_string = '';
	        $body = '';

	        if ($method == 'GET' && is_resource($file_handle)) {
	            $header_string = '';
	            $body = $response;
	        } else {
	            list($header_string, $body) = explode("\r\n\r\n", $response, 2);
	        }
	        $this->setXRequestId($header_string);
	        if ($http_code == 200) {
	            if ($method == 'GET' && is_null($file_handle)) {
	                return $body;
	            } else {
	                $data = $this->_getHeadersData($header_string);
	                return count($data) > 0 ? $data : true;
	            }
	        } else {
	            $message = $this->_getErrorMessage($header_string);
	            if (is_null($message) && $method == 'GET' && is_resource($file_handle)) {
	                $message = '未找到文件';
	            }
	            switch($http_code) {
	                case 401:
	                    echo '401';
	                    break;
	                case 403:
	                    echo '403';
	                    break;
	                case 404:
	                    echo '404';
	                    break;
	                case 406:
	                    echo '406';
	                    break;
	                case 503:
	                    echo '503';
	                    break;
	                default:
	                    echo '其它错误';
	            }
	        }
	    }/*}}}*/

	    /**
	     * 处理HTTP HEADERS中返回的自定义数据
	     *
	     * @param string $text header字符串
	     *
	     * @return array
	     */
	    private function _getHeadersData($text)
		{/*{{{*/
	        $headers = explode("\r\n", $text);
	        $items = array();
	        foreach($headers as $header) {
	            $header = trim($header);
				if(stripos($header, 'x-upyun') !== False){
					list($k, $v) = explode(':', $header);
	                $items[trim($k)] = in_array(substr($k,8,5), array('width','heigh','frame')) ? intval($v) : trim($v);
				}
	        }
	        return $items;
	    }/*}}}*/

	    /**
	     * 获取返回的错误信息
	     *
	     * @param string $header_string
	     *
	     * @return mixed
	     */
	    private function _getErrorMessage($header_string)
		{
	        list($status, $stash) = explode("\r\n", $header_string, 2);
	        list($v, $code, $message) = explode(" ", $status, 3);
	        return $message . " X-Request-Id: " . $this->getXRequestId();
	    }

	    private function setXRequestId($header_string)
		{
	        preg_match('~^X-Request-Id: ([0-9a-zA-Z]{32})~ism', $header_string, $result);
	        $this->x_request_id = isset($result[1]) ? $result[1] : '';
	    }

	    public function getXRequestId()
		{
	        return $this->x_request_id;
	    }
	}
	// END Upyun Class
/* End of file Upyun.php */
/* Location: ./application/libraries/upyun.php */