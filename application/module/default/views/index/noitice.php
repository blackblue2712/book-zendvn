<?php
	$strNoitice = "";
	switch ($this->arrParams['type']) {
		case 'register-success':
			$strNoitice = "Your account are registered. Please wait for admin to active it!";
			break;
		case 'non-permission':
			$strNoitice = "You don't have permission to access admin-system!";
			break;
		case '404':
			$strNoitice = "<h3>404 File not found!</h3>";
			break;
	}

?>
<div class="noitice">
	<?php echo $strNoitice ?>
</div>