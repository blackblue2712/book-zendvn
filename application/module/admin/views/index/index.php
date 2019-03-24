<?php

	$imgURL 	= $this->_dirImg;
	$arrMenu  		= array(
							array("link" => URL::createLink("admin", "book", "form"), "name" => "Add new book", "image" => "icon-48-article-add"),
							array("link" => URL::createLink("admin", "book", "index"), "name" => "Book Manager", "image" => "icon-48-article"),
							array("link" => URL::createLink("admin", "category", "index"), "name" => "Category", "image" => "icon-48-category"),
							array("link" => URL::createLink("admin", "group", "index"), "name" => "Group Manager", "image" => "icon-48-groups"),
							array("link" => URL::createLink("admin", "user", "index"), "name" => "User Manager", "image" => "icon-48-user")
						);
	$xhtml = "";
	foreach ($arrMenu as $key => $value) {
		$image  = '<img src="'.$imgURL.'/header/'.$value["image"].'.png" alt="'.$value["name"].'">';
		$xhtml .= '<div class="icon-wrapper">
						<div class="icon">
							<a href="'.$value["link"].'">'.$image.'<span>'.$value["name"].'</span>
							</a>
						</div>
					</div>';
	}
?>
<div id="element-box">
			<div id="system-message-container">

			</div>
			<div class="m">
				<div class="adminform">
					<div class="cpanel-left">
						<div class="cpanel">
							<?php echo $xhtml?>
						</div>
					</div>
					
				</div>
				<div class="clr"></div>
			</div>
		</div>