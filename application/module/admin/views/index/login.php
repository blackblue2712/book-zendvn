<?php
	$linkAction = URL::createLink("admin", "index", "login");

?>
<div id="border-top" class="h_blue">
		<span class="title"><a href="index.php">Administration</a></span>
	</div>
	<div id="content-box">
		<div id="element-box" class="login">
			<div class="m wbg">
				<h1>Administration Login</h1>
				
                <div id="section-box">
					<div class="m">
						<form action="<?php echo $linkAction ?>" method="post" id="form-login">
							<fieldset class="loginform">
								<!-- USER NAME -->
                                <label>User Name</label>
                                <input name="form[username]" id="mod-login-username" type="text" class="inputbox" size="15" />

								<!-- PASSWORD -->
                                <label id="mod-login-password-lbl" for="mod-login-password">Password</label>
                                <input name="form[password]" id="mod-login-password" type="password" class="inputbox" size="15" />
								
								<input type="hidden" name="form[token]" value="<?php echo time()?>">
	
                                <div class="button-holder">
                                    <div class="button1">
                                        <div class="next">
                                            <a href="#" id="submit">Log in</a>
                                        </div>
                                    </div>
                                </div>
								<div class="clr"></div>
                            </fieldset>
						</form>
						<div class="clr"></div>
					</div>
				</div>
		
            	<p>Use a valid username and password to gain access to the administrator backend.</p>
            	<p><a href="http://localhost/joomla/">Go to site home page.</a></p>
				<div id="lock"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<p class="copyright">
			<a href="http://www.joomla.org">Joomla!&#174;</a> is free software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU General Public License</a>.	
		</p>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			
			$("a#submit").click(function(){
				var username = $("input#mod-login-username").val();
				var password = $("input#mod-login-password").val();
				if(username.length == 0 || password.length == 0){
					alert("You must fill out login-form");
					return false;
				}else{
					$("#form-login").submit();
				}
			});
			$(document).keyup(function(e){
				var username = $("input#mod-login-username").val();
				var password = $("input#mod-login-password").val();
				if(e.keyCode == 13){
					if(username.length == 0 || password.length == 0) alert("You must fill out login-form");
					else $("#form-login").submit();
				}
			});
		})
	</script>