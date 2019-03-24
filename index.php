<?php
	error_reporting( error_reporting() & ~E_NOTICE);
	require_once "define.php";
	function __autoload($className){
		$fileName = LIBRARY_PATH . "{$className}.php";
		if(file_exists($fileName)) require_once $fileName;
    }

    Session::init();
	$bootstrap = new Bootstrap();
	$bootstrap->init();


	