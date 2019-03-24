 
 <?php
 	$_SESSION["token"] =  time();
 	$linkChangePassword = URL::createLink("default", "user", "changepass", null, "changepass.html");
 	$message = Session::get("message");
 	Session::delete("message");
 ?>
 <div class="messageChange"><?php echo $message?></div>
 <div class="login">
 	<h3>Change your password</h3>
 	<form method="post" action="<?php echo $linkChangePassword?>">
 		<p><label class="label">Current password: </label><input class="form-control" type="password" name="form[current_password]" value=""></p>
 		<p><label class="label">New password: </label><input class="form-control" type="password" name="form[new_password]" value=""></p>

 		<a class="btn btn-primary" href="bookstore/index.html">Go home</a>
 		<input style="margin: 0px 140px 0px 30px" class="btn btn-success" type="submit" name="commit" value="Change">
 		<a class="btn-success" href="javascript:showPassword()">Show password</a>
 		<input type="hidden" name="form[token]" value="<?php echo time()?>">
 	</form>
 </div>
<?php
	if(!empty($message)){
 		echo '<script type="text/javascript">$(".messageChange").slideDown(500).delay(1000).slideUp()</script>';
 	}
?>