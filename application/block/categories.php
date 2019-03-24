<?php
    require_once LIBRARY_EXT_PATH . "XML.php";
    //load xml
    $data = XML::getContentXML("categories.xml");

    //active
    $cateID         = isset($this->arrParams['category_id'])? $this->arrParams['category_id']: "";

    $xhtml      = "";

    if(!empty($data)){
        foreach ($data as $value) {
            
            $name       = Helper::sliceStr($value->name);
            $nameURL    = URL::filterURL($value->name);
            $linkDetail = URL::createLink("default", "book", "list", array("category_id" => $value->id), "$nameURL-$value->id.html");

            if($cateID == $value->id){
                $xhtml      .= '<li><a class="active" title="'.$value->name.'" href="'.$linkDetail.'">'.$name.'</a></li>';
             }else{
                $xhtml      .= '<li><a title="'.$value->name.'" href="'.$linkDetail.'">'.$name.'</a></li>';
             }
           
        }   
    }
?>
  <div class="right_box" id="category">
             
 	<div class="title"><span class="title_icon"><img src="<?php echo $imgURL ?>/bullet5.gif" alt="" title="" /></span>Categories</div> 
    
    <ul class="list">
        <?php echo $xhtml?>                                   
    </ul>
    
 </div>         