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

		//COUNT ITEM TO PAGINATION
		public function countItem($arrParams, $option = null){

			$query[] 		= "SELECT COUNT(`id`) AS `total`";
			$query[] 		= "FROM `" . $this->table . "`";
			$query[] 		= "WHERE `id` > 0";

			//SEARCH
			if(isset($arrParams["filter_search"]) && !empty($arrParams["filter_search"])){
				$query[] 	= "AND (`name` LIKE '%{$arrParams["filter_search"]}%')";
			}

			//SELECT SORT
			if(isset($arrParams["filter_state"]) && $arrParams["filter_state"] != 2){
				$query[] 	= "AND `status` ='" . $arrParams["filter_state"] . "'";
			}

			//SELECT SPECICAL
			if(isset($arrParams["filter_special"]) && $arrParams["filter_special"] != 2){
				$query[] 	= "AND `special` ='" . $arrParams["filter_special"] . "'";
			}
			//SELECT GROUP_ID SORT
			if(isset($arrParams["filter_category"]) && $arrParams["filter_category"] != "default"){
				$query[] 	= "AND `category_id` ='" . $arrParams["filter_category"] . "'";
			}
			//SORT
			if(!empty($arrParams["filter_column"]) && !empty($arrParams["filter_column_dir"])){
				
				$column 	= $arrParams["filter_column"];
				$column_dir	= $arrParams["filter_column_dir"];
				$query[] 	= "ORDER BY `$column` $column_dir";
			}else{
				$query[] 	= "ORDER BY `id` DESC";
			}


			
			//QUERY & RETURN RESULT
			$query 			= implode(" ", $query);
			$result 		= $this->fetchRow($query);
			return $result["total"];
		}

		//LIST ITEM
		public function listItem($arrParams, $option = null){

			$query[] 		= "SELECT `b`.`id`, `b`.`name`, `b`.`sale_off`, `b`.`picture`, `b`.`special`, `b`.`price`, `b`.`status`, `b`.`ordering`, `b`.`created`,`b`.`created_by`, `b`.`modified`, `b`.`modified_by`, `c`.`name` AS `category_name`";
			$query[] 		= "FROM `" . $this->table . "` AS b LEFT JOIN `" . TABLE_CATEGORY . "` AS c ON b.`category_id` = c.`id`";
			$query[] 		= "WHERE `b`.`category_id` > -1";

			//SEARCH
			if(isset($arrParams["filter_search"]) && !empty($arrParams["filter_search"])){
				$query[] 	= "AND (`b`.`name` LIKE '%{$arrParams["filter_search"]}%')";
			}

			//SELECT STATUS SORT
			if(isset($arrParams["filter_state"]) && $arrParams["filter_state"] != 2){
				$query[] 	= "AND `b`.`status` ='" . $arrParams["filter_state"] . "'";
			}
			//SELECT SPECICAL
			if(isset($arrParams["filter_special"]) && $arrParams["filter_special"] != 2){
				$query[] 	= "AND `special` ='" . $arrParams["filter_special"] . "'";
			}
			//SELECT GROUP_ID SORT
			if(isset($arrParams["filter_category"]) && $arrParams["filter_category"] != "default"){
				$query[] 	= "AND `b`.`category_id` ='" . $arrParams["filter_category"] . "'";
			}

			//SORT
			if(!empty($arrParams["filter_column"]) && !empty($arrParams["filter_column_dir"])){
				
				$column 	= $arrParams["filter_column"];
				$column_dir	= $arrParams["filter_column_dir"];
				$query[] 	= "ORDER BY `$column` $column_dir";
			}else{
				$query[] 	= "ORDER BY `b`.`id` DESC";
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
				return array("id" => $id, "status" => $status, "link" => URL::createLink("admin", "book", "ajaxStatus", array("status" => $status, "id" => $id)));
			}

			else if($option["task"] == "change-ajax-special"){
				$special 		= ($arrParams["special"] == 0) ? 1 : 0;
				$id 			= $arrParams["id"];
				$modified 		= date("Y-m-d", time());
				$modified_by	= $this->_userInfoSession["username"];
				$query 			= "UPDATE `$this->table` SET `special` = '$special', `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` = '" . $id . "'";
				$this->query($query);
				return array("id" => $id, "special" => $special, "link" => URL::createLink("admin", "book", "ajaxSpecial", array("special" => $special, "id" => $id)));
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
			require_once LIBRARY_EXT_PATH . "Upload.php";
			$upload = new Upload();
			if($option["task"] == "add"){
				//kiểm tra key của arrParams[form] với key của _columnNeedInsert để loại bỏ phần tử dư thừa
				//array_flip: đảo ngược key và value
				//return về id để khi save thì gắn link thêm id để edit ngay tại đó
				
				//UPLOAD
				$arrParams["form"]["picture"] = $upload->uploadFile($arrParams["form"]["picture"], "book", WIDTH_RESIZE_98, HEIGHT_RESIZE_150);

				$arrParams["form"]["created"] 		= date("Y-m-d", time());
				$arrParams["form"]["created_by"]	= $this->_userInfoSession["username"];
				$arrParams["form"]["password"] 		= md5($arrParams["form"]["password"]);
				$arrParams["form"]["description"] 	= mysqli_real_escape_string($this->connect, $arrParams["form"]["description"]);
				$arrParams["form"]["name"]	 		= mysqli_real_escape_string($this->connect, $arrParams["form"]["name"]);
				$columnInsertFinal = array_intersect_key($arrParams["form"], array_flip($this->_columnNeedInsert));
				$this->insert($columnInsertFinal);
				$_SESSION["message"] = array("class" => "success", "content" => "Đã thêm mới dữ liệu!");
				return $this->lastID();
			}else if($option["task"] == "edit"){

				//Giải quyết file upload

				if($arrParams["form"]["picture"]["name"] == null){
					unset($arrParams["form"]["picture"]);
				}else{
					$upload->removeFile("book", $arrParams["form"]["picture_hidden"], WIDTH_RESIZE_98, HEIGHT_RESIZE_150);
					$arrParams["form"]["picture"] = $upload->uploadFile($arrParams["form"]["picture"], "book", WIDTH_RESIZE_98, HEIGHT_RESIZE_150);
				}
				
				$arrParams["form"]["modified"] 		= date("Y-m-d", time());
				$arrParams["form"]["modified_by"]	= $this->_userInfoSession["username"];
				$arrParams["form"]["description"] 	= mysqli_real_escape_string($this->connect, $arrParams["form"]["description"]);
				$arrParams["form"]["name"]	 		= mysqli_real_escape_string($this->connect, $arrParams["form"]["name"]);


				$columnInsertFinal = array_intersect_key($arrParams["form"], array_flip($this->_columnNeedInsert));
				$this->update($columnInsertFinal, array(array("id", $arrParams["form"]["id"])));
				$_SESSION["message"] = array("class" => "success", "content" => "Đã cập nhật dữ liệu!");

				return $arrParams["form"]["id"];
			}
		}

		public function infoItem($arrParams, $option = null){
			$id = $arrParams['id'];

			$query[] 	= "SELECT `id`, `name`, `description`,`special`, `price`, `sale_off`, `category_id`, `picture`, `status`, `ordering`";
			$query[] 	= "FROM `" . $this->table . "`";
			$query[] 	= "WHERE `id` = $id";
			$query 		= implode(" ", $query);
			return $this->fetchRow($query);
		}

		//SELEC BOX ITEM CATEGORY TO SEARCH
		public function itemInSlectbox($arrParms, $option = null){
			if($option == null){
				$query = "SELECT `id`, `name` FROM `" . TABLE_CATEGORY . "`";
				$result = $this->fetchPairs($query);
				$result["default"] = "- Select category -";
				ksort($result);
				return $result;
			}
		}	

	}