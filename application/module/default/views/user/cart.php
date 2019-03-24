
<div class="title"><span class="title_icon"><img src="<?php echo $imgURL?>/bullet1.gif"></span>My cart</div>


<div class="feat_prod_box_details">
    <?php
   		
   		//Edit quantity
    	if(isset($_POST["form"])){
    		if(!empty($this->Items)){
    			foreach ($this->Items as $key => $value) {
    				$this->Items[$key]["quantity"] = $_POST["form"]["quantity"][$key];
    			}
    		}
    	}

    	//Delete element
    	if(isset($_GET["delete_id"])){
    		if(!empty($this->Items)){
    			foreach ($this->Items as $key => $value) {
    				if($value["id"] == $_GET["delete_id"]){
    					unset($this->Items[$key]);
    					unset($_SESSION["cart"]["quantity"][$_GET["delete_id"]]);
    					unset($_SESSION["cart"]["price"][$_GET["delete_id"]]);
    				}
    			}
    		}
    	}

    	//
    	if(!empty($this->Items)){
    		$xhtml = "";
    		$totalPriceInCart = 0;
    		$linkCategory 	  = URL::createLink("default", "category", "index");
    		$linkSubmitForm	  = URL::createLink("default", "user", "buy");
    		$linkUpdate	 	  = URL::createLink("default", "user", "cart");

    		foreach ($this->Items as $key => $value) {
    			$linkDetailBook 	= URL::createLink("default", "book", "detail", array("book_id" => $value["id"], "category_id" => $value["category_id"]));
    			$linkDelete	 	  = URL::createLink("default", "user", "cart", array("delete_id" => $value["id"]));
    			
    			$totalPriceInCart 	+= $value["totalPrice"];

            	$picture = Helper::cmsImg("book", FRE_FIX_98x150, $value["picture"], array("class" => "thumb", "width" => 30, "height" => 45));

            	$inputEDQuantity= Helper::cmsInput("number", "form[quantity][]", "ip_quantity" . $value["id"], $value["quantity"], "input-30");

	            $xhtml .= '<tr>
							<td><a href="'.$linkDetailBook.'">'.$picture.'</a></td>
							<td>'.$value["name"].'</td>
							<td>'.number_format($value["price"]).'</td>
							<td>'.$inputEDQuantity.'</td>
							<td>'.number_format($value["totalPrice"]).'</td>
							<td><a class="delete_item" href="'.$linkDelete.'">x</a></td>              
							</tr>';


				$inputID 		= Helper::cmsInput("hidden", "form[bookID][]", "ip_book" . $value["id"], $value["id"]);
				//$inputQuantity 	= Helper::cmsInput("hidden", "form[quantity][]", "ip_quantity" . $value["id"], $value["quantity"]);
				
				$inputPicture	= Helper::cmsInput("hidden", "form[picture][]", "ip_picture" . $value["id"], $value["picture"]);
				$inputPrice		= Helper::cmsInput("hidden", "form[price][]", "ip_price" . $value["id"], $value["price"]);
				$inputName		= Helper::cmsInput("hidden", "form[name][]", "ip_name" . $value["id"], $value["name"]);

				$xhtml .= $inputID.$inputPicture.$inputPrice.$inputName;
    		}

    ?>
    <form pre="btn-ca" id="adminForm" name="adminForm" method="POST" action="<?php echo $linkSubmitForm?>">
	    <table class="cart_table">
			<tbody><tr class="cart_title">
				<td>Item pic</td>
				<td>Book name</td>
				<td>Unit price</td>
				<td>Qty</td>
				<td>Total</td>
				<td>Del</td>
			</tr>
			<?php echo $xhtml ?>
			<tr>
				<td colspan="4" class="cart_total"><span class="red">TOTAL: </span></td>
				<td><?php echo number_format($totalPriceInCart) ?></td>                
			</tr>                  

		</tbody></table>
		<div class="btn-ca">
		<a href="<?php echo $linkCategory?>" class="continue">&lt; Continue</a>
		<a href="javascript:submitForm('<?php echo $linkUpdate?>')" class="update">&lt; Update</a>
		<a href="javascript:submitForm('<?php echo $linkSubmitForm?>')" class="checkout">Check out &gt;</a>
		</div>
	</form>	
	<?php
		}else{
	    	echo "<h3>Your cart is empty</h3>";
	    }
	?>
</div>
<script type="text/javascript">
	$("input[type=number]").change(function(){
		$("a.checkout").attr("href","");
		$("a.checkout").click(function(){
			var confirmUpdate = confirm("Giỏ hàng của bạn đã thay đổi, bạn có muốn order ngay không?");
			if(confirmUpdate){
				$("a.checkout").attr("href","javascript:submitForm('<?php echo $linkSubmitForm?>')");
			}else{
				$("a.checkout").attr("href","javascript:submitForm('<?php echo $linkUpdate?>')");
			}
		})
	})
</script>

