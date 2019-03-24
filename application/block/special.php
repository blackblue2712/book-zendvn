<?php
	$arrORDER   = array("id", "ordering", "created");
    shuffle($arrORDER);

	$query	= "SELECT `b`.`id`, `b`.`name`, `c`.`name` AS `category_name`, `b`.`picture`, `b`.`category_id` FROM `".TABLE_BOOK."` AS `b`, `".TABLE_CATEGORY."` AS `c` WHERE `b`.`status`  = 1 AND `b`.`special`  = 1 AND `b`.`category_id` = `c`.`id` ORDER BY `b`.`".$arrORDER[0]."` ASC LIMIT 0,5";
	$listBooksSecial	= $model->fetchAll($query);
	$xhtmlSecial		= '';

	if(!empty($listBooksSecial)){
		foreach($listBooksSecial as $key => $value){
			$name       = Helper::sliceStr($value["name"]);
			
			$bookID			= $value['id'];
			$catID			= $value['category_id'];
			$bookNameURL	= URL::filterURL($value["name"]);
			$catNameURL		= URL::filterURL($value['category_name']);
				
			$link	= URL::createLink('default', 'book', 'detail', array('category_id' => $value['category_id'],'book_id' => $value['id']), "$catNameURL/$bookNameURL/$bookID-$catID.html");
			
			$picture = Helper::cmsImg('book', '98x150-', $value['picture'], array('class' => 'thumb', 'width' => 60, 'height' => 90));
			
			$xhtmlSecial	.= '<div class="new_prod_box">
	                        <a href="'.$link.'">'.$name.'</a>
	                        <div class="new_prod_bg">
	                        <span class="new_icon"><img src="'.$imgURL.'/special_icon.gif" alt="" title="" /></span>
	                        <a href="'.$link.'">'.$picture.'</a>
	                        </div>           
	                    </div>';
		}
	}
?>
<div class="right_box">
	<!-- TITLE -->
	<div class="title"><span class="title_icon"><img src="<?php echo $imgURL ?>/bullet4.gif"/></span>Special</div>
	
	<?php echo $xhtmlSecial;?>
</div>
