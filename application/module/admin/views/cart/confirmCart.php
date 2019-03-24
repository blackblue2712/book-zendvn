<?php 
 
    include_once (MODULE_PATH . "admin/views/toolbar.php");
    include_once "submenu/index.php";
?>
      

   <?php
        $column          = isset($this->arrParams["filter_column"]) ? $this->arrParams["filter_column"] : "";
        $column_dir      = isset($this->arrParams["filter_column_dir"]) ? $this->arrParams["filter_column_dir"] : "";
        $lbName          = Helper::cmsLinkSort("Name", "names", $column, $column_dir);
        $lbPicture       = Helper::cmsLinkSort("Picture", "pictures", $column, $column_dir);
        $lbStatus        = Helper::cmsLinkSort("Status", "status", $column, $column_dir);

        $lblQuantites    = Helper::cmsLinkSort('Quantites', 'quantities', $column, $column_dir);
        $lblPrices       = Helper::cmsLinkSort('Prices', 'prices', $column, $column_dir);
        $lblDate         = Helper::cmsLinkSort('Date', 'date', $column, $column_dir);
        $lblID           = Helper::cmsLinkSort('ID', 'id', $column, $column_dir);

        //SELECT STATUS SORT
        $selectedStatus         = isset($this->arrParams["filter_state"])? $this->arrParams["filter_state"] : 2;  
        $selectboxStatus        = Helper::cmsSelectbox("filter_state", "inputbox", array(2 => "- Select Status -", 1 => "Publish", 0 => "Unpublish"), $selectedStatus);    

        //PAGINATION
        $paginationHTML = $this->pagination->showPagination(URL::createLink("admin", "category", "index"));

        //MESSAGE
        $message = isset($_SESSION["message"]) ? $_SESSION["message"] : "";
        $strMessage = "";
        if(!empty($message)){
            $strMessage .= Helper::cmsMessage($_SESSION["message"]); 
        }
         Session::delete("message");
   ?>
    
    <div id="system-message-container">
        <?php echo $strMessage ?>
    </div>
    
	<div id="element-box">
		<div class="m">
			<form action="#" method="post" name="adminForm" id="adminForm">
            	<!-- FILTER -->
                <fieldset id="filter-bar">
                    <div class="filter-search fltlft">
                        <label class="filter-search-lbl" for="filter_search">Filter:</label>
                        <input type="text" name="filter_search" id="filter_search" value="<?php echo isset($this->arrParams['filter_search']) ? $this->arrParams['filter_search'] : ""; ?>">
                        <button type="submit" name="submit-keyword">Search</button>
                        <button type="button" name="clear-keyword">Clear</button>
                    </div>
                    <div class="filter-select fltrt">
                        <?php echo $selectboxStatus ?>
                    </div>
                </fieldset>
				<div class="clr"> </div>

                <table class="adminlist" id="modules-mgr">
                	<!-- HEADER TABLE -->
                    <thead>
                        <tr>
                            <th width="1%">
                                <input type="checkbox" name="checkall-toggle" value="" onclick="javascipt:void(0)">
                            </th>
                            <th class="title"><?php echo $lbName ?></th>
                            <th width="20%"><?php echo $lbPicture ?></th>
                            <th width="10%"><?php echo $lbStatus ?></th>
                            
                            <th width="15%"><?php echo $lblQuantites;?></th>
                            <th width="15%"><?php echo $lblPrices;?></th>
                            <th width="10%"><?php echo $lblDate;?></th>
                            <th width="10%" class="nowrap"><?php echo $lblID;?></th>
                        </tr>
                    </thead>
                    <!-- FOOTER TABLE -->
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <!-- PAGINATION -->
                                <div class="container">
                                    <div class="pagination">
                                       <?php echo $paginationHTML ?>
                                    </div>
                                </div>				
                            </td>
                        </tr>
                    </tfoot>
                    <!-- BODY TABLE -->
					<tbody>
                        <?php
                            if(!empty($this->_listItem)){
                                $i = 0;
                                foreach ($this->_listItem as $item) {
                                    $arrPictures = json_decode($item["pictures"]);

                                    $quantities     = "";
                                    $picture        = "";
                                    $prices         = "";
                                    $i_tmp = 0;
                                    foreach ($arrPictures as $key => $pic){
                                        //quantities
                                        $arrQuantities   = json_decode($item["quantities"]);
                                        //prices
                                        $arrPrices       = json_decode($item["prices"]);

                                        //
                                        if($i_tmp % 2 == 0 && $i_tmp > 0) $picture .= "<br>";

                                        if($i_tmp % 2 == 1){
                                            $quantities .= $arrQuantities[$key] . "<br>";
                                            $prices     .= number_format($arrPrices[$key]) . "<br>";
                                        }else{ 
                                            $quantities .= $arrQuantities[$key] . " | ";
                                            $prices     .= number_format($arrPrices[$key]) . " | ";
                                        }

                                        //title and picture 
                                        $names = json_decode($item["names"]);
                                        if(file_exists(UPLOAD_PATH . "book/". WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-" .$pic)){
                                            $picture    .= '<img title="'.$names[$key].'" width="50" height=75 src ="' . UPLOAD_URL . "book/". WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-" .$pic . '">';
                                             $picture   .= '&nbsp';
                                        }else{
                                            $picture    .= '<img title="'.$names[$key].'" width="50" height=75 src ="' .  UPLOAD_URL . "book/". WIDTH_RESIZE . "x" . HEIGHT_RESIZE . "-" ."default.png" . '">';
                                        }

                                        
                                      

                                        $i_tmp ++;
                                    }
                                    $quantities     = substr($quantities, 0, strlen($quantities)-2);
                                    $prices         = substr($prices, 0, strlen($prices)-2);

                                    $row        = ($i % 2 == 0)? "row0"  : "row1";
                                    $id         = $item["id"];
                                    $name       = $item["username"];

                                    
                                    $status     = Helper::cmsStatus($item["status"], URL::createLink("admin", "cart", "ajaxStatus", array("status" => $item["status"], "id" => $id)), $id);
                                    
                                    $date       =  Helper::formatDate("d-m-Y", $item["date"]);
                                    $ckb        = ' <input type="checkbox" id="cb0" name="cid[]" value="'.$id.'">'; 

                                    $linkEdit   = URL::createLink("admin", "cart", "form", array("id" => $id));
                        ?>
                        <tr class="<?php echo $row?>">
                            <td class="center">
                               <?php echo $ckb?>
                            </td>
                            <td><a href="<?php echo $linkEdit?>"><?php echo $name?></a></td>
                            <td class="center"><?php echo $picture?></td>
                            <td class="center"><?php echo $status?></td>
                            <td class="order"><?php echo $quantities?></td>
                            <td class="center"><?php echo $prices ?></td>
                            <td class="center"><?php echo $date ?></td>
                            <td class="center"><?php echo $id ?></td>
                        </tr>	
                        <?php
                            $i++;
                            }
                        }
                        ?>
					</tbody>
				</table>

                <div>
                    <input type="hidden" name="filter_column" value="date">
                    <input type="hidden" name="filter_column_dir" value="ASC">
                    <input type="hidden" name="filter_page" value="1">
            </form>

			<div class="clr"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
   
    
</script>

