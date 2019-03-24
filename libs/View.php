<?php
	class View{
		private $moduleName;
		private $_templatePath;
		public $_title;
		public $_metaHTTP;
		public $_metaName;
		public $_cssFiles;
		public $_jsFiles;
		public $_dirImg;
		public $_fileView;

		public function __construct($moduleName){
			$this->moduleName = $moduleName;

		}
		public function render($fileInclude, $loadFull = true){
		
			$path =  MODULE_PATH . $this->moduleName . DS . "views" . DS . $fileInclude . ".php";

			if(file_exists($path)){
				if($loadFull){
					$this->_fileView = $fileInclude;
					require_once $this->_templatePath;
				}else{
					require_once $path;
				}
			}else{
				echo __METHOD__ .  "---error";
			}
			
		}

		//SET TEMPLATE TO LOAD
		public function setTemplatePath($path){
			$this->_templatePath = $path;
		}

		//SET TITLE
		public function setTitle($titleName){
			$this->_title = '<title>'.$titleName.'</title>';
		}
		//SET CSS
		public function appendCss($arrCss){
			if(!empty($arrCss)){
				foreach ($arrCss as $value) {
					$file = '<link rel="stylesheet" href="'.MODULE_PATH . "admin" . DS .  "views" . DS . $value.'">';
					$this->_cssFiles .= $file;
				}
			}
		}

		//SET JS
		public function appendJs($arrJs){
			if(!empty($arrJs)){
				foreach ($arrJs as $value) {
					$file = '<script src="'.MODULE_PATH . "admin" . DS .  "views" . DS . $value.'"></script>';
					$this->_jsFiles .= $file;
				}
			}
		}

		//CREATE TITLE
		public function createTitle($titleName){
			return '<title>'.$titleName.'</title>';
		}
		//CREATE META (HTTP-NAME)
		public function createMeta($arrMeta, $type = "name"){
			$xhtml= "";
			if(!empty($arrMeta)){
				foreach ($arrMeta as $value){
					$tmp = explode("|", $value);	
					$xhtml .= '<meta '.$type.'="'.$tmp[0].'" content="'.$tmp[1].'">';
				}
			}
			return $xhtml;
		}

		//CREATE LINK(CSS - JAVASCRIPT)
		public function createLink($dir, $file, $type = "css"){
			$xhtml= "";
			$path = TEMPLATE_URL . $dir;
			if(!empty($file)){
				foreach ($file as $value){
					if($type == "css"){
						$xhtml .= '<link rel="stylesheet" href="'.$path.DS.$value.'">';
					}else if($type == "js" || $type == "javascript"){
						$xhtml .= '<script src="'.$path.DS.$value.'"></script>';
					}	
				}
			}
			return $xhtml;
		}
	}
