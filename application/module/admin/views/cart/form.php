<?php
        include_once (MODULE_PATH .  "admin/views/toolbar.php");
        include_once "submenu/index.php";



        //INPUT

        $dataForm 		= isset($this->arrParams["form"]) ? $this->arrParams["form"] : "";
        $issetName 		= isset($dataForm["name"]) ? $dataForm["name"] : "";
        $issetOrdering 	= isset($dataForm["ordering"]) ? $dataForm["ordering"] : "";
        $issetStatus 	= isset($dataForm["status"]) ? $dataForm["status"] : 2;
        $issetImage     = isset($dataForm["picture"]) ? $dataForm["picture"] : "";

       

        $inputName 		= Helper::cmsInput("text", "form[name]", "name", $issetName, "inputbox required", 40);
        $inputOrdering	= Helper::cmsInput("text", "form[ordering]", "ordering", $issetOrdering, "inputbox", 40);
        $inputToken		= Helper::cmsInput("hidden", "form[token]", "token", time());
        $selectSatus 	= Helper::cmsSelectbox("form[status]", "", array(2 => "- Select status -", 1 => "publish", 0=>"unpublish"), $issetStatus);

       $inputFile       = Helper::cmsInput("file", "picture", "picture", "", "inputbox");
       $inputImageHidden= Helper::cmsInput("hidden", "form[picture_hidden]", "picture",$issetImage , "inputbox");


        //ROW
        $rowName  		= Helper::cmsRowForm("Name", $inputName, true);
        $rowOrdering	= Helper::cmsRowForm("Ordering", $inputOrdering, false);
        $rowStatus 		= Helper::cmsRowForm("Status", $selectSatus);
        $rowFile        = Helper::cmsRowForm("File", $inputFile);

        //Hiển thị id khi edit
        $rowID          = "";
        $picture        = "";
        $pictureHidden  = "";
        if(isset($dataForm["id"])){
            $inputID    = Helper::cmsInput("text", "form[id]", "id", $dataForm["id"] , "inputbox readonly");
            $rowID      = Helper::cmsRowForm("ID", $inputID, false);

            //Hiển thị ảnh đã resize
            $picture    = Helper::cmsRowForm("Picture", '<img src = "' .UPLOAD_URL."category/".WIDTH_RESIZE."x".HEIGHT_RESIZE."-".$issetImage . '"</img>' , false);

            $pictureHidden    = Helper::cmsRowForm("",$inputImageHidden, false);
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
				<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
					<!-- FORM LEFT -->
					<div class="width-100 fltlft">
						<fieldset class="adminform">
							<legend>Details</legend>
							<ul class="adminformlist">
									<?php echo $rowName.$rowStatus.$rowOrdering.$rowFile.$picture.$pictureHidden.$rowID; ?>
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
