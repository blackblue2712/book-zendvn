<?php
	$linkCategory 	= URL::createLink('admin', 'category', 'index'); 
	$linkBook 		= URL::createLink('admin', 'book', 'index'); 
	$linkCart 		= URL::createLink('admin', 'cart', 'confirmCart'); 
?>
<div id="submenu-box">
	<div class="m">
		<ul id="submenu">
			<li><a href="<?php echo $linkCategory?>">Catehory</a></li>
			<li><a href="<?php echo $linkBook?>">Book</a></li>
			<li><a href="#" class="active">Cart</a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>