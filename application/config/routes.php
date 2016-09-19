<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* Home 首页 */
$route['home'] = 'home/index'; // 首页

/* Account 账号 */
$route['login'] = 'account/login'; // 登录
$route['register'] = 'account/register'; // 注册
$route['logout'] = 'account/logout'; // 退出当前账号
$route['email_reset'] = 'account/email_reset'; // 换绑Email（仅限登录后）
$route['mobile_reset'] = 'account/mobile_reset'; // 换绑手机号（仅限登录后）
$route['password_reset'] = 'account/password_reset'; // 重置密码（仅限登录前）
$route['password_change'] = 'account/password_change'; // 修改密码（仅限登录后）
$route['account'] = 'account/index'; // 账户中心（仅限登录后）

/* 以下按控制器类名称字母降序排列 */

/* Article 文章 */
$route['article/detail'] = 'article/detail'; // 文章详情
$route['article/create'] = 'article/create'; // 创建文章
$route['article/edit'] = 'article/edit'; // 编辑文章
$route['article'] = 'article/index'; // 文章列表

/* User 用户（无社交功能的前台一般可删除此组） */
$route['user/detail'] = 'user/detail'; // 用户详情
$route['user'] = 'user/index'; // 用户列表

$route['default_controller'] = 'home/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE; // 将路径中的“-”解析为“_”，兼顾SEO需要与类命名规范

/* End of file routes.php */
/* Location: ./application/config/routes.php */