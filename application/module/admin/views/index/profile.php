<?php
        include_once (MODULE_PATH .  "admin/views/toolbar.php");

       

        //INPUT
        $dataForm           = isset($this->arrParams["form"]) ? $this->arrParams["form"] : "";
        $issetEmail         = isset($dataForm["email"]) ? $dataForm["email"] : "";
        $issetFullname      = isset($dataForm["fullname"]) ? $dataForm["fullname"] : "";;

        $inputToken         = Helper::cmsInput("hidden", "form[token]", "token", time());
        $inputEmail         = Helper::cmsInput("email", "form[email]", "email", $issetEmail, "inputbox required", 40);
        $inputFullname      = Helper::cmsInput("text", "form[fullname]", "fullname", $issetFullname, "inputbox", 40);

        //ROW
        $rowEmail           = Helper::cmsRowForm("Email", $inputEmail);
        $rowFullname        = Helper::cmsRowForm("Full name", $inputFullname);

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
                                    <?php echo $rowEmail.$rowFullname.$rowID; ?>
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