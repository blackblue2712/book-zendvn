<?php
	class BookModel extends Models{
		private $_columnNeedInsert = array('id', 'name', 'description', 'price', 'special', 'sale_off','picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');

		private $_userInfoSession;

		public function __construct(){
			parent::__construct();
			$this->setTable(TABLE_BOOK);

			$userObj  				= Session::get("user");
			$this->_userInfoSession = $userObj["info"];
		}


		//LIST ITEM
		public function getNameCategory($arrParams, $option = null){
			if($option["task"] == "get-name-category"){
				$query[] 		= "SELECT `id`, `name`";
				$query[] 		= "FROM `" . TABLE_CATEGORY . "`";
				$query[]		= "WHERE `id` = " . $arrParams["category_id"];
				$query[]		= "ORDER BY `ordering` ASC";

				$query 			= implode(" ", $query);
				return $this->fetchRow($query);
			}
		}

		public function infoItem($arrParams, $option = null){
			if($option == null){
				$query[] 	= "SELECT `id`, `name`, `picture`, `description`, `category_id`";
				$query[] 	= "FROM `" .$this->table. "`";
				$query[] 	= "WHERE `category_id` = " . $arrParams["category_id"];

				$query 		= implode(" ", $query);
				return $this->fetchAll($query);
			}

			if($option["task"] == "detail-book"){
				$query[] 	= "SELECT `id`, `name`, `picture`, `description`, `price`, `sale_off`, `category_id`";
				$query[] 	= "FROM `" .$this->table. "`";
				$query[] 	= "WHERE `id` = " . $arrParams["book_id"];
				$query 		= implode(" ", $query);
				return $this->fetchRow($query);
			}
		}

		//LIST ITEM
		public function listItem($arrParams, $option = null){
			if($option["task"] == 'related-book'){
				$bookID		= $arrParams['book_id'];
				$catID		= $arrParams['category_id'];
				
				$query[]	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`category_id`, `c`.`name` AS `category_name`";
				$query[]	= "FROM `".TABLE_BOOK."` AS `b`, `".TABLE_CATEGORY."` AS `c`";
				$query[]	= "WHERE `b`.`status`  = 1  AND `c`.`id` = `b`.`category_id` AND `b`.`id` <> '$bookID' AND `c`.`id`  = '$catID'";
				$query[]	= "ORDER BY `b`.`ordering` ASC";
			
				$query		= implode(" ", $query);
				$result		= $this->fetchAll($query);
				return $result;
			}
			
		}

	}