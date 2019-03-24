<?php
	class SettingGeneralController extends Controller{
		public function __construct($arrParams){
			parent::__construct($arrParams);
			$this->_templateObj->setFolerTemplate("admin/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
		}

		public function indexAction(){
			//$this->_view->setTitle("User Manager: User Group");
			$this->_model->infoItem();
			$this->_view->_title = "Book :: List";
			$this->_view->render("setting-general/index");
		}

	}