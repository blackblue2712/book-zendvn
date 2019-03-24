<?php
        include_once (MODULE_PATH .  "admin/views/toolbar.php");
        include_once "submenu/index.php";



        //INPUT


        $dataForm           = isset($this->arrParams["form"]) ? $this->arrParams["form"] : "";
        $issetName          = isset($dataForm["name"]) ? $dataForm["name"] : "";
        $issetDescription   = isset($dataForm["description"]) ? $dataForm["description"] : "";
        $issetPrice         = isset($dataForm["price"]) ? $dataForm["price"] : "";
        $issetSaleOff       = isset($dataForm["sale_off"]) ? $dataForm["sale_off"] : 0;
        $issetOrdering 	    = isset($dataForm["ordering"]) ? $dataForm["ordering"] : "";
        $issetStatus 	    = isset($dataForm["status"]) ? $dataForm["status"] : 2;
        $issetSpecial       = isset($dataForm["special"]) ? $dataForm["special"] : 2;
        $issetCategory 	    = isset($dataForm["category_id"]) ? $dataForm["category_id"] : "default";
        $issetImage         = isset($dataForm["picture"]) ? $dataForm["picture"] : "";
        if(is_array($issetImage)) $issetImage = $issetImage["name"];

        $inputName 		    = Helper::cmsInput("text", "form[name]", "name", $issetName, "inputbox required", 40);
        $inputPrice         = Helper::cmsInput("text", "form[price]", "price", $issetPrice, "inputbox required", 40);
        $inputSaleOff       = Helper::cmsInput("text", "form[sale_off]", "sale_off", $issetSaleOff, "inputbox", 40);
        $inputDescription   = '<textarea name="form[description]">'.$issetDescription.'</textarea>';
        $inputOrdering      = Helper::cmsInput("text", "form[ordering]", "ordering", $issetOrdering, "inputbox", 40);
        $inputToken         = Helper::cmsInput("hidden", "form[token]", "token", time());
        $selectSatus        = Helper::cmsSelectbox("form[status]", "", array(2 => "- Select status -", 1 => "publish", 0=>"unpublish"), $issetStatus);
        $selectSpecial      = Helper::cmsSelectbox("form[special]", "", array(2 => "- Select special -", 1 => "Yes", 0=>"No"), $issetSpecial);
        $selectCategory     = Helper::cmsSelectbox("form[category_id]", "", $this->_slbCategory, $issetCategory);
        $inputFile          = Helper::cmsInput("file", "picture", "picture", "", "inputbox");
        $inputImageHidden   = Helper::cmsInput("hidden", "form[picture_hidden]", "picture",$issetImage , "inputbox");

        //ROW
        $rowName      		= Helper::cmsRowForm("Name", $inputName, true);
        $rowDescription     = Helper::cmsRowForm("Description", $inputDescription, true);
        $rowPrice           = Helper::cmsRowForm("Price", $inputPrice, true);
        $rowSaleOff         = Helper::cmsRowForm("Sale Off", $inputSaleOff, false);
        $rowOrdering	    = Helper::cmsRowForm("Ordering", $inputOrdering, false);
        $rowStatus 		    = Helper::cmsRowForm("Status", $selectSatus);
        $rowSpecial         = Helper::cmsRowForm("Special", $selectSpecial);
        $rowCategory        = Helper::cmsRowForm("Category", $selectCategory);
        $rowFile            = Helper::cmsRowForm("File", $inputFile);
        //Hiển thị id khi edit
        $rowID          = "";
        $picture        = "";
        $pictureHidden  = "";
        if(isset($dataForm["id"])){
            $inputID        = Helper::cmsInput("text", "form[id]", "id", $dataForm["id"] , "inputbox readonly");
            $rowID          = Helper::cmsRowForm("ID", $inputID, false);
            $inputName      = Helper::cmsInput("text", "form[name]", "name", $issetName, "inputbox readonly", 40);
            $rowName        = Helper::cmsRowForm("Name", $inputName, true);
             //Hiển thị ảnh đã resize
            $picture        = Helper::cmsRowForm("Picture", '<img src = "' .UPLOAD_URL."book/".WIDTH_RESIZE_98."x".HEIGHT_RESIZE_150."-".$issetImage . '"</img>' , false);

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
									<?php echo $rowName.$rowFile.$picture.$pictureHidden.$rowDescription.$rowPrice.$rowSaleOff.$rowStatus.$rowSpecial.$rowCategory.$rowOrdering.$rowID; ?>
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

        