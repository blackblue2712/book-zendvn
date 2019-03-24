<?php
    $model      = new Models();

    $arrORDER   = array("id", "ordering", "created");
    shuffle($arrORDER);


    $query      = "SELECT `b`.`id`, `b`.`name`, `c`.`name` AS `category_name`, `b`.`picture`, `b`.`category_id` FROM " . TABLE_BOOK . " AS b, ".TABLE_CATEGORY." AS c WHERE `b`.`sale_off` > 0  AND `c`.`id` = `b`.`category_id` ORDER BY `b`.`".$arrORDER[0]."` DESC LIMIT 0,5";
    $listPro    = $model->fetchAll($query);


    $xhtml      = "";

    if(!empty($listPro)){
        foreach ($listPro as $value) {
           
            $name       = Helper::sliceStr($value["name"]);
            $nameURL    = URL::filterURL($value["name"]);
            $cateURL    = URL::filterURL($value["category_name"]);
            $bookID     = $value["id"];
            $cateID     = $value["category_id"];;

             $linkDetail = URL::createLink("default", "book", "detail", array("book_id" => $value["id"], "category_id" => $value["category_id"]), "$cateURL/$nameURL/$bookID-$cateID.html");

            $picture = Helper::cmsImg("book", FRE_FIX_98x150, $value["picture"], array("class" => "thumb", "width" => 60, "height" => 90));
           

           $xhtml .= ' <div class="new_prod_box">
                            <a href="'.$linkDetail.'">'.$name.'</a>
                            <div class="new_prod_bg">
                            <span class="new_icon"><img src="'.$imgURL.'/promo_icon.gif"/></span>
                            <a href="'.$linkDetail.'">'.$picture.'</a>
                            </div>           
                        </div>';
           
        }   
    }
?>

<div class="right_box">
 	<div class="title"><span class="title_icon"><img src="<?php echo $imgURL ?>/bullet4.gif"/></span>Promotions</div> 
       <?php
            echo $xhtml;
       ?>    
 
</div>