<?php
	class CategoryModel extends Models{

		private $_columnNeedInsert = array('id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering');
		private $_userInfoSession;

		public function __construct(){
			parent::__construct();
			$this->setTable(TABLE_CATEGORY);

			$userObj  				= Session::get("user");
			$this->_userInfoSession = $userObj["info"];
		}


		//LIST ITEM
		public function listItem($arrParams, $option = null){

			$query[] 		= "SELECT `id`, `name`, `picture`";
			$query[] 		= "FROM `" . $this->table . "`";
			$query[]		= "WHERE `status` = 1";
			$query[]		= "ORDER BY `ordering` ASC";

			
			$query 			= implode(" ", $query);
			return $this->fetchAll($query);
		}

		public function infoItem($arrParams, $option = null){
			$id = $arrParams['id'];

			$query[] 	= "SELECT `id`, `name`, `picture`, `status`, `ordering`";
			$query[] 	= "FROM `" . $this->table . "`";
			$query[] 	= "WHERE `id` = $id";
			$query 		= implode(" ", $query);
			return $this->fetchRow($query);
		}

	}