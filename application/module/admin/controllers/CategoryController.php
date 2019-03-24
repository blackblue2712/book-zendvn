<?php
	class CategoryController extends Controller{
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

			$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);
			$this->_view->_listItem 	= $this->_model->listItem($this->arrParams, null);


			$this->_view->_title = "Category Manager :: List";
			$this->_view->render("category/index");
		}

		//CHANGE STATUS BY AJAX
		public function ajaxStatusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-ajax-status"));
			echo json_encode($result);

		}

		//CHANGE STATUS BY BUTTON
		public function statusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-status"));
			URL::redirect("admin", "category", "index");
		}

		//DELETE MULTI ITEM
		public function trashAction(){
			$result = $this->_model->deleteItems($this->arrParams);
			URL::redirect("admin", "category", "index");
		}

		//CHANGE ORDERING
		public function orderingAction(){
			$this->_model->changeOrdering($this->arrParams["order"]);
			URL::redirect("admin", "category", "index");
		}

		//ADD & EDIT GROUP
		public function formAction(){
			$this->_view->_title = "Category Manager: Add";

			if(!empty($_FILES)){
				$this->arrParams["form"]["picture"] = $_FILES["picture"];
			}
			//Kiểm tra nếu có post id thì là action edit
			if(isset($this->arrParams["id"])){
				$this->_view->_title = "Category Manager: Edit";
				$dataInfoGroup 		 = $this->_model->infoItem($this->arrParams);
				//Ghi đè dữ liệu vào arrParams[form] để hiển thị các dữ liệu của category
				$this->arrParams["form"] 	 = $dataInfoGroup;
				if(empty($dataInfoGroup)){
					URL::redirect("admin", "category", "index");
				}
			}

			
			$arrParamsForm 	= isset($this->arrParams["form"])? $this->arrParams["form"] : array();

			$validate  		= new Validate($arrParamsForm);
			$arrParamsForm["token"] = isset($arrParamsForm["token"]) ? $arrParamsForm["token"] : "";
			if($arrParamsForm["token"] > 0){
				//validate dữ liệu
				$validate->addRule("name", "string", array("min" => 2, "max" => 100))
						 ->addRule("ordering", "int", array("min" => 1, "max" => 10))
						 ->addRule("status", "status", array("deny" => array(2, "default")))
						 ->addRule("picture", "file", array("min" => 100, "max" => "1000000000", "extension" => array("jpg", "png", "gif")),false);
				$validate->run();

				//gán lại các kết quả vào arrParams đã valid để hiển thị trên view
				$this->arrParams["form"] = $validate->getResult();
				if($validate->isValid() == false){
					$this->_view->errors = $validate->showErrors();
					$this->_view->errors = $validate->showErrors();
				}else{
					//Có id post là action edit
					if(isset($this->arrParams["form"]["id"])){
						$IDreturn = $this->_model->saveItem($this->arrParams, array("task" => "edit"));
					}else{ //Ngược lại không có post id là action add
						$IDreturn =$this->_model->saveItem($this->arrParams, array("task" => "add"));
					}
					$type = $this->arrParams["type"];
					if($type == "save-close"){
						URL::redirect("admin", "category", "index");
					}else if($type == "save-new"){
						URL::redirect("admin", "category", "form");
					}else if($type == "save"){
						URL::redirect("admin", "category", "form", array("id" => $IDreturn));
					}
				}
			}
			
			$this->_view->arrParams = $this->arrParams;
			// $this->_view->_title = "Form Group";
			$this->_view->render("category/form");
		}
	}