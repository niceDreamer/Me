<?php

/*
 * 系统配置文件
 * @copyright Copyright(nicedreamer@qq.com) 2012-10-13
 * @author liuwei.yang<nicedreamer@qq.com>
 * @created		2012-10-13
 * @changed		2012-10-13
 * @version 1.0
 */

/*
 * 数据库配置
 */
$CONFIG['system']['db'] = array(
	'db_host'			=>	'localhost',
	'db_user'			=>	'root',
	'db_password'		=>	'',
	'db_database'		=>	'app',
	'db_table_prefix'	=>	'app_',
	'db_charset'		=>	'utf8',
	'db_conn'			=>	'',
);

/*
 * 自定义类库配置
 */
$CONFIG['system']['lib'] = array(
	'prefix'			=>	'my',
);

/*
 * 自定义路由规则
 */
$CONFIG['system']['route'] = array(
	'default_controller'	=>	'home',
	'default_action'		=>	'index',
	'url_type'				=>	1,
);

 /*
  * 缓存配置
  */
$CONFIG['system']['cache'] = array(
	'cache_dir'				=>	'cache',
	'cache_prefix'			=>	'cache_',
	'cache_time'			=>	1800,
	'cache_mode'			=>	2,
)
?>
