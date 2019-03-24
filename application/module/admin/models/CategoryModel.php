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

		//COUNT ITEM TO PAGINATION
		public function countItem($arrParams, $option = null){

			$query[] 		= "SELECT COUNT(`id`) AS `total`";
			$query[] 		= "FROM `" . $this->table . "`";
			$query[] 		= "WHERE `id` > 0";

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
				$query[] 		= "SELECT `id`, `name`, `picture`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by` ";
				$query[] 		= "FROM `" . $this->table . "`";
				$query[]		= "WHERE `id` > 0";

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
					$query[] 	= "ORDER BY `id` DESC";
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
			}//end option null
			if($option["task"] == "get-category"){
				$query = "SELECT `id`, `name`, `picture` FROM `".$this->table."` WHERE `status` = 1";
				$result = $this->fetchAll($query);
				return $result;
			}
			
		}

		public function changeStatus($arrParams, $option = null){
			require_once LIBRARY_EXT_PATH . "XML.php";
			// $cate = $this->listItem($arrParams, array("task" => "get-category"));
			// XML::createXML($cate, "categories.xml");
			if($option["task"] == "change-ajax-status"){

				$status 		= ($arrParams["status"] == 0) ? 1 : 0;
				$id 			= $arrParams["id"];

				$modified 		= date("Y-m-d", time());
				$modified_by	= $this->_userInfoSession["username"];

				$query 			= "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` = '" . $id . "'";

				$this->query($query);
				$result = array(
								'id'		=> $id, 
								'status'	=> $status, 
								'link'		=> URL::createLink('admin', 'category', 'ajaxStatus', array('id' => $id, 'status' => $status))
						); 
				
				return $result;
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

					$cate = $this->listItem($arrParams, array("task" => "get-category"));
					XML::createXML($cate, "categories.xml");
				}else{
					$_SESSION["message"] = array("class" => "error", "content" => "Vui lòng check vào ô muôn cập nhật status!");
					//Seesion::set("message", array("class" => "error", "content" => "Vui lòng check vào ô muôn cập nhật status!"));
				}
			}
		}

		//DELETE MULTI ITEMS
		public function deleteItems($arrParams, $option = null){
			if($option == null){
				require_once LIBRARY_EXT_PATH . "XML.php";
				if(!empty($arrParams["cid"])){
					require_once LIBRARY_EXT_PATH . "Upload.php";
					$upload = new Upload();

					$ids = $this->createWhereDeleteSQL($arrParams["cid"]);

					//delete file
					$query 		= "SELECT `id`, `picture` AS `name` FROM `$this->table` WHERE `id` IN ($ids)";
					$arrImage 	= $this->fetchPairs($query);
					foreach ($arrImage as $key => $value) {
						$upload->removeFile("category", $value);
					}

					$query 			= "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
					$this->query($query);
					$_SESSION["message"] = array("class" => "success", "content" => "Có " .$this->affectedRows(). " dòng được xoá!");

					$cate = $this->listItem($arrParams, array("task" => "get-category"));
					XML::createXML($cate, "categories.xml");
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
			require_once LIBRARY_EXT_PATH . "XML.php";
			$upload = new Upload();
			if($option["task"] == "add"){
				//kiểm tra key của arrParams[form] với key của _columnNeedInsert để loại bỏ phần tử dư thừa
				//array_flip: đảo ngược key và value
				//return về id để khi save thì gắn link thêm id để edit ngay tại đó

				//UPLOAD
				$arrParams["form"]["picture"] = $upload->uploadFile($arrParams["form"]["picture"], "category");

				//
				$arrParams["form"]["created"] 		= date("Y-m-d", time());
				$arrParams["form"]["created_by"] 	= $this->_userInfoSession["username"];
				$columnInsertFinal = array_intersect_key($arrParams["form"], array_flip($this->_columnNeedInsert));
				$this->insert($columnInsertFinal);
				$_SESSION["message"] = array("class" => "success", "content" => "Đã thêm mới dữ liệu!");

				$cate = $this->listItem($arrParams, array("task" => "get-category"));
				XML::createXML($cate, "categories.xml");

				return $this->lastID();
			}else if($option["task"] == "edit"){

				//Giải quyết file upload

				if($arrParams["form"]["picture"]["name"] == null){
					unset($arrParams["form"]["picture"]);
				}else{
					$upload->removeFile("category", $arrParams["form"]["picture_hidden"]);
					$arrParams["form"]["picture"] = $upload->uploadFile($arrParams["form"]["picture"], "category");
				}

				//
				$arrParams["form"]["modified"] 		= date("Y-m-d", time());
				$arrParams["form"]["modified_by"]	= $this->_userInfoSession;["username"];
				$columnInsertFinal = array_intersect_key($arrParams["form"], array_flip($this->_columnNeedInsert));
				$this->update($columnInsertFinal, array(array("id", $arrParams["form"]["id"])));
				$_SESSION["message"] = array("class" => "success", "content" => "Đã cập nhật dữ liệu!");
				
				$cate = $this->listItem($arrParams, array("task" => "get-category"));
				XML::createXML($cate, "categories.xml");

				return $arrParams["form"]["id"];
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