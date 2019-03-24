<?php
	class UserController extends Controller{
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

			$this->_view->_slbGroup		=  $this->_model->itemInSlectbox($this->arrParams);

			$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);
			$this->_view->_listItem 	= $this->_model->listItem($this->arrParams, null);


			$this->_view->_title = "User :: List";
			$this->_view->render("user/index");
		}

		//CHANGE STATUS BY AJAX
		public function ajaxStatusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-ajax-status"));
			echo json_encode($result);

		}

		//CHANGE STATUS BY BUTTON
		public function statusAction(){
			$result = $this->_model->changeStatus($this->arrParams, array("task" => "change-status"));
			URL::redirect("admin", "user", "index");
		}

		//DELETE MULTI ITEM
		public function trashAction(){
			$result = $this->_model->deleteItems($this->arrParams);
			URL::redirect("admin", "user", "index");
		}

		//CHANGE ORDERING
		public function orderingAction(){
			$this->_model->changeOrdering($this->arrParams["order"]);
			URL::redirect("admin", "user", "index");
		}

		//ADD & EDIT GROUP
		public function formAction(){
			$this->_view->_title 		= "User:: Add User";
			$this->_view->_slbGroup		=  $this->_model->itemInSlectbox($this->arrParams);

			//Kiểm tra nếu có post id thì là action edit
			if(isset($this->arrParams["id"])){
				$this->_view->_title = "User:: Edit User";
				$dataInfoGroup 		 = $this->_model->infoItem($this->arrParams);
				//Ghi đè dữ liệu vào arrParams[form] để hiển thị các dữ liệu của group
				$this->arrParams["form"] 	 = $dataInfoGroup;
				if(empty($dataInfoGroup)){
					URL::redirect("admin", "user", "index");
				}
			}


			
			$arrParamsForm 	= isset($this->arrParams["form"])? $this->arrParams["form"] : array();
			$validate  		= new Validate($arrParamsForm);
			$arrParamsForm["token"] = isset($arrParamsForm["token"]) ? $arrParamsForm["token"] : "";
			if($arrParamsForm["token"] > 0){
				//validate dữ liệu
				
				$queryUser 	= "SELECT `id` FROM " . TABLE_USER . " WHERE `username` = '" . $this->arrParams["form"]["username"] . "'";
				$queryEmail = "SELECT `id` FROM " . TABLE_USER . " WHERE `email` = '" . $this->arrParams["form"]["email"] . "'";

				//Edit sẽ isset id, ta thêm điều kiện khi validate
				$require = true; 			 // require == true thi validate se kiem tra rong
				$task = "add";
				if(isset($this->arrParams["form"]["id"])){
					$task = "edit";
					$queryUser 	.= " AND `id` <> '" . $this->arrParams["form"]["id"] . "'";
					$queryEmail .= " AND `id` <> '" . $this->arrParams["form"]["id"] . "'";
					$require = false;
				}

				$validate->addRule("username", "string-notExistRecord", array("database" => $this->_model, "query" => $queryUser, "min" => 3, "max" => 25))
						 ->addRule("ordering", "int", array("min" => 1, "max" => 10))
						 ->addRule("password", "password", array("action" => $task), $require)
						 ->addRule("email", "email-notExistRecord", array("database" => $this->_model, "query" => $queryEmail))
						 ->addRule("status", "status", array("deny" => array(2, "default")))
						 ->addRule("group_id", "status", array("deny" => array("default")));
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
						URL::redirect("admin", "user", "index");
					}else if($type == "save-new"){
						URL::redirect("admin", "user", "form");
					}else if($type == "save"){
						URL::redirect("admin", "user", "form", array("id" => $IDreturn));
					}
				}
			}
			
			$this->_view->arrParams = $this->arrParams;
			// $this->_view->_title = "Form Group";
			$this->_view->render("user/form");
		}
	}