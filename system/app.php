<?php

/*
 * 应用驱动类
 * @copyright Copyright(nicedreamer@qq.com) 2012-10-13
 * @author liuwei.yang<nicedreamer@qq.com>
 * @created		2012-10-13
 * @changed		2012-10-13
 * @version 1.0
 */

define( 'SYSTEM_PATH' , dirname( __FILE__ ) );
define( 'ROOT_PATH' , substr( SYSTEM_PATH , 0 , -7 ) );
define( 'SYSTEM_LIB_PATH' , SYSTEM_PATH . '/lib' );
define( 'APP_LIB_PATH' , ROOT_PATH . '/lib' );
define( 'SYSTEM_CORE_PATH' , SYSTEM_PATH . '/core' );
define( 'CONTORLLER_PATH' , ROOT_PATH . '/controller' );
define( 'MODEL_PATH' , ROOT_PATH . '/model' );
define( 'VIEW_PATH' , ROOT_PATH . '/view' );
define( 'LOG_PATH' , ROOT_PATH . '/error' );

final class Application
{
	public static $_lib = null;
	public static $_config = null;
	
	public static function init()
	{
		self::setAutoLibs();
		require SYSTEM_CORE_PATH . '/model.php';
		require SYSTEM_CORE_PATH . '/controller.php';
	}
	
	/*
	 * 创建应用
	 * @access		public
	 * @param		array		$config
	 */
	public static function run( $config )
	{
		self::$_config = $config['system'];
		self::init();
		self::autoload();
		self::$_lib['route']->setUrlType( self::$_config['route']['url_type'] );
		$url_array = self::$_lib['route']->getUrlArray();
		self::routeToCm( $url_array );
	}
	
	/*
	 * 自动加载的类库
	 * @access		public
	 */
	public static function setAutoLibs()
	{
		self::$_lib = array(
			'route'		=>	SYSTEM_LIB_PATH . '/lib_route.php',
			'mysql'		=>	SYSTEM_LIB_PATH . '/lib_mysql.php',
			'template'	=>	SYSTEM_LIB_PATH . '/lib_template.php',
			'cache'		=>	SYSTEM_LIB_PATH . '/lib_cache.php',
			'thumbnail'	=>	SYSTEM_LIB_PATH . '/lib_thumbnail.php',
		);
	}
	
	/*
	 * 自动加载类库
	 * @access		public
	 * @param		array		$_lib
	 */
	public static function autoload()
	{
		foreach ( self::$_lib as $key => $value )
		{
//			var_dump( $key . '--' . $value );
			require ( self::$_lib[$key] );
			$lib = ucfirst( $key );
			self::$_lib[$key] = new $lib;
		}
		
		if( is_object( self::$_lib['cache'] ) )
		{
			self::$_lib['cache']->init(
					ROOT_PATH . '/' . self::$_config['cache']['cache_dir'],
					self::$_config['cache']['cache_prefix'],
					self::$_config['cache']['cache_time'],
					self::$_config['cache']['cache_mode']
					);
		}
	}
	
	/*
	 * 加载类库
	 * @access		public
	 * @param		string		$class_name
	 * @return		object
	 */
	public static function newLib( $class_name )
	{
		$app_lib = $sys_lib = '';
		$app_lib = APP_LIB_PATH . '/' . self::$_config['lib']['prefix'] . '_' .
				$class_name . '.php';
		$sys_lib = SYSTEM_LIB_PATH . '/lib_' . $class_name . '.php';
		
		if(file_exists( $app_lib ) )
		{
			require ( $app_lib );
			$class_name = ucfirst( self::$_config['lib']['prefix'] ) .
					ucfirst( $class_name );
			return new $class_name;
		}
		else if( file_exists( $sys_lib ) )
		{
			require ( $sys_lib );
			return self::$_lib[$class_name] = new $class_name;
		}
		else
		{
			trigger_error( '加载' . $class_name . '类不存在' );
		}
	}
	
	/*
	 * 根据url分发到Controller和Model
	 * @access		public
	 * @param		array		$url_array
	 */
	public static function routeToCm( $url_array = array() )
	{
		$app = '';
		$controller = '';
		$action = '';
		$model = '';
		$params = '';
		
		if( isset( $url_array['app'] ) )
		{
			$app = $url_array['app'];
		}
		
		if( isset( $url_array['controller'] ) )
		{
			$controller = $model = $url_array['controller'];
			if( $app )
			{
				$controller_file = CONTORLLER_PATH . '/' .$app . '/' . 
						$controller . 'Controller.php';
				$model_file = MODEL_PATH . '/' . $app . '/' .
						$model . 'Model.php';
			}
			else
			{
				$controller_file = CONTORLLER_PATH . '/' .
						$controller . 'Controller.php';
				$model_file = MODEL_PATH . '/' . $model . 'Model.php';
			}
		}
		else
		{
			$controller = $model = self::$_config['route']['default_controller'];
			if( $app )
			{
				$controller_file = CONTORLLER_PATH . '/' . $app . '/' . self::
						$_config['route']['default_controller'] . 'Controller.php';
				$model_file = MODEL_PATH . '/' . $app . '/' . self::
						$_config['route']['default_controller'] . 'Model.php';
			}
			else
			{
				$controller_file = CONTORLLER_PATH . '/' . 
						self::$_config['route']['default_controller'] . 'Controller.php';
				$model_file = MODEL_PATH . '/' . 
						self::$_config['route']['default_controller'] . 'Model.php';
			}
		}
//		print_r($controller_file);
//		print_r($model_file);
		if( isset( $url_array['action'] ) )
		{
			$action = $url_array['action'];
		}
		else
		{
			$action = self::$_config['route']['default_action'];
		}
		
		if( isset( $url_array['params'] ) )
		{
			$params = $url_array['params'];
		}
		
		if( file_exists( $controller_file ) )
		{
			if( file_exists( $model_file ) )
			{
				require $model_file;
			}
			require $controller_file;
			$controller = $controller . 'Controller';
			$controller = new $controller;
			if( $action )
			{
				if( method_exists( $controller , $action ) )
				{
					isset( $params ) ? $controller->$action( $params ) : $controller->$action();
				}
				else
				{
					die('控制器方法不存在');
				}
			}
			else
			{
				die('控制器方法不存在');
			}
		}
		else
		{
			die('控制器不存在');
		}
	}
}
?>
