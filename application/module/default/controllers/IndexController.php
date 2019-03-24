<?php
	class IndexController extends Controller{
		public function __construct($arrParams){
			parent::__construct($arrParams);
			$this->_templateObj->setFolerTemplate("default/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
		}

		public function noiticeAction(){
			$this->_view->render("index/noitice");
		}

		public function indexAction(){
			$totalItem 					= $this->_model->countItem($this->arrParams, null);
			$this->setPagination(array("totalItemPerPage" => 5, "pageRange" => 3));
			$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);
			
			$this->_view->specialBooks  = $this->_model->listItem($this->arrParams, array("task" => "list-special-book"));
			$this->_view->newBooks 		= $this->_model->listItem($this->arrParams, array("task" => "list-new-book"));

			$this->_view->render("index/index");
		}

		public function registerAction(){
			
			if(isset($this->arrParams["form"]["submit"])){
				URL::checkRefreshPage($this->arrParams["form"]["tooken"], "default", "user", "register");

				$arrParamsForm 	= isset($this->arrParams["form"])? $this->arrParams["form"] : "";
				$validate  		= new Validate($arrParamsForm);

				$queryUser 	= "SELECT `id` FROM " . TABLE_USER . " WHERE `username` = '" . $this->arrParams["form"]["username"] . "'";
				$queryEmail = "SELECT `id` FROM " . TABLE_USER . " WHERE `email` = '" . $this->arrParams["form"]["email"] . "'";

				$validate->addRule("username", "string-notExistRecord", array("database" => $this->_model, "query" => $queryUser, "min" => 3, "max" => 25))
						 ->addRule("password", "password", array("action" => "add"), true)
						 ->addRule("email", "email-notExistRecord", array("database" => $this->_model, "query" => $queryEmail));

				$validate->run();

				$this->arrParams["form"] = $validate->getResult();
				if($validate->isValid() == false){
					$this->_view->errors = $validate->showErrorsPublic();
				}else{
					$IDreturn = $this->_model->saveItem($this->arrParams, array("task" => "user-register"));
					URL::redirect("default", "index", "noitice", array("type" => "register-success"));
				}

			}
			$this->_view->render("index/register");
		}

		public function logoutAction(){
			Session::delete("user");
			URL::redirect("default", "index", "login", null, "index.html");
		}

		public function loginAction(){
			
			$userInfo  	= Session::get("user");
			$logged  	= ($userInfo["login"] == 1) && ($userInfo["time"] + TIME_LOGIN > time());
			if(($userInfo["login"] == 1) && ($userInfo["time"] + TIME_LOGIN > time())){
				URL::redirect("default", "user", "index", null, "my-account.html");
			}

			//
			if(isset($this->arrParams["form"]["token"])){

				$validate = new Validate($this->arrParams["form"]);

				$email 	  = $this->arrParams["form"]["email"];
				$password = md5($this->arrParams["form"]["password"]);

				$query 	  = "SELECT `id` FROM `user` WHERE (`email` = '$email') OR (`username` = '$email') AND `password` = '$password'";
				$validate->addRule("email" ,"existRecord", array("database" => $this->_model, "query" => $query));
				$validate->run();
				if($validate->isValid() == true){
					$infoUser = $this->_model->infoItem($this->arrParams);

					$arrSession = array(
											'login' 	=> true,
											'info' 		=> $infoUser,
											'time' 		=> time(),
											'group_acp' => $infoUser["group_acp"]
									);
					$_SESSION["user"] = $arrSession;
					URL::redirect("default", "user", "index", null, "my-account.html");
				}else{
					$this->_view->errors = $validate->showErrorsPublic();					
				}
			}

			$this->_view->render("index/login");
		}
	}