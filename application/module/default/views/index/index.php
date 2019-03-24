<?php
    $paginationHTML = $this->pagination->showPagination(URL::createLink("admin", "category", "index"));
    //SPECIAL BOOK
    $xhtml = "";
    if(!empty($this->specialBooks)){

        foreach ($this->specialBooks as $value) {
            $picture = Helper::cmsImg("book", FRE_FIX_98x150, $value["picture"], array("class" => "thumb"));
            
            $nameURL    = URL::filterURL($value["name"]);
            $cateURL    = URL::filterURL($value["category_name"]);
            $bookID     = $value["id"];
            $cateID     = $value["category_id"];;

             $linkDetail = URL::createLink("default", "book", "detail", array("book_id" => $value["id"], "category_id" => $value["category_id"]), "$cateURL/$nameURL/$bookID-$cateID.html");
            $name           = $value["name"];
            $description    = Helper::sliceStr($value["description"], 30);

            $xhtml      .= '<div class="feat_prod_box">
            
                                <div class="prod_img"><a href="'.$linkDetail.'">'.$picture.'</a></div>
                                <div class="prod_det_box">
                                    <div class="box_top"></div>
                                    <div class="box_center">
                                    <div class="prod_title"><a href="'.$linkDetail.'">'.$name.'</a></div>
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

    //NEW BOOK
    $xhtmlnewBook = "";
    if(!empty($this->newBooks)){

        foreach ($this->newBooks as $value) {
            $name       = Helper::sliceStr($value["name"]);

            $frefix     = WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-";
            $picture    = Helper::cmsImg("book", $frefix, $value["picture"], array("class" => "thumb", "width" => 60, "height" => 90));
          
            $nameURL    = URL::filterURL($value["name"]);
            $cateURL    = URL::filterURL($value["category_name"]);
            $bookID     = $value["id"];
            $cateID     = $value["category_id"];;

             $linkDetail = URL::createLink("default", "book", "detail", array("book_id" => $value["id"], "category_id" => $value["category_id"]), "$cateURL/$nameURL/$bookID-$cateID.html");

            $xhtmlnewBook .= '<div class="new_prod_box">
                        <a href="'.$linkDetail.'">'.$name.'</a>
                        <div class="new_prod_bg">
                        <a href="'.$linkDetail.'">'.$picture.'</a>
                        </div>           
                    </div>';
        }   
    }
    
?>

    	
    <div class="title">
        <span class="title_icon"><img src="<?php echo $imgURL?>/bullet1.gif" alt="" title="" /></span>Future Books
    </div>
    <?php
        echo $xhtml;
        echo $paginationHTML;
    ?>   
            
            
            
           <div class="title"><span class="title_icon"><img src="<?php echo $imgURL?>/bullet2.gif" alt="" title="" /></span>New books</div> 
           
           <div class="new_products">
                <?php
                    echo $xhtmlnewBook;
                ?>

            </div>

            <form name="adminForm" id="adminForm" action="#" method="post">
                <input type="hidden" name="filter_page" value="1">  
            </form> 
                  
            
        <div class="clear"></div>
