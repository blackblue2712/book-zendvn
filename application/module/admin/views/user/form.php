<?php
        include_once (MODULE_PATH .  "admin/views/toolbar.php");
        include_once "submenu/index.php";



        //INPUT
        $dataForm           = isset($this->arrParams["form"]) ? $this->arrParams["form"] : "";
        $issetUserName      = isset($dataForm["username"]) ? $dataForm["username"] : "";
        $issetEmail         = isset($dataForm["email"]) ? $dataForm["email"] : "";
        $issetFullname      = isset($dataForm["fullname"]) ? $dataForm["fullname"] : "";
        $issetPassword      = isset($dataForm["password"]) ? $dataForm["password"] : "";
        $issetOrdering 	    = isset($dataForm["ordering"]) ? $dataForm["ordering"] : "";
        $issetStatus 	    = isset($dataForm["status"]) ? $dataForm["status"] : 2;
        $issetGroup 	    = isset($dataForm["group_id"]) ? $dataForm["group_id"] : "default";

        $inputUserName 		= Helper::cmsInput("text", "form[username]", "username", $issetUserName, "inputbox required", 40);
        $inputEmail         = Helper::cmsInput("email", "form[email]", "email", $issetEmail, "inputbox required", 40);
        $inputFullname      = Helper::cmsInput("text", "form[fullname]", "fullname", $issetFullname, "inputbox", 40);
        $inputPassword      = Helper::cmsInput("text", "form[password]", "password", $issetPassword, "inputbox required", 40);
        $inputOrdering      = Helper::cmsInput("text", "form[ordering]", "ordering", $issetOrdering, "inputbox", 40);
        $inputToken         = Helper::cmsInput("hidden", "form[token]", "token", time());
        $selectSatus        = Helper::cmsSelectbox("form[status]", "", array(2 => "- Select status -", 1 => "publish", 0=>"unpublish"), $issetStatus);
        $selectGroup       = Helper::cmsSelectbox("form[group_id]", "", $this->_slbGroup, $issetGroup);

        //ROW
        $rowUserName  		= Helper::cmsRowForm("Name", $inputUserName, true);
        $rowEmail           = Helper::cmsRowForm("Email", $inputEmail, true);
        $rowFullname        = Helper::cmsRowForm("Full name", $inputFullname, false);
        $rowPassword        = Helper::cmsRowForm("Password", $inputPassword, true);
        $rowOrdering	    = Helper::cmsRowForm("Ordering", $inputOrdering, false);
        $rowStatus 		    = Helper::cmsRowForm("Status", $selectSatus);
        $rowGroup           = Helper::cmsRowForm("Group", $selectGroup);

        //Hiển thị id khi edit
        $rowID          = "";
        if(isset($dataForm["id"])){
            $inputID        = Helper::cmsInput("text", "form[id]", "id", $dataForm["id"] , "inputbox readonly");
            $rowID          = Helper::cmsRowForm("ID", $inputID, false);
            $inputUserName  = Helper::cmsInput("text", "form[username]", "username", $issetUserName, "inputbox readonly", 40);
            $rowUserName       = Helper::cmsRowForm("Name", $inputUserName, true);
        }

        //ERRORS
        $errors = isset($this->errors) ? $this->errors : "";

         //MESSAGE
        $message = isset($_SESSION["message"]) ? $_SESSION["message"] : "";
        $strMessage = "";
        if(!empty($message)){
            $strMessage .= Helper::cmsMessage($_SESSION["message"]); 
        }
        Session::delete("message");

?>	
<div id="system-message-container">
	<?php echo $errors.$strMessage; ?>
</div>
<div id="element-box">
			<div class="m">
				<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
					<!-- FORM LEFT -->
					<div class="width-100 fltlft">
						<fieldset class="adminform">
							<legend>Details</legend>
							<ul class="adminformlist">
									<?php echo $rowUserName.$rowEmail.$rowFullname.$rowPassword.$rowStatus.$rowGroup.$rowOrdering.$rowID; ?>
							</ul>
							<div class="clr"></div>
							<div>
								<?php echo $inputToken ?>
							</div>
						</fieldset>
					</div>
					<div class="clr"></div>
					<div>
					</div>
				</form>
				<div class="clr"></div>
			</div>
		</div>