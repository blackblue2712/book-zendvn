<?php
	class UserModel extends Models{
		private $_columnNeedInsert = array('id', 'username', 'password', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id', 'register_date', 'register_ip');
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
			$query[] 		= "FROM `" . TABLE_CART . "`";
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
			if($option["task"] == "books-in-cart"){
				$ids = "(";
				if(!empty($arrParams)){
					foreach ($arrParams["quantity"] as $key => $value) {
						$ids .= "'". $key . "',"; 
					}
					$ids .= "'0')"; 
					$query[] 		= "SELECT `id`, `name`, `picture`, `category_id`";
					$query[] 		= "FROM `" . TABLE_BOOK . "`";
					$query[]		= "WHERE `status` = 1" ;
					$query[]		= "AND `id` IN " . $ids;
					
					$query 			= implode(" ", $query);
					$result 		= $this->fetchAll($query);

					foreach($result as $key => $value) {
						$result[$key]["quantity"] 	= $arrParams["quantity"][$value["id"]];
						$result[$key]["totalPrice"] = $arrParams["price"][$value["id"]];
						$result[$key]["price"] 		= $arrParams["price"][$value["id"]] / $result[$key]["quantity"];
					}
					return $result;	
				}				
			}//if main

			if($option["task"] == "history-cart"){
				$username 	= $this->_userInfoSession["username"];
				$query 		= "SELECT `id`, `books`, `prices`, `names`, `pictures`, `quantities`, `date`, `status` FROM " .TABLE_CART." WHERE `username` = '".$username."' ORDER BY `date` DESC";

				//PAGINATION
				$pagination 		= $arrParams["pagination"];
				$totalItemPerPage 	= $pagination["totalItemPerPage"];
				if($totalItemPerPage > 0){
					$position	= ($arrParams["pagination"]["currentPage"]-1)*$totalItemPerPage;
					$query 		.= " LIMIT $position, $totalItemPerPage";
				}

				return $this->fetchAll($query);
			}

		}

		public function saveItem($arrParams, $option = null){
			if($option["task"] == "submit-cart"){
				
				$dataForm 			  = $arrParams["form"];

				$books 		  = json_encode($dataForm["bookID"]);
				$prices 	  = json_encode($dataForm["price"]);
				$quantities   = json_encode($dataForm["quantity"]);
				$pictures 	  = json_encode($dataForm["picture"]);
				$names 		  = json_encode($dataForm["name"]);
				$date 		  = date("Y-m-d H:i:s", time());
				$status 	  = 0;
				$id 		  = $this->randomString().time();
				$username 	  = $this->_userInfoSession["username"];


				$query = "INSERT INTO `".TABLE_CART."`(`id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`) VALUES('$id', '$username', '$books', '$prices', '$quantities', '$names', '$pictures', '$status', '$date')";
				$this->query($query);
				Session::delete("cart");
			}
		}


		private function randomString($length = 5){
			$arrCharacter 	= array_merge(range("A", "Z"), range('a', 'z'), range(0, 9));
			$str 			= implode("", $arrCharacter);
			$strRandom 		= str_shuffle($str);
			$result = substr($strRandom, 0, $length);
			return $result;
		}

		public function changePass($arrParams){
			$token = isset($arrParams["form"]["token"])? $arrParams["form"]["token"]:0;
			if($token == Session::get("token")){
				$idUser 	  = $this->_userInfoSession["id"];

				$query 			  = "SELECT `password` FROM `user` WHERE `id` = ".$idUser;
				$current_password = $this->fetchRow($query)["password"];

				if(md5($arrParams["form"]["current_password"]) == $current_password){
					$newpw 		= md5($arrParams["form"]["new_password"]);
					$query 		= "UPDATE `user` SET `password` = '".$newpw."' WHERE `id` = ".$idUser;
					$this->query($query);
					$_SESSION["message"] = "Done";
				}else{
					$_SESSION["message"] = "Current password is wrong";
				}
			}//end main if
		}


	}

