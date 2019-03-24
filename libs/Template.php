<?php
	class Template{
		private $_fileConfig;			//File config (admin/main/template.ini)
		private $_fileTempalte;			//File template (admin/main/index.php)
		private $_folderTempalte;		//Folder template (admin/main)
		private $_controller;			//Controller Object

		public function __construct($controller){
			$this->_controller = $controller;	

		}



		//LOAD TEMPLATE
		public function load(){

			$fileConfig 		= $this->getFileConfig();
			$fileTemplate 		= $this->getFileTemplate();
			$folderTemplate 	= $this->getFolderTemplate();
			$view 				= $this->_controller->getView();
			$pathFileConfig 	= TEMPLATE_PATH . $folderTemplate . DS . $fileConfig;
			if(file_exists($pathFileConfig)){
				$arrConfig = parse_ini_file($pathFileConfig);

				$view->setTemplatePath(TEMPLATE_PATH . $folderTemplate . DS . $fileTemplate);
				$view->_title 	 = $view->createTitle($arrConfig["title"]);
				$view->_metaHTTP = $view->createMeta($arrConfig["metaHTTP"], "http-equiv");
				$view->_metaName = $view->createMeta($arrConfig["metaName"], "name");
				$view->_cssFiles = $view->createLink($this->_folderTempalte.$arrConfig["dirCss"], $arrConfig["fileCss"], "css");
				$view->_jsFiles  = $view->createLink($this->_folderTempalte.$arrConfig["dirJs"], $arrConfig["fileJs"], "js");
				$view->_dirImg 	 = TEMPLATE_URL . $folderTemplate . $arrConfig["dirImg"];
			}
		}

		//SET FILE CONFIG (template.ini)
		public function setFileConfig($value = "template.ini"){
			$this->_fileConfig = $value;
		}

		//GET FILE CONFIG
		public function getFileConfig(){
			return $this->_fileConfig;
		}

		//SET FILE TEMPLATE (index.php)
		public function setFileTemplate($value = "index.ini"){
			$this->_fileTempalte = $value;
		}
		//SET FILE TEMPLATE
		public function getFileTemplate(){
			return $this->_fileTempalte;
		}

		//SET FOLDER TEMPLATE (default/main/)
		public function setFolerTemplate($value = "default/main/"){
			$this->_folderTempalte = $value;
		}

		//GET FOLDER TEMPLATE
		public function getFolderTemplate(){
			return $this->_folderTempalte;
		}

		

	}
