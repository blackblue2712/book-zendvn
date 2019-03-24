<?php
	class BookController extends Controller{
		public function __construct($arrParams){
			parent::__construct($arrParams);
			$this->_templateObj->setFolerTemplate("default/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
		}

		public function listAction(){
			//$this->_view->setTitle("User Manager: User Group");
			
			//$totalItem 					= $this->_model->countItem($this->arrParams, null);
			//$this->setPagination(array("totalItemPerPage" => 5, "pageRange" => 2));
			//$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);
			
			
			$this->_view->nameCategory 	= $this->_model->getNameCategory($this->arrParams, array("task" => "get-name-category"));
			$this->_view->_listBook		= $this->_model->infoItem($this->arrParams, null);


			$this->_view->_title = "<title>List</title>";
			$this->_view->render("book/list");
		}

		public function detailAction(){
			$this->_view->detailBook 	= $this->_model->infoItem($this->arrParams, array("task" => "detail-book"));
			//$this->_view->relatedBook	= $this->_model->listItem($this->arrParams, array("task" => "related-book"));


			$this->_view->_title = "<title>List</title>";
			$this->_view->render("book/detail");
		}

		public function relateAction(){
			$this->_view->relatedBook	= $this->_model->listItem($this->arrParams, array("task" => "related-book"));
			$this->_view->render("book/relate", false);		}

	}