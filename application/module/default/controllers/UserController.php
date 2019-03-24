<?php
	class UserController extends Controller{
		public function __construct($arrParams){
			parent::__construct($arrParams);
			$this->_templateObj->setFolerTemplate("default/main/");
			$this->_templateObj->setFileTemplate("index.php");
			$this->_templateObj->setFileConfig("template.ini");
			$this->_templateObj->load();
		}

		public function indexAction(){
			$this->_view->_title = "<title>My Account</title>";
			$this->_view->render("user/index");
		}

		public function orderAction(){
			$cart = Session::get("cart");

			$book_id = $this->arrParams["book_id"];
			$price 	 = $this->arrParams["price"];
			if(empty($cart)){
				$cart["quantity"][$book_id] = $_POST["quantity"];
				$cart["price"][$book_id] 	= $price;
			}else{
				if(key_exists($book_id, $cart["quantity"])){
					$cart["quantity"][$book_id] += $_POST["quantity"];
					$cart["price"][$book_id] 	= $cart["quantity"][$book_id] * $price;
				}else{
					$cart["quantity"][$book_id] = $_POST["quantity"];
					$cart["price"][$book_id] 	= $price;
				}
			}

			$_SESSION["cart"] = $cart;

			URL::redirect("default", "book", "detail", array("book_id" => $book_id));
			
		}
		
		public function cartAction(){
			$this->_view->_title	 = "<title>My Cart</title>";
			$this->_view->Items 	 = $this->_model->listItem(Session::get("cart"), array("task" => "books-in-cart")); 
			$this->_view->render("user/cart");
		}

		public function buyAction(){
			$this->_model->saveItem($this->arrParams, array("task" => "submit-cart"));
			URL::redirect("default", "user", "history");
		}

		public function historyAction(){
			$totalItem 					= $this->_model->countItem($this->arrParams, null);
			$this->setPagination(array("totalItemPerPage" => 5, "pageRange" => 3));
			$this->_view->pagination 	= new Pagination($totalItem, $this->_pagination);

			$this->_view->Items = $this->_model->listItem($this->arrParams, array("task" => "history-cart"));
			$this->_view->_title	 = "<title>History</title>";
			$this->_view->render("user/history");
		}

		public function changepassAction(){
			$this->_model->changePass($this->arrParams);
			$this->_view->_title	 = "<title>Change password</title>";
			$this->_view->render("user/changepass");	
		}
	}
