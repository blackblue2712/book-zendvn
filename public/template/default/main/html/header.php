<?php
    require_once LIBRARY_PATH . "extends/XML.php";
    $infoObj = Session::get("user");

    $imgURL         = $this->_dirImg;

    //Link Router
    $linkHome       =  URL::createLink("default", "index", "index", null, "index.html");
    $linkCate       =  URL::createLink("default", "category", "index", null, "category.html");
    $linkMA         =  URL::createLink("default", "user", "index", null, "my-account.html");
    $linkLO         =  URL::createLink("default", "index", "logout", null, "logout.html");
    $linkRegister   =  URL::createLink("default", "index", "register", null, "register.html");
    $linkLI         =  URL::createLink("default", "index", "login", null, "login.html");

    $arrMenu[]        = array("class" => "index-index", "link" => $linkHome, "name" => "Home");
    $arrMenu[]        = array("class" => "category-index", "link" => $linkCate, "name" => "Categories");

    if($infoObj["login"] == true){
        $arrMenu[]        = array("class" => "user-index user-history user-cart", "link" => $linkMA, "name" => "My Account");
        $arrMenu[]        = array("class" => "index-logout", "link" => $linkLO, "name" => "Logout");
    }else{
        $arrMenu[]        = array("class" => "index-register", "link" => $linkRegister, "name" => "Register");
        $arrMenu[]        = array("class" => "index-login", "link" => $linkLI, "name" => "Login");
    }

    if($infoObj["group_acp"] == true){
        $arrMenu[]        = array("class" => "", "link" => URL::createLink("admin", "index", "index"), "name" => "Admin Control Panel");   
    }

    $xhtml      = "";
    foreach ($arrMenu as $key => $value) {
        $xhtml      .= '<li class="'.$value["class"].'"><a class="'.$value["class"].'" href="'.$value["link"].'">'.$value["name"].'</a></li>';
    }

    //Hover cate
    $cate = '';
    $data = XML::getContentXML("categories.xml");
    if(!empty($data)){
         foreach ($data as $value) {
            $nameURL = URL::filterURL($value->name);
            $linkDetail = URL::createLink("default", "book", "list", array("category_id" => $value->id), "$nameURL-$value->id.html");
            $cate .= '<li class="hv_cate_item"><a href='.$linkDetail.'>'.$value->name.'</a></li>';
        }
    }
   

    $controller = $this->arrParams["controller"];
    $action     = $this->arrParams["action"];
?>

<div class="header">
    <div class="logo"><a href="index.html"><img src="<?php echo $imgURL ?>/logo.gif" alt="" title="" border="0" /></a></div>            
    <div id="menu">
        <ul>                                                                       
           <?php echo $xhtml ?>
        </ul>
    </div>   
</div>
<!-- category-hover -->
<div id="wrap_hover">
    <div class="cate_hover">
        <ul>
            <?php echo $cate?>
        </ul>
    </div>
</div>


<script type="text/javascript">
    var controller   = '<?php echo $controller ?>';
    var action       = '<?php echo $action ?>'
    var classSelect  = controller + "-" + action;

    $("#menu ul li." + classSelect).addClass("selected");

    $(".category-index").mouseover(function(){
        $("#wrap_hover").fadeIn();
    });

    $("body, html").click(function(){
        $("#wrap_hover").fadeOut("fast");
    })
</script>

       