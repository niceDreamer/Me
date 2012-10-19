<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<?php
/*
* 应用入口文件
* @copyright	Copyright(nicedreamer@qq.com) 2012
* @author		liuwei.yang<nicedreamer@qq.com>
* @created		2012-10-13
* @changed		2012-10-13
* @version		1.0
*/
	require dirname( __FILE__ ) . '/system/app.php';
	require dirname( __FILE__ ) . '/config/config.php';
	Application::run( $CONFIG );
?>
    </body>
</html>
