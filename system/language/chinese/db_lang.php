<?php
	defined('BASEPATH') OR exit('不可直接访问此文件');

	$lang['db_invalid_connection_str'] = '无法根据给定的连接字符串确定数据库设置';
	$lang['db_unable_to_connect'] = '无法使用给定的参数连接数据库服务器';
	$lang['db_unable_to_select'] = '无法选择指定的数据库%s';
	$lang['db_unable_to_create'] = '无法创建指定的数据库%s';
	$lang['db_invalid_query'] = '请输入有效的查询语句';
	$lang['db_must_set_table'] = '请指定需要操作的表';
	$lang['db_must_use_set'] = '必须使用"set"方法来更新数据';
	$lang['db_must_use_index'] = 'You must specify an index to match on for batch updates.';
	$lang['db_batch_missing_index'] = 'One or more rows submitted for batch updating is missing the specified index.';
	$lang['db_must_use_where'] = '缺少执行update语句所需的"WHERE"语句';
	$lang['db_del_must_use_where'] = '缺少执行delete语句所需的"WHERE"或"LIKE"语句';
	$lang['db_field_param_missing'] = 'To fetch fields requires the name of the table as a parameter.';
	$lang['db_unsupported_function'] = 'This feature is not available for the database you are using.';
	$lang['db_transaction_failure'] = 'Transaction failure: Rollback performed.';
	$lang['db_unable_to_drop'] = '无法删除指定的数据库';
	$lang['db_unsuported_feature'] = 'Unsupported feature of the database platform you are using.';
	$lang['db_unsuported_compression'] = 'The file compression format you chose is not supported by your server.';
	$lang['db_filepath_error'] = 'Unable to write data to the file path you have submitted.';
	$lang['db_invalid_cache_path'] = 'The cache path you submitted is not valid or writable.';
	$lang['db_table_name_required'] = 'A table name is required for that operation.';
	$lang['db_column_name_required'] = 'A column name is required for that operation.';
	$lang['db_column_definition_required'] = 'A column definition is required for that operation.';
	$lang['db_unable_to_set_charset'] = 'Unable to set client connection character set: %s';
	$lang['db_error_heading'] = '数据库出错';