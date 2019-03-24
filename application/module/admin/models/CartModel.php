<?php
	class CartModel extends Models{

		private $_columnNeedInsert = array('id', 'username', 'books', 'prices', 'quantities', 'names', 'pictures', 'status', 'date');
		private $_userInfoSession;

		public function __construct(){
			parent::__construct();
			$this->setTable(TABLE_CART);

			$userObj  				= Session::get("user");
			$this->_userInfoSession = $userObj["info"];
		}

		//COUNT ITEM TO PAGINATION
		public function countItem($arrParams, $option = null){

			$query[] 		= "SELECT COUNT(`id`) AS `total`";
			$query[] 		= "FROM `" . $this->table . "`";
			$query[] 		= "WHERE `date` > 0";

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

		//LIST ITEM
		public function listItem($arrParams, $option = null){
			if($option == null){
				$query[] 		= "SELECT `id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`";
				$query[] 		= "FROM `" . $this->table . "`";
				$query[]		= "WHERE `date` > 0";

				//SEARCH
				if(isset($arrParams["filter_search"]) && !empty($arrParams["filter_search"])){
					$query[] 	= "AND `name` LIKE '%{$arrParams["filter_search"]}%'";
				}

				//SELECT STATUS SORT
				if(isset($arrParams["filter_state"]) && $arrParams["filter_state"] != 2){
					$query[] 	= "AND `status` ='" . $arrParams["filter_state"] . "'";
				}


				//SORT
				if(!empty($arrParams["filter_column"]) && !empty($arrParams["filter_column_dir"])){
					$column 	= $arrParams["filter_column"];
					$column_dir	= $arrParams["filter_column_dir"];
					$query[] 	= "ORDER BY `$column` $column_dir";
				}else{
					$query[] 	= "ORDER BY `date` ASC";
				}

				//PAGINATION
				$pagination 		= $arrParams["pagination"];
				$totalItemPerPage 	= $pagination["totalItemPerPage"];
				if($totalItemPerPage > 0){
					$position	= ($arrParams["pagination"]["currentPage"]-1)*$totalItemPerPage;
					$query[]	= "LIMIT $position, $totalItemPerPage";
				}

				$query 			= implode(" ", $query);
				$result = $this->fetchAll($query);

				return $result;
			}//end option null
			if($option["task"] == "get-category"){
				$query = "SELECT `id`, `name`, `picture` FROM `".$this->table."` WHERE `status` = 1";
				$result = $this->fetchAll($query);
				return $result;
			}
			
		}

		public function changeStatus($arrParams, $option = null){

			if($option["task"] == "change-ajax-status"){

				$status 		= ($arrParams["status"] == 0) ? 1 : 0;
				$id 			= $arrParams["id"];

				$query 			= "UPDATE `$this->table` SET `status` = '$status' WHERE `id` = '" . $id . "'";

				$this->query($query);
				$result = array(
								'id'		=> $id, 
								'status'	=> $status, 
								'link'		=> URL::createLink('admin', 'cart', 'ajaxStatus', array('id' => $id, 'status' => $status))
						); 
				
				return $result;
			}

			else if($option["task"] == "change-status"){
				$status 		= $arrParams["type"];
				if(!empty($arrParams["cid"])){
					
					$ids = $this->createWhereDeleteSQL($arrParams["cid"]);
					$query = "UPDATE `$this->table` SET `status` = '$status' WHERE `id` IN ($ids)";
					$this->query($query);
					$_SESSION["message"] = array("class" => "success", "content" => "Có " .$this->affectedRows(). " dòng được cập nhật thành công!");

					$cate = $this->listItem($arrParams, array("task" => "get-category"));
				}else{
					$_SESSION["message"] = array("class" => "error", "content" => "Vui lòng check vào ô muôn cập nhật status!");
					//Seesion::set("message", array("class" => "error", "content" => "Vui lòng check vào ô muôn cập nhật status!"));
				}
			}
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