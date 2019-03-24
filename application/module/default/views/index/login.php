<?php

  	//INPUT

	$inputSubmit 		= Helper::cmsInput("submit", "form[submit]", "login", "Login" , "register");
	$inputTooken 		= Helper::cmsInput("hidden", "form[token]", "token", time());

	//ROW
	$rowEmail 	  		= Helper::cmsRow("User/Email", Helper::cmsInput("text", "form[email]", "email", null , "contact_input") );
	$rowPassword  		= Helper::cmsRow("Password", Helper::cmsInput("password", "form[password]", "password", null , "contact_input") );
	$rowRegister  		= Helper::cmsRow("Register",$inputTooken.$inputSubmit, true );

	$linkAction 		= URL::createLink("default", "index", "login");

	$errors = isset($this->errors)? $this->errors : "";

?>

<div class="title"><span class="title_icon"><img src="<?php echo $imgURL;?>/bullet1.gif"/></span>Sign in your accout</div>
<div class="feat_prod_box_details">
<p class="details">
 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.
 <?php echo $errors;?>
</p>

  	<div class="contact_form">
    <div class="form_subtitle">Login</div>

    <form name="adminform" action="<?php echo $linkAction?>" method="post">          
        <?php
        	echo $rowEmail.$rowPassword.$rowRegister;
        ?>
    </form>     

    </div>  

</div>