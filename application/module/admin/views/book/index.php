 
   <?php
        include_once (MODULE_PATH . "admin/views/toolbar.php");
        include_once "submenu/index.php";
    ?>  
   <?php
        $column         = isset($this->arrParams["filter_column"]) ? $this->arrParams["filter_column"] : "";
        $column_dir     = isset($this->arrParams["filter_column_dir"]) ? $this->arrParams["filter_column_dir"] : "";

        $lblName        = Helper::cmsLinkSort("Name", "name", $column, $column_dir);
        $lblPicture     = Helper::cmsLinkSort("Picture", "picture", $column, $column_dir);
        $lblPrice       = Helper::cmsLinkSort("Price", "price", $column, $column_dir);
        $lblSpecial     = Helper::cmsLinkSort("Special", "special", $column, $column_dir);
        $lblSaleOff     = Helper::cmsLinkSort("Sale Off", "sale_off", $column, $column_dir);
        $lblStatus      = Helper::cmsLinkSort("Status", "status", $column, $column_dir);
        $lblCategory    = Helper::cmsLinkSort('Category', 'category_id', $column, $column_dir);
        $lblOrdering    = Helper::cmsLinkSort('Ordering', 'ordering', $column, $column_dir);
        $lblCreated     = Helper::cmsLinkSort('Created', 'created', $column, $column_dir);
        $lblCreatedBy   = Helper::cmsLinkSort('Created By', 'created_by', $column, $column_dir);
        $lblModified    = Helper::cmsLinkSort('Modified', 'modified', $column, $column_dir);
        $lblModifiedBy  = Helper::cmsLinkSort('Modified By', 'modified_by', $column, $column_dir);
        $lblID          = Helper::cmsLinkSort('ID', 'id', $column, $column_dir);

        //SELECT STATUS SORT
        $selectedStatus         = isset($this->arrParams["filter_state"])? $this->arrParams["filter_state"] : 2;  
        $selectboxStatus        = Helper::cmsSelectbox("filter_state", "inputbox", array(2 => "- Select Status -", 1 => "Publish", 0 => "Unpublish"), $selectedStatus);

         //SELECT SPECIAL SORT
        $selectedSpecial         = isset($this->arrParams["filter_special"])? $this->arrParams["filter_special"] : 2;  
        $selectboxSpecial        = Helper::cmsSelectbox("filter_special", "inputbox", array(2 => "- Select Special -", 1 => "Yes", 0 => "No"), $selectedSpecial);

         //SELECT CATEGORY SORT
        $selectedCategory    = isset($this->arrParams["filter_category"])? $this->arrParams["filter_category"] : "default";  
        $selectboxCategory   = Helper::cmsSelectbox("filter_category", "inputbox", $this->_slbCategory , $selectedCategory);    

        //PAGINATION
        $paginationHTML = $this->pagination->showPagination(URL::createLink("admin", "book", "index"));

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
                        <?php echo $selectboxStatus.$selectboxSpecial.$selectboxCategory ?>
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
                            <th class="title"><?php echo $lblName ?></th>
                            <th width="8%"><?php echo $lblPicture ?></th>
                            <th width="8%"><?php echo $lblPrice ?></th>
                            <th width="6%"><?php echo $lblSaleOff ?></th>
                            <th width="10%"><?php echo $lblCategory;?></th>
                            <th width="4%"><?php echo $lblStatus;?></th>
                            <th width="4%"><?php echo $lblSpecial;?></th>
                            <th width="6%"><?php echo $lblOrdering;?></th>
                            <th width="7%"><?php echo $lblCreated;?></th>
                            <th width="8%"><?php echo $lblCreatedBy;?></th>
                            <th width="7%"><?php echo $lblModified;?></th>
                            <th width="8%"><?php echo $lblModifiedBy;?></th>
                            <th width="1%" class="nowrap"><?php echo $lblID;?></th>
                        </tr>
                    </thead>
                    <!-- FOOTER TABLE -->
                    <tfoot>
                        <tr>
                            <td colspan="12">
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
                                    $row        = ($i % 2 == 0)? "row0"  : "row1";
                                    $id         = $item["id"];
                                    $name       = $item["name"];

                                    if(file_exists(UPLOAD_PATH . "book/". WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-" .$item["picture"])){
                                        $picture    = '<img src ="' . UPLOAD_URL . "book/". WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-" .$item["picture"] . '">';
                                    }else{
                                        $picture    = '<img style="width:98px;height:150px" src ="' .  UPLOAD_URL . "book/". WIDTH_RESIZE . "x" . HEIGHT_RESIZE . "-" ."default.png" . '">';
                                    }

                                    $price      = $item["price"];
                                    $sale_off   = $item["sale_off"];
                                    $category   = $item["category_name"];
                                    $order      = '<input type="text" name="order['.$id.']" size="5" value="'.$item["ordering"].'" class="text-area-order">';
                                    $status     = Helper::cmsStatus($item["status"], URL::createLink("admin", "book", "ajaxStatus", array("status" => $item["status"], "id" => $id)), $id);
                                    $special     = Helper::cmsSpecial($item["special"], URL::createLink("admin", "book", "ajaxSpecial", array("special" => $item["special"], "id" => $id)), $id);
                                   
                                    $created    = Helper::formatDate("d-m-Y", $item["created"]);
                                    $created_by = $item["created_by"];
                                    $modified   = Helper::formatDate("d-m-Y", $item["modified"]);
                                    $modified_by= $item["modified_by"];
                                    $ckb        = ' <input type="checkbox" id="cb0" name="cid[]" value="'.$id.'">'; 

                                    $linkEdit   = URL::createLink("admin", "book", "form", array("id" => $id));
                        ?>
                        <tr class="<?php echo $row?>">
                            <td class="center">
                               <?php echo $ckb?>
                            </td>
                            <td><a href="<?php echo $linkEdit?>"><?php echo $name?></a></td>
                            <td class="center"><?php echo $picture?></td>
                            <td class="center"><?php echo $price?></td>
                            <td class="center"><?php echo $sale_off?></td>
                            <td class="center"><?php echo $category?></td>
                            <td class="center"><?php echo $status?></td>
                            <td class="center"><?php echo $special?></td>
                            <td class="order"><?php echo $order?></td>
                            <td class="center"><?php echo $created ?></td>
                            <td class="center"><?php echo $created_by ?></td>
                            <td class="center"><?php echo $modified ?></td>
                            <td class="center"><?php echo $modified_by ?></td>
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
                    <input type="hidden" name="filter_column" value="id">
                    <input type="hidden" name="filter_column_dir" value="desc">
                    <input type="hidden" name="filter_page" value="1">
            </form>

            <div class="clr"></div>
        </div>
    </div>
</div>



