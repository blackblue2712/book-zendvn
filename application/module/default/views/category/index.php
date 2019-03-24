<?php
	$xhtml = "";
	if(!empty($this->_listItem)){
		foreach ($this->_listItem as $value) {
			$name 	 = Helper::sliceStr($value->name, 2);
            $picture = Helper::cmsImg("category", FRE_FIX_DF, $value->picture, array("class" => "thumb"));
            $nameURL = URL::filterURL($value->name);

			$linkDetail = URL::createLink("default", "book", "list", array("category_id" => $value->id), "$nameURL-$value->id.html");
			$xhtml .= '<div class="new_prod_box">
				        <a href="'.$linkDetail.'">'.$name.'...</a>
				        <div class="new_prod_bg">
				        <a href="'.$linkDetail.'">'.$picture.'</a>
				        </div>           
				    </div>';
		}	
	}
	
?>


<div class="crumb_nav"><a href="">Home</a> &gt;&gt; Category</div>
<div class="title"><span class="title_icon"><img src="<?php echo $imgURL?>/bullet1.gif"></span>Category books</div>
<div class="new_products">      
	<?php echo $xhtml ?>

	
</div>