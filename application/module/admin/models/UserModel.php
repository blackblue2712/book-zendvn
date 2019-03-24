<?php
	class UserModel extends Models{

		private $_columnNeedInsert = array('id', 'username', 'password', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id');
		private $_userInfoSession;
		public function __construct(){
			parent::__construct();
			$this->setTable(TABLE_USER);

			$userObj  				= Session::get("user");
			$this->_userInfoSession = $userObj["info"];
		}

		//COUNT ITEM TO PAGINATION
		public function countItem($arrParams, $option = null){

			$query[] 		= "SELECT COUNT(`id`) AS `total`";
			$query[] 		= "FROM `" . $this->table . "`";
			$query[] 		= "WHERE `id` > 0";

			//SEARCH
			if(isset($arrParams["filter_search"]) && !empty($arrParams["filter_search"])){
				$query[] 	= "AND (`username` LIKE '%{$arrParams["filter_search"]}%'  OR `email` LIKE '%{$arrParams["filter_search"]}%')";
			}

			//SELECT SORT
			if(isset($arrParams["filter_state"]) && $arrParams["filter_state"] != 2){
				$query[] 	= "AND `status` ='" . $arrParams["filter_state"] . "'";
			}
			//SELECT GROUP_ID SORT
			if(isset($arrParams["filter_group"]) && $arrParams["filter_group"] != "default"){
				$query[] 	= "AND `group_id` ='" . $arrParams["filter_group"] . "'";
			}

			
			//QUERY & RETURN RESULT
			$query 			= implode(" ", $query);
			$result 		= $this->fetchRow($query);
			return $result["total"];
		}

		//LIST ITEM
		public function listItem($arrParams, $option = null){

			$query[] 		= "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`fullname`, `u`.`status`, `u`.`ordering`, `u`.`created`,`u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.`name` AS group_name";
			$query[] 		= "FROM `" . $this->table . "` AS u LEFT JOIN `" . TABLE_GROUP . "` AS g ON u.`group_id` = g.`id`";
			$query[] 		= "WHERE u.`group_id` > -1";

			//SEARCH
			if(isset($arrParams["filter_search"]) && !empty($arrParams["filter_search"])){
				$query[] 	= "AND (`username` LIKE '%{$arrParams["filter_search"]}%' OR `email` LIKE '%{$arrParams["filter_search"]}%')";
			}

			//SELECT STATUS SORT
			if(isset($arrParams["filter_state"]) && $arrParams["filter_state"] != 2){
				$query[] 	= "AND `u`.`status` ='" . $arrParams["filter_state"] . "'";
			}
			//SELECT GROUP_ID SORT
			if(isset($arrParams["filter_group"]) && $arrParams["filter_group"] != "default"){
				$query[] 	= "AND `u`.`group_id` ='" . $arrParams["filter_group"] . "'";
			}

			//SORT
			if(!empty($arrParams["filter_column"]) && !empty($arrParams["filter_column_dir"])){
				
				$column 	= $arrParams["filter_column"];
				$column_dir	= $arrParams["filter_column_dir"];
				$query[] 	= "ORDER BY `$column` $column_dir";
			}else{
				$query[] 	= "ORDER BY `u`.`id` DESC";
			}

			//PAGINATION
			$pagination 		= $arrParams["pagination"];
			$totalItemPerPage 	= $pagination["totalItemPerPage"];
			if($totalItemPerPage > 0){
				$position	= ($arrParams["pagination"]["currentPage"]-1)*$totalItemPerPage;
				$query[]	= "LIMIT $position, $totalItemPerPage";
			}


			$query 			= implode(" ", $query);
			return $this->fetchAll($query);
		}

		public function changeStatus($arrParams, $option = null){
			if($option["task"] == "change-ajax-status"){
				$status 		= ($arrParams["status"] == 0) ? 1 : 0;
				$id 			= $arrParams["id"];
				$modified 		= date("Y-m-d", time());
				$modified_by	= $this->_userInfoSession["username"];
				$query 			= "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` = '" . $id . "'";
				$this->query($query);
				return array("id" => $id, "status" => $status, "link" => URL::createLink("admin", "user", "ajaxStatus", array("status" => $status, "id" => $id)));
			}

			else if($option["task"] == "change-status"){
				$status 		= $arrParams["type"];
				if(!empty($arrParams["cid"])){
					$modified 		= date("Y-m-d", time());
					$modified_by	= $this->_userInfoSession["username"];
					$ids = $this->createWhereDeleteSQL($arrParams["cid"]);
					$query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` IN ($ids)";
					$this->query($query);
					$_SESSION["message"] = array("class" => "success", "content" => "Có " .$this->affectedRows(). " dòng được cập nhật thành công!");
				}else{
					$_SESSION["message"] = array("class" => "error", "content" => "Vui lòng check vào ô muôn cập nhật status!");
					//Seesion::set("message", array("class" => "error", "content" => "Vui lòng check vào ô muôn cập nhật status!"));
				}
			}
		}

		//DELETE MULTI ITEMS
		public function deleteItems($arrParams, $option = null){
			if($option == null){
				if(!empty($arrParams["cid"])){
					$ids = $this->createWhereDeleteSQL($arrParams["cid"]);
					$query 			= "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
					$this->query($query);
					$_SESSION["message"] = array("class" => "success", "content" => "Có " .$this->affectedRows(). " dòng được xoá!");
				}else{
					$_SESSION["message"] = array("class" => "error", "content" => "Vui lòng check vào ô muôn xoá!");
				}
				
				
			}
		}

		//CHANGE ORDERING
		public function changeOrdering($arrParams, $option = null){
			if($option == null){
				if(!empty($arrParams)){
					$modified 		= date("Y-m-d", time());
					$modified_by	= $this->_userInfoSession["username"];
					foreach ($arrParams as $id => $ordering) {
						$query = "UPDATE `$this->table` SET `ordering` = '$ordering', `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` = '" . $id . "'";
						$this->query($query);
					}
					$_SESSION["message"] = array("class" => "success", "content" => "Đã cập nhật xong!");
				}
			}
		}

		/*=============================FORM=============================*/

		public function saveItem($arrParams, $option = null){
			if($option["task"] == "add"){
				//kiểm tra key của arrParams[form] với key của _columnNeedInsert để loại bỏ phần tử dư thừa
				//array_flip: đảo ngược key và value
				//return về id để khi save thì gắn link thêm id để edit ngay tại đó

				$arrParams["form"]["created"] 	= date("Y-m-d", time());
				$arrParams["form"]["created_by"]= $this->_userInfoSession["username"];
				$arrParams["form"]["password"] 	= md5($arrParams["form"]["password"]);
				$columnInsertFinal = array_intersect_key($arrParams["form"], array_flip($this->_columnNeedInsert));
				$this->insert($columnInsertFinal);
				$_SESSION["message"] = array("class" => "success", "content" => "Đã thêm mới dữ liệu!");
				return $this->lastID();
			}else if($option["task"] == "edit"){

				$arrParams["form"]["modified"] 		= date("Y-m-d", time());
				$arrParams["form"]["modified_by"]	= $this->_userInfoSession["username"];
				if($arrParams["form"]["password"] == ""){
					unset($arrParams["form"]["password"]);
				}else{
					$arrParams["form"]["password"] 	= md5($arrParams["form"]["password"]);
				}

				//không cho thay đổi user name
				unset($arrParams["form"]["username"]);

				$columnInsertFinal = array_intersect_key($arrParams["form"], array_flip($this->_columnNeedInsert));
				$this->update($columnInsertFinal, array(array("id", $arrParams["form"]["id"])));
				$_SESSION["message"] = array("class" => "success", "content" => "Đã cập nhật dữ liệu!");

				return $this->$arrParams["form"]["id"];
			}
		}

		public function infoItem($arrParams, $option = null){
			$id = $arrParams['id'];

			$query[] 	= "SELECT `id`, `username`, `email`, `group_id`, `fullname`, `status`, `ordering`";
			$query[] 	= "FROM `" . $this->table . "`";
			$query[] 	= "WHERE `id` = $id";
			$query 		= implode(" ", $query);
			return $this->fetchRow($query);
		}

		//SELEC BOX ITEM GROUP TO SEARCH
		public function itemInSlectbox($arrParms, $option = null){
			if($option == null){
				$query = "SELECT `id`, `name` FROM `" . TABLE_GROUP . "`";
				$result = $this->fetchPairs($query);
				$result["default"] = "- Select group -";
				ksort($result);
				return $result;
			}
		}
			
	}