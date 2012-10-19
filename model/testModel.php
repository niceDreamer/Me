<?php

/*
 * 测试模型
 * @copyright	Copyright(nicedreamer@qq.com) 2012
 * @author		liuwei.yang<nicedreamer@qq.com>
 * @created		2012-10-13
 * @changed		2012-10-13
 * @version		1.0
 */

class testModel extends Model
{
	function testDb()
	{
		$this->db->show_databases();
	}
	
	function testEcho()
	{
		echo 'Here is in testModel';
	}
}
?>
