<?php
class IndexModel extends Models{
	private $_columnNeedInsert = array('id', 'username', 'password', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id', 'register_date', 'register_ip');

	public function __construct(){
		parent::__construct();
		$this->setTable(TABLE_USER);
	}

	//COUNT ITEM TO PAGINATION
	public function countItem($arrParams, $option = null){

		$query[] 		= "SELECT COUNT(`id`) AS `total`";
		$query[] 		= "FROM `" . TABLE_BOOK . "`";
		$query[] 		= "WHERE `special` = 1";

		//SEARCH
		if(isset($arrParams["filter_search"]) && !empty($arrParams["filter_search"])){
			$query[] 	= "AND `name` LIKE '%{$arrParams["filter_search"]}%'";
		}

		//SELECT SORT
		if(isset($arrParams["filter_state"]) && $arrParams["filter_state"] != 2){
			$query[] 	= "AND `status` ='" . $arrParams["filter_state"] . "'";
		}

		
		//QUERY & RETURN RESULT
		$query 			= implode(" ", $query);
		$result = $this->fetchRow($query);
		return $result["total"];
	}

	public function saveItem($arrParams, $option = null){
		if($option["task"] == "user-register"){
			//kiểm tra key của arrParams[form] với key của _columnNeedInsert để loại bỏ phần tử dư thừa
			//array_flip: đảo ngược key và value
			//return về id để khi save thì gắn link thêm id để edit ngay tại đó
			$arrParams["form"]["register_date"] 	= date("Y-m-d H:i:s", time());
			$arrParams["form"]["register_ip"] 		= $_SERVER["REMOTE_ADDR"];
			$arrParams["form"]["password"] 			= md5($arrParams["form"]["password"]);
			$arrParams["form"]["status"] 			= 0;
			$columnInsertFinal = array_intersect_key($arrParams["form"], array_flip($this->_columnNeedInsert));
			$this->insert($columnInsertFinal);
			$_SESSION["message"] = array("class" => "success", "content" => "Đã thêm mới dữ liệu!");
			return $this->lastID();
		}else if($otion["task"] == "user-edit"){
			echo "<pre>";
			print_r($this->arrParams);
			echo "</pre>";
		}
	}

	public function infoItem($arrParams, $options = null){
		if($options == null){
			$email 		= $arrParams["form"]["email"];

			$query[] 	= "SELECT `u`.`id`, `u`.`username`, `u`.`fullname`, `u`.`email`, `g`.`group_acp`, `g`.`name`";
			$query[] 	= "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
			$query[] 	= "WHERE `u`.`email` = '$email' OR `u`.`username` = '$email'";

			$query 		= implode(" ", $query);
			$result  	= $this->fetchRow($query);
			return $result;
		}
	}

	public function listItem($arrParams, $option = null){
		if($option["task"] == "list-special-book"){
			$query[]	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`category_id`, `c`.`name` AS `category_name`";
			$query[]	= "FROM `".TABLE_BOOK."` AS `b`, `".TABLE_CATEGORY."` AS `c`";
			$query[]	= "WHERE `b`.`status`  = 1 AND `b`.`special` = 1 AND `c`.`id` = `b`.`category_id`";
			$query[]	= "ORDER BY `b`.`ordering` ASC";

			//PAGINATION
			$pagination 		= $arrParams["pagination"];
			$totalItemPerPage 	= $pagination["totalItemPerPage"];
			if($totalItemPerPage > 0){
				$position	= ($arrParams["pagination"]["currentPage"]-1)*$totalItemPerPage;
				$query[]	= "LIMIT $position, $totalItemPerPage";
			}
	
			$query		= implode(" ", $query);
			$result		= $this->fetchAll($query);
			return $result;
		}

		if($option["task"] == "list-new-book"){
			$query[]	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`category_id`, `c`.`name` AS `category_name`";
			$query[]	= "FROM `".TABLE_BOOK."` AS `b`, `".TABLE_CATEGORY."` AS `c`";
			$query[]	= "WHERE `b`.`status`  = 1 AND `b`.`special` = 1 AND `c`.`id` = `b`.`category_id`";
			$query[]	= "ORDER BY `id` DESC";
			$query[]	= "LIMIT 0, 6";
		
			$query		= implode(" ", $query);
			$result		= $this->fetchAll($query);
			return $result;
		}
		
	}


}