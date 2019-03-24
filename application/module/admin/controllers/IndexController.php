<?php
	class IndexController extends Controller{
		public function __construct($arrParams){
				parent::__construct($arrParams);
				
		}
		public function indexAction(){
			$this->_templateObj->setFolerTemplate("admin/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();

			$this->_view->_title = "Book Manager";
			$this->_view->render("index/index");
		}

		public function loginAction(){
			//Kiểm tra xem đã đăng nhập chưa
			$userInfo  	= Session::get("user");
			$logged  	= ($userInfo["login"] == 1) && ($userInfo["time"] + TIME_LOGIN > time());
			if(($userInfo["login"] == 1) && ($userInfo["time"] + TIME_LOGIN > time())){
				URL::redirect("admin", "index", "index");
			}

			//
			if(isset($this->arrParams["form"]["token"])){
				$validate = new Validate($this->arrParams["form"]);

				$username = $this->arrParams["form"]["username"];
				$password = md5($this->arrParams["form"]["password"]);

				$query 	  = "SELECT `id` FROM `user` WHERE `username` = '$username' AND `password` = '$password'";
				$validate->addRule("username" ,"existRecord", array("database" => $this->_model, "query" => $query));
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
					URL::redirect("admin", "index", "index");
				}else{
					$this->_view->errors = $validate->showErrors();					
				}



			}

			$this->_templateObj->setFolerTemplate("admin/main/");
			$this->_templateObj->setFileTemplate("login.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();

			$this->_view->_title = "Index";
			$this->_view->render("index/login");
		}

		public function logoutAction(){
			Session::delete("user");
			URL::redirect("admin", "index", "login");
		}

		public function profileAction(){
			$this->_templateObj->setFolerTemplate("admin/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
			$this->_view->_title = "Profile";

			//ghi de du lieu de edit
			$userObj = Session::get("user");

			$this->_view->arrParams["form"] = $userObj["info"];

			$this->_view->render("index/profile");


		}

	}
