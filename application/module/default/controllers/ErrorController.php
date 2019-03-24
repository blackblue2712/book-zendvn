<?php
	class ErrorController extends Controller{
		public function __construct(){
			
		}

		public function IndexAction(){
			$this->_view->data = "Errors are fucking up now!";
			$this->_view->render("error/index");
		}

	}