<?php
	$cart = Session::get("cart");

	$totalItems 	= 0;
	$totalPrices 	= 0;

	if(!empty($cart)){
		$totalItems 	= array_sum($cart["quantity"]);
		$totalPrices 	= array_sum($cart["price"]);
	}
	$strItem 	= ($totalItems > 1)? "items":"item";

	$linkCart 	= URL::createLink("default", "user", "cart");
?>

<div class="cart">
	<div class="title">
		<span class="title_icon">
			<img src="<?php echo $imgURL ?>/cart.gif"/>
		</span>My cart
	</div>
	<div class="home_cart_content">
		<?php echo $totalItems. " x " . $strItem ?>  | <span class="red">TOTAL: <?php echo number_format($totalPrices); ?></span>
		</div>
	<a href="<?php echo $linkCart?>" class="view_cart">View cart</a>
</div>