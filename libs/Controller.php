<?php
	class Controller{
		protected $_view;			//VIEW OBJECT
		protected $_model;			//MODEL OBJECT
		protected $_templateObj;	//TEMPLATE OBJECT
		protected $arrParams;		//ARRAY PARAMS (GET-POST)
		protected $_pagination = array(
									'totalItemPerPage' => 5,
									'pageRange' 	   => 3	
								);		//PAGINATION

		public function __construct($arrParams){
			$this->setModel($arrParams["mod"], $arrParams["controller"]);
			$this->setView($arrParams["mod"]);
			$this->setTemplate($this);
			$this->setParams($arrParams);
			
			$this->_pagination["currentPage"] = (isset($arrParams['filter_page'])) ? $arrParams['filter_page'] : 1;
			$this->arrParams["pagination"] = $this->_pagination;

			//truyen arrParams ra view de xu li
			$this->_view->arrParams = $arrParams;
		}

		//SET MODEL
		public function setModel($moduleName, $modelName){
			$modelName = Bootstrap::convertControllerName($modelName);
			$modelName =  ucfirst($modelName) . "Model";
			$path = MODULE_PATH . $moduleName . DS . "models" . DS . $modelName . ".php";

			if(file_exists($path)){
				require_once $path;
				$this->_model = new $modelName();
			}
		}

		// GET MODEL
		public function getModel(){
			return $this->_model;
		}

		//SET VIEW
		public function setView($moduleName){
			$this->_view = new View($moduleName);
		}

		//GET VIEW
		public function getView(){
			return $this->_view;
		}

		//SET TEMPLATE
		public function setTemplate(){
			$this->_templateObj = new Template($this);	
		}
		//SET PARAMS (GET-POST)
		public function setParams($params){
			$this->arrParams = $params;
		}

		//SET PAGINATION
		public function setPagination($config){
			$this->_pagination["totalItemPerPage"] = $config["totalItemPerPage"];
			$this->_pagination["pageRange"] = $config["pageRange"];

			//thiết lập lại arrParams vì construct thực hiện trước hết nên nó chưa kịp thay đổi pagination khi set
			$this->arrParams["pagination"] = $this->_pagination;
			
		}
	}