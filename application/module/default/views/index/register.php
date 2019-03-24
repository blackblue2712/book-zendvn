<?php

  	//INPUT
    $dataForm           = isset($this->arrParams["form"]) ? $this->arrParams["form"] : "";
    $issetUserName      = isset($dataForm["username"]) ? $dataForm["username"] : "";
    $issetEmail         = isset($dataForm["email"]) ? $dataForm["email"] : "";
    $issetFullname      = isset($dataForm["fullname"]) ? $dataForm["fullname"] : "";
    $issetPassword      = isset($dataForm["password"]) ? $dataForm["password"] : "";

	$inputSubmit 		= Helper::cmsInput("submit", "form[submit]", "submit", "Register" , "register");
	$inputTooken 		= Helper::cmsInput("hidden", "form[tooken]", "tooken", time());

	//ROW
	$rowUserName  		= Helper::cmsRow("Name", Helper::cmsInput("text", "form[username]", "username", $issetUserName, "contact_input") );
	$rowFullName		= Helper::cmsRow("Full Name", Helper::cmsInput("text", "form[fullname]", "fullname", $issetFullname , "contact_input") );
	$rowEmail 	  		= Helper::cmsRow("Email", Helper::cmsInput("email", "form[email]", "email", $issetEmail , "contact_input") );
	$rowPassword  		= Helper::cmsRow("Password", Helper::cmsInput("text", "form[password]", "password", $issetPassword , "contact_input") );
	$rowRegister  		= Helper::cmsRow("Register",$inputTooken.$inputSubmit, true );

	$linkAction 		= URL::createLink("default", "index", "register");

	$errors = isset($this->errors)? $this->errors : "";

?>

<div class="title"><span class="title_icon"><img src="<?php echo $imgURL;?>/bullet1.gif"/></span>Register</div>
<div class="feat_prod_box_details">
<p class="details">
 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.
 <?php echo $errors;?>
</p>

  	<div class="contact_form">
    <div class="form_subtitle">Create new account</div>

    <form name="adminform" action="<?php echo $linkAction?>" method="post">          
        <?php
        	echo $rowUserName.$rowFullName.$rowPassword.$rowEmail.$rowRegister;
        ?>
    </form>     

    </div>  

</div>