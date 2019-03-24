<?php
	class Bootstrap{
		private $_params;
		private $_controllerObject;

		public function init(){
			$this->setParams();

			$controllerName = self::convertControllerName($this->_params["controller"]) . "Controller";
			$filePath 		= MODULE_PATH . $this->_params["mod"] . DS . "controllers" . DS . $controllerName . ".php";

			if(file_exists($filePath)){
				$this->loadExistsController($filePath, $controllerName);
				$this->callMethod();
			}else{
				URL::redirect("default", "index", "noitice", array("type" => "404"));
			}
		}

		public function _error(){
			require_once MODULE_PATH . "default" . DS . "controllers" . DS  . "ErrorController.php";
			$errorController = new ErrorController();
			$errorController->setView("default");
			$errorController->indexAction();
		}

		//set params
		public function setParams(){
			$this->_params = array_merge($_GET, $_POST);
			$this->_params["mod"] 			= isset($this->_params["mod"])? $this->_params['mod'] : MODULE_DEFAULT;
			$this->_params["controller"] 	= isset($this->_params["controller"])? $this->_params['controller'] : CONTROLLER_DEFAULT;
			$this->_params["action"] 		= isset($this->_params["action"])? $this->_params['action'] : ACTION_DEFAULT;
		}

		

		//Load exists controller
		private function loadExistsController($filePath, $controllerName){
			require_once $filePath;
			$this->_params["controller"];
			$this->_controllerObject = new $controllerName($this->_params);
		}

		//Load Method
		private function callMethod(){
			$actionName 	= $this->_params["action"] . "Action";
			if(method_exists($this->_controllerObject, $actionName)){

				$module 	= $this->_params["mod"];
				$controller	= $this->_params["controller"];
				$action 	= $this->_params["action"];

				$userInfo  	= Session::get("user");;
				$logged  	= ( ($userInfo["login"] == 1) && ($userInfo["time"] + TIME_LOGIN > time()) ) ? true:false;

				//MODULE ADMIN
				if($module == "admin"){
					if($logged == true){
						if($userInfo["group_acp"] == true){
							$this->_controllerObject->$actionName();
						}
						if($userInfo["group_acp"] == false){
							URL::redirect("default", "index", "noitice", array("type" => "non-permission"));
						}
					}else{
						Session::delete("user");
						$this->callLoginAction($module);
					}

				}

				//MODULE DEFAULT
				else if($module == "default"){
					if($controller == "user"){ 		//controller là user thì bắt người dùng phải đăng nhập
						if($logged == true){
							$this->_controllerObject->$actionName();
						}else{
							Session::delete("user");
							$this->callLoginAction($module);
						}
					}else{
						$this->_controllerObject->$actionName();
					}
				}
			}else{
				URL::redirect("default", "index", "noitice", array("type" => "404"));
			}
		}

		public function callLoginAction($module){
			require_once MODULE_PATH . $module . DS . "controllers" . DS . "IndexController.php";
			$IndexController = new IndexController($this->_params);
			$IndexController->loginAction();
		}

		public static function convertControllerName($controllerName){
			$controllerName = ucwords($controllerName, "-");
			$controllerName = str_replace("-", "", $controllerName);
			return $controllerName;
		}

	}
