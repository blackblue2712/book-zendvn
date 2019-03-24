<?php
	$xhtml = "";
	if(!empty($this->_listBook)){

		foreach ($this->_listBook as $value) {

			$nameURL    = URL::filterURL($value["name"]);
            $cateURL    = URL::filterURL($this->nameCategory["name"]);
            $bookID     = $value["id"];
            $cateID     = $value["category_id"];;

             $linkDetail = URL::createLink("default", "book", "detail", array("book_id" => $value["id"], "category_id" => $value["category_id"]), "$cateURL/$nameURL/$bookID-$cateID.html");

	        $picture 	= Helper::cmsImg("book", FRE_FIX_98x150, $value["picture"], array("class" => "thumb"));
			$name 		= $value["name"];
			$description= Helper::sliceStr($value["description"], 30);

			$xhtml 		.= '<div class="feat_prod_box">
            
				            	<div class="prod_img"><a href="'.$linkDetail.'">'.$picture.'</a></div>
				                <div class="prod_det_box">
				                	<span class="special_icon"></span>
				                	<div class="box_top"></div>
				                    <div class="box_center">
				                    <div class="prod_title">'.$name.'</div>
				                    <p class="details">'.$description.'</p>
				                    <a href="'.$linkDetail.'" class="more">- more details -</a>
				                    <div class="clear"></div>
				                    </div>
				                    
				                    <div class="box_bottom"></div>
				                </div>    
				            <div class="clear"></div>
				            </div>';
		}	
	}else{
		$xhtml = '<div class="feat_prod_box"><h2>Đang cập nhật sách ...</2><h6>Waiting for update ...</h6></div>';
	}
	
?>

<div class="title"><span class="title_icon"><img src="<?php echo $imgURL?>/bullet1.gif"></span><?php echo isset($this->nameCategory["name"]) ? $this->nameCategory["name"] : "No title" ?></div>
<?php
	echo $xhtml;
?>
