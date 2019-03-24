<?php
	$xhtml = ''; 
	if(!empty($this->Items)){
		$tableHeader = '<tr class="cart_title"><td>Item pic</td><td>Book name</td><td>Unit price</td><td>Qty</td><td>Total</td></tr>';
		foreach($this->Items as $key => $value){
			
			$cartId			= $value['id'];
			$date			= date("H:i d/m/Y", strtotime($value['date']));
			$status			= ($value['status'] == 1)? "Đã phê duyệt" : "Đang chờ phê duyệt";
			$arrBookID		= json_decode($value['books']);
			$arrPrice		= json_decode($value['prices']);
			$arrName		= json_decode($value['names']);
			$arrQuantity	= json_decode($value['quantities']);
			$arrPicture		= json_decode($value['pictures']);
			$tableContent	= '';
			$totalPrice		= 0;
			
			foreach ($arrBookID as $keyB => $valueB){
				
            	$picture = Helper::cmsImg("book", FRE_FIX_98x150, $arrPicture[$keyB], array("class" => "thumb", "width" => 60, "height" => 90));

				$linkDetail		= URL::createLink('default', 'book', 'detail', array('book_id' => $valueB));
				$picturePath	= UPLOAD_PATH . 'book' . DS . '98x150-' . $arrPicture[$keyB];
				
				$totalPrice		+= $arrQuantity[$keyB] * $arrPrice[$keyB];
				$tableContent .= '<tr>
								<td><a href="'.$linkDetail.'">'.$picture.'</a></td>
								<td class="name">'.$arrName[$keyB].'</td>
								<td>'.number_format($arrPrice[$keyB]).'</td>
								<td>'.$arrQuantity[$keyB].'</td>
								<td>'.number_format($arrQuantity[$keyB] * $arrPrice[$keyB]).'</td>
							</tr>';
			}
			
			
			
			$xhtml .= '<div class="history-cart">
							<h3>Mã đơn hàng:'.$cartId.' - Thời gian: '.$date.'</h3><h5>'.$status.'</h5>
							<table class="cart_table">
								<tbody>
									'.$tableHeader.$tableContent.'
									<tr>
										<td colspan="4" class="cart_total"><span class="red">TOTAL:</span></td>
										<td>'.number_format($totalPrice).'</td>
									</tr>
								</tbody>
							</table>
						</div>';
		}
	}else{
		$xhtml = '<h3>Chưa có đơn hàng nào!</h3>';
	}

	$paginationHTML = $this->pagination->showPagination(URL::createLink("admin", "category", "index"));
?>

<!-- TITLE -->
<div class="title">
	<span class="title_icon"><img src="<?php echo $imgURL;?>/bullet1.gif"></span>History
</div>

<!-- LIST BOOKS -->
<div class="feat_prod_box_details">
	<?php
		echo $xhtml;
		echo $paginationHTML;
	?>
	<form name="adminForm" id="adminForm" action="#" method="post">
		<input type="hidden" name="filter_page" value="0">	
	</form>

</div>