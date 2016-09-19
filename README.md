# Basic
可能是开发最快、最简单的PHP开发框架，适用于任何水平的开发者，用于使用PHP、HTML、CSS、JavaScript等开发Web应用，基于著名的PHP开发框架[CodeIgniter](https://github.com/bcit-ci/CodeIgniter)最新稳定版。Basic在不修改CI核心代码的前提下，对CI进行了拓展和优化，让开发快一点，简单一点。

## 安装
1. 通过GitHub的clone下载到本地，或下载zip并解压；
2. 设置application/config/config.php、application/config/database.php中的必要参数；
3. 导入basic.sql到你的数据库，或至少导入basic.sql中ci_session表结构；
4. 将除了.git之外的其它文件夹和内容上传到服务器的根目录（例如/public_html等）。

## 核心文件
Basic的核心是以下4个文件：

### basic.sql
文章分类、文章、用户、管理员等常见数据库表的SQL创建语句，可通过SQL导入快速创建数据表。

### application/config/config.php
项目相关的主要技术参数、SEO信息、运营信息等都可以在这一个文件中完成配置；此外由于进行了简单有效的优化，以前需要上上下下配置半天的参数们，现在只需要在第一屏就可以基本完成必要参数的填写。

### application/libraries/Basic.php
为常用的控制器类提供父类，包括列表页、详情页等，快速完成新功能的部署。

### application/models/Basic_model.php
为常用的各种数据操作提供统一但不失灵活的父类，包括创建、删除（标记为删除，非物理性删除）、修改、查询等，最大限度挖掘面向对象编程应有的潜力。

## 全部文件
相比最新稳定版CodeIgniter，Basic新增或修改了以下文件：

* .htaccess 基本的伪静态和隐藏index.php
* application/config/autoload.php 载入Basic的类库、核心模型类，及其它常用类库
* application/config/config.php 基本参数配置
* application/config/database.php 数据库参数配置
* application/config/routes.php 常用路由配置
* application/controllers/Article.php 文章类
* application/controllers/Home.php 首页类
* application/controllers/Template.php 创建新类的模板
* application/libraries/Basic.php Basic的核心类库
* application/libraries/Curl.php Curl类库
* application/libraries/Luosimao.php luosimao.com短信类库
* application/libraries/Template.php 创建新类库的模板
* application/libraries/Upyun.php 又拍云类库
* application/models/Basic_model.php Basic的模型类
* application/views/home.php 首页
* application/views/template.php 常见新视图文件的模板
* application/views/article/index.php 文章列表页
* application/views/article/detail.php 文章详情页
* application/views/templates/header.php 通用页首
* application/views/templates/footer.php 通用页尾
* basic.sql 常见数据表的创建语句
* css/home.css 首页样式文件
* css/style.css 通用样式文件
* system/language/chinese 对English语言包的汉化

## 备注
时间关系，文档并非十分详尽，我会尽快完善；单元测试请根据实际需要添加。

## 开发计划
### 近期
* 1.1.X 登录、注册、密码修改、密码找回
* 2.X.X RESTful API

### 远期
* 3.X.X Android w/ Java
* 4.X.X iOS w/ Swift
* 5.X.X PHP和JAVA结合

## 版本规则
格式为“X.Y.Z”，X、Y、Z均为阿拉伯数字；X如有变化，Y、Z清零；Y如有变化，Z清零。

* X 巨大功能和/或视图调整、新增牛biu功能和/或视图
* Y 一般性功能调整、新增一般功能和/或视图
* Z 问题修复、视图调整