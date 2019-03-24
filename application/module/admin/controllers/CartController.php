<?php
	class CartController extends Controller{
		public function __construct($arrParams){
			parent::__construct($arrParams);
			$this->_templateObj->setFolerTemplate("admin/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
		}

		public function confirmCartAction(){
			$totalItem 					= $this->_model->countItem($this->arrParams, null);
			$this->setPagination(array("totalItemPerPage" => 5, "pageRange" => 2));

			$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);
			$this->_view->_listItem 	= $this->_model->listItem($this->arrParams, null);


			$this->_view->_title = "Cart Manager :: List";
			$this->_view->render("cart/confirmCart");
		}

		//CHANGE STATUS BY AJAX
		public function ajaxStatusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-ajax-status"));
			echo json_encode($result);

		}

		//CHANGE STATUS BY BUTTON
		public function statusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-status"));
			URL::redirect("admin", "cart", "confirmCart");
		}

	}