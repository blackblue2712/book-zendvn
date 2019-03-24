<?php
	class CategoryController extends Controller{
		public function __construct($arrParams){
			parent::__construct($arrParams);
			$this->_templateObj->setFolerTemplate("default/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
		}

		public function indexAction(){
			//$this->_view->setTitle("User Manager: User Group");
			
			//$totalItem 					= $this->_model->countItem($this->arrParams, null);
			//$this->setPagination(array("totalItemPerPage" => 5, "pageRange" => 2));
			//$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);
			require_once LIBRARY_EXT_PATH . "XML.php";
			$this->_view->_listItem 	= XML::getContentXML("categories.xml");


			$this->_view->_title = "<title>Category</title>";
			$this->_view->render("category/index");
		}

	}