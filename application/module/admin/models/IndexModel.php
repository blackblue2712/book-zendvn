<?php
	class IndexModel extends Models{
		public function __construct(){
			parent::__construct();			
		}
		public function infoItem($arrParams, $options = null){
			if($options == null){
				$username = $arrParams["form"]["username"];

				$query[] 	= "SELECT `u`.`id`, `u`.`username`, `u`.`fullname`, `u`.`email`, `g`.`group_acp`, `g`.`name`";
				$query[] 	= "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
				$query[] 	= "WHERE `u`.`username` = '$username'";

				$query 		= implode(" ", $query);
				$result  	= $this->fetchRow($query);
				return $result;
			}
		}

	}