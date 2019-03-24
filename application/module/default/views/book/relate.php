<?php
$xhtmlRelatedBook = "";
    if(!empty($this->relatedBook)){
        foreach ($this->relatedBook as $value) {
            $name       = Helper::sliceStr($value["name"], 2);
            $nameURL    = URL::filterURL($value["name"]);
            $cateURL    = URL::filterURL($value["category_name"]);
            $bookID     = $value["id"];
            $cateID     = $value["category_id"];;

            $linkDetail = URL::createLink("default", "book", "detail", array("book_id" => $value["id"], "category_id" => $value["category_id"]), "$cateURL/$nameURL/$bookID-$cateID.html");

            $frefix = WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-";
            $picture = Helper::cmsImg("book", $frefix, $value["picture"], array("class" => "thumb", "width" => 60, "height" => 90));

            $xhtmlRelatedBook .= '<div class="new_prod_box">
			                        <a href="'.$linkDetail.'">'.$name.'</a>
			                        <div class="new_prod_bg">
			                        <a href="'.$linkDetail.'">'.$picture.'</a>
			                        </div>           
			                    </div>';
        }   
    }
    echo $xhtmlRelatedBook.'<div class="clear"></div>';
?>