<?php
	
	/*===============================PATH===============================*/

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT_PATH'			, dirname(__FILE__)); 						//C:\xampp\htdocs\mvc - Đường dẫn đến thư mục gốc
	define('LIBRARY_PATH'		, ROOT_PATH . DS . 'libs' . DS); 			//\C:\xampp\htdocs\mvc\libs\ - Đường dẫn đến thư mục libs
	define('LIBRARY_EXT_PATH'	, LIBRARY_PATH . DS . 'extends' . DS);
	define('APPLICATION_PATH'	, ROOT_PATH . DS . 'application' . DS);
	define('BLOCK_PATH'			, APPLICATION_PATH . DS . 'block' . DS);
	define('MODULE_PATH'		, APPLICATION_PATH . 'module' . DS);
	define('PUBLIC_PATH'		, ROOT_PATH . DS . "public" . DS);	
	define('TEMPLATE_PATH'		, PUBLIC_PATH . 'template' . DS);
	define('UPLOAD_PATH'		, PUBLIC_PATH . 'files' . DS);
	define('SCRIPTS_PATH'		, PUBLIC_PATH . 'scripts' . DS);



	define('ROOT_URL'			, "\bookstore" . DS);									// Đường dẫn tương đối tới thư mục gốc
	define('PUBLIC_URL'			, ROOT_URL . "public" . DS);		// Đường dẫn tương đối tới thư mục gốc
	define('TEMPLATE_URL'		, PUBLIC_URL . "template" . DS);
	define('APPLICATION_URL'	, ROOT_URL . "application" . DS);
	define('MODULE_URL'			, APPLICATION_URL . "module" . DS);
	define('UPLOAD_URL'		, PUBLIC_URL . "files" . DS);

	define('MODULE_DEFAULT'		, "default");	
	define('CONTROLLER_DEFAULT'	, "index");
	define('ACTION_DEFAULT'		, "index");

	/*===============================DATABASE===============================*/

	define('DB_HOST'		, 'localhost');
	define('DB_USER'		, 'root');
	define('DB_PASS'		, '');
	define('DB_NAME'		, 'bookstore');
	define('DB_TABLE'		, 'group');

	/*===============================DATABASE TABLE===============================*/

	define('TABLE_GROUP'	, 'group');
	define('TABLE_USER'		, 'user');
	define('TABLE_CATEGORY'	, 'category');
	define('TABLE_BOOK'		, 'book');
	define('TABLE_CART'		, 'cart');

	/*===============================CONFIGS===============================*/

	define('TIME_LOGIN'	, 3600);

	define('HEIGHT_RESIZE'	, 90);	
	define('WIDTH_RESIZE'	, 60);
	define('FRE_FIX_DF'		, WIDTH_RESIZE . "x" . HEIGHT_RESIZE . "-");

	define('HEIGHT_RESIZE_150'	, 150);	
	define('WIDTH_RESIZE_98'	, 98);
	define('FRE_FIX_98x150'		, WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-");

