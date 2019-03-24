<?php

	$nameBook		 = $this->detailBook["name"];
	$priceBook		 = $this->detailBook["price"];
    $descriptionBook = Helper::sliceStr($this->detailBook["description"], 30);

	$pictureFull = "";

    $picture = Helper::cmsImg("book", FRE_FIX_98x150, $this->detailBook["picture"], array("class" => "thumb"));

	if(file_exists(UPLOAD_PATH . "book/". WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-" . $this->detailBook["picture"])){
        $pictureFull = UPLOAD_URL . "book/". $this->detailBook["picture"];
    }

    $price 		= "";
    $priceReal  = 0;
    if($this->detailBook["sale_off"] > 0){
    	$priceReal = $priceBook-($priceBook*$this->detailBook["sale_off"]/100);
    	$price .= ' <span class="red-through">'.number_format($priceBook).'</span>';
    	$price .= ' <span class="red">'.number_format($priceReal).'</span>';
    }else{
    	$priceReal = $this->detailBook["price"];
    	$price .= ' <span class="red">'.number_format($priceReal).'</span>';
    }

    $linkOrder      = URL::createLink("default", "user", "order", array("book_id" => $this->detailBook["id"], "price" => $priceReal));
    $linkRelateBook = URL::createLink("default", "book", "relate", array("book_id" => $this->detailBook["id"], "category_id" => $this->detailBook["category_id"]));

?>

<div class="title"><span class="title_icon"><img src="<?php echo $imgURL?>/bullet1.gif"></span><?php echo $nameBook?></div>
<!-- DEATAIL -->
<div class="feat_prod_box_details">
            
	<div class="prod_img"><a href="#"><?php echo $picture ?></a>
    <br><br>
    <a id="single_image" href="<?php echo $pictureFull?>" rel="lightbox"><img src="<?php echo $imgURL?>/zoom.gif"></a>
    </div>
    
    <div class="prod_det_box">
    	<div class="box_top"></div>
        <div class="box_center">
        <div class="prod_title">Details</div>
        <p class="details"><?php echo $descriptionBook ?></p>
        <div class="price"><strong>PRICE:</strong>
        	<?php echo $price?>
        </div>

        <form method="post" action="#" name="adminForm" id="adminForm">
            <p style="padding-left: 15px"><span>Số lượng:</span><input style="width: 30px" type="number" name="quantity" value="1"></p>
            <a href="javascript:submitForm('<?php echo $linkOrder?>')" class="more"><img src="<?php echo $imgURL?>/order_now.gif"></a>
        </form>
        
        <div class="clear"></div>
        </div>
        
        <div class="box_bottom"></div>
    </div>    
<div class="clear"></div>
</div>



<!-- RELATED -->

<div id="demo" class="demolayout">

	<ul id="demo-nav" class="demolayout">
		<li><a id="tab1" class="active" href="#">More details</a></li>
		<li><a id="tab2" href="javascript:void(0)" onclick="javascript:showRelateBook('<?php echo $linkRelateBook; ?>')" >Related books</a></li>
	</ul>

	<div class="tabs-container">

		<div style="display: block;" class="tab" id="tab1-s">
			<p class="more_details"><?php echo $this->detailBook["description"]; ?></p>                           
		</div>	

		<div style="display: none;" class="tab" id="tab2-s">
			<?php 
                echo isset($xhtmlRelatedBook)? $xhtmlRelatedBook : "<h5 style='padding-left:15px'>Đang cập nhật...</5>";
            ?>

			
		</div>	

	</div>


</div>

