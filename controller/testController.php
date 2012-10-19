<?php

/*
 * 测试控制器
 * @copyright	Copyright(nicedreamer@qq.com) 2012
 * @author		liuwei.yang<nicedreamer@qq.com>
 * @created		2012-10-13
 * @changed		2012-10-13
 * @version		1.0
 */

class testController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		echo 'testController';
		$data['test'] = 'Me';
		$this->showTemplate( 'test' , $data );
	}
	
	public function testModel()
	{
		$modelInstance = $this->model( 'test' );
		$modelInstance->testEcho();
	}
}
?>
