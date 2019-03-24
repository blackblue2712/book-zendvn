<?php
	class BookController extends Controller{
		public function __construct($arrParams){
			parent::__construct($arrParams);
			$this->_templateObj->setFolerTemplate("admin/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
		}

		public function indexAction(){
			//$this->_view->setTitle("User Manager: User Group");
			
			$totalItem 					= $this->_model->countItem($this->arrParams, null);
			$this->setPagination(array("totalItemPerPage" => 5, "pageRange" => 2));

			$this->_view->_slbCategory	= $this->_model->itemInSlectbox($this->arrParams);

			$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);
			$this->_view->_listItem 	= $this->_model->listItem($this->arrParams, null);


			$this->_view->_title = "Book :: List";
			$this->_view->render("book/index");
		}

		//CHANGE STATUS BY AJAX
		public function ajaxStatusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-ajax-status"));
			echo json_encode($result);

		}
		public function ajaxSpecialAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-ajax-special"));
			echo json_encode($result);

		}

		//CHANGE STATUS BY BUTTON
		public function statusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-status"));
			URL::redirect("admin", "book", "index");
		}

		//DELETE MULTI ITEM
		public function trashAction(){
			$result = $this->_model->deleteItems($this->arrParams);
			URL::redirect("admin", "book", "index");
		}

		//CHANGE ORDERING
		public function orderingAction(){
			$this->_model->changeOrdering($this->arrParams["order"]);
			URL::redirect("admin", "book", "index");
		}

		//ADD & EDIT GROUP
		public function formAction(){
			$this->_view->_title 		= "Book:: Add";
			$this->_view->_slbCategory	=  $this->_model->itemInSlectbox($this->arrParams);

			//add image
			if(!empty($_FILES)){
				$this->arrParams["form"]["picture"] = $_FILES["picture"];
			}

			//Kiểm tra nếu có post id thì là action edit
			if(isset($this->arrParams["id"])){
				$this->_view->_title = "Book :: Edit";
				$dataInfoBook 		 = $this->_model->infoItem($this->arrParams);
				//Ghi đè dữ liệu vào arrParams[form] để hiển thị các dữ liệu của book
				$this->arrParams["form"] 	 = $dataInfoBook;
				if(empty($dataInfoBook)){
					URL::redirect("admin", "book", "index");
				}
			}


			
			$arrParamsForm 	= isset($this->arrParams["form"])? $this->arrParams["form"] : array();
			$validate  		= new Validate($arrParamsForm);
			$arrParamsForm["token"] = isset($arrParamsForm["token"]) ? $arrParamsForm["token"] : "";
			if($arrParamsForm["token"] > 0){
				//validate dữ liệu

				//Edit sẽ isset id, ta thêm điều kiện khi validate
				$require = true; 			 // require == true thi validate se kiem tra rong
				$task = "add";
				if(isset($this->arrParams["form"]["id"])){
					$task = "edit";
					$require = false;
				}
				
				$validate->addRule("name", "string", array("min" => 1, "max" => 225))
						 ->addRule("description", "string", array("min" => 1, "max" => 2000))
						 ->addRule("picture", "file", array("min" => 100, "max" => "1000000000", "extension" => array("jpg", "png", "gif")),false)
						 ->addRule("ordering", "int", array("min" => 1, "max" => 10))
						 ->addRule("price", "int", array("min" => 1000, "max" => 1000000))
						 ->addRule("sale_off", "intI0", array("min" => 0, "max" => 100))
						 ->addRule("status", "status", array("deny" => array(2, "default")))
						 ->addRule("special", "status", array("deny" => array(2, "default")))
						 ->addRule("category_id", "status", array("deny" => array("default")));
				$validate->run();

				//gán lại các kết quả vào arrParams đã valid để hiển thị trên view
				$this->arrParams["form"] = $validate->getResult();
				if($validate->isValid() == false){
					$this->_view->errors = $validate->showErrors();
					$this->_view->errors = $validate->showErrors();
				}else{

					$IDreturn = $this->_model->saveItem($this->arrParams, array("task" => $task));

					$type = $this->arrParams["type"];
					if($type == "save-close"){
						URL::redirect("admin", "book", "index");
					}else if($type == "save-new"){
						URL::redirect("admin", "book", "form");
					}else if($type == "save"){
						URL::redirect("admin", "book", "form", array("id" => $IDreturn));
					}
				}
			}
			
			$this->_view->arrParams = $this->arrParams;
			// $this->_view->_title = "Form Group";
			$this->_view->render("book/form");
		}
	}