<?php
        include_once (MODULE_PATH .  "admin/views/toolbar.php");
        include_once "submenu/index.php";



        //INPUT
        $dataForm 		= isset($this->arrParams["form"]) ? $this->arrParams["form"] : "";
        $issetName 		= isset($dataForm["name"]) ? $dataForm["name"] : "";
        $issetOrdering 	= isset($dataForm["ordering"]) ? $dataForm["ordering"] : "";
        $issetStatus 	= isset($dataForm["status"]) ? $dataForm["status"] : 2;
        $issetGroupACP 	= isset($dataForm["group_acp"]) ? $dataForm["group_acp"] : 2;

        $inputName 		= Helper::cmsInput("text", "form[name]", "name", $issetName, "inputbox required", 40);
        $inputOrdering	= Helper::cmsInput("text", "form[ordering]", "ordering", $issetOrdering, "inputbox", 40);
        $inputToken		= Helper::cmsInput("hidden", "form[token]", "token", time());
        $selectSatus 	= Helper::cmsSelectbox("form[status]", "", array(2 => "- Select status -", 1 => "publish", 0=>"unpublish"), $issetStatus);
        $selectGroupACP	= Helper::cmsSelectbox("form[group_acp]", "", array(2 => "- Select Group ACP -", 1 => "Yes", 0=>"No"),  $issetGroupACP);


        //ROW
        $rowName  		= Helper::cmsRowForm("Name", $inputName, true);
        $rowOrdering	= Helper::cmsRowForm("Ordering", $inputOrdering, false);
        $rowStatus 		= Helper::cmsRowForm("Status", $selectSatus);
        $rowGroupACP	= Helper::cmsRowForm("Group ACP", $selectGroupACP);

        //Hiển thị id khi edit
        $rowID          = "";
        if(isset($dataForm["id"])){
            $inputID    = Helper::cmsInput("text", "form[id]", "id", $dataForm["id"] , "inputbox readonly");
            $rowID      = Helper::cmsRowForm("ID", $inputID, false);
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
									<?php echo $rowName.$rowStatus.$rowGroupACP.$rowOrdering.$rowID; ?>
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