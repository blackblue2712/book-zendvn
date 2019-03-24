<?php
	class Auth{
		public static function checkLogin(){
			if(Session::get("logged")==false){
				header("location: index.php?controllers=user&action=login");
				exit();
			}
		}
	}