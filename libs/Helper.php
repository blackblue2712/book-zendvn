<?php
	class Helper{

		//CREATE BUTTON ICON
		public static function cmsButton($name, $id, $link = "#", $icon, $type = "new"){
			$xhtml  = '<li class="button" id="'.$id.'">';
			if($type == "new"){
				$xhtml .= '<a class="modal" href="'.$link.'"><span class="'.$icon.'"></span>'.$name.'</a>';
			}else if($type == "submit"){
				$xhtml .= '<a class="modal" href="javascript:submitForm(\''.$link.'\')"><span class="'.$icon.'"></span>'.$name.'</a>';
			}
            
            $xhtml .= '</li>';
            return $xhtml;
		}

		//FORMAT DATE
		public static function formatDate($format, $value){
			$result = "";
			if(!empty($value) && $value != "0000-00-00"){
				$result = date($format, strtotime($value));
			}
			return $result;
		}

		//Create STATUS
		public static function cmsStatus($statusValue, $link = null, $id = null){
			$strStatus = ($statusValue == 0)? "unpublish" : "publish";
			return '<a class="jgrid" id="status-'.$id.'" href="javascript:ajaxChangeStatus(\''.$link.'\');">
                    	<span class="state '.$strStatus.'">
						</span>
					</a>';
		}

		//Create GROUP_ACP STATUS
		public static function cmsACP($acpValue, $link = null, $id = null){
			$strACP = ($acpValue == 0)? "unpublish" : "publish";
			return '<a class="jgrid" id="group-acp-'.$id.'" href="javascript:ajaxACP(\''.$link.'\');">
                    	<span class="state '.$strACP.'">
						</span>
					</a>';
		}

		//Create SPECIAL STATUS
		public static function cmsSpecial($specialV, $link = null, $id = null){
			$strS = ($specialV == 0)? "unpublish" : "publish";
			return '<a class="jgrid" id="special-'.$id.'" href="javascript:ajaxSpecial(\''.$link.'\');">
                    	<span class="state '.$strS.'">
						</span>
					</a>';
		}

		//CREATE LINK SORT
		public static function cmsLinkSort($name, $column, $columnPost, $orderPost){
			$img 	= "";
			$order 	= ($orderPost == "desc") ? "asc" : "desc";
			if($column == $columnPost){
				$img = '<img src="'.TEMPLATE_URL.'admin/main/images/admin/sort_'.$orderPost.'.png">';
			}
			$xhtml = '<a href="javascript:sortList(\''.$column.'\', \''.$order.'\')">'.$name.$img.'</a>';
			return $xhtml;
		}

		//CREATE SELECT SORT
		public static function cmsSelectbox($name, $class, $arrValue, $keySelected = 0){
			$xhtml = ' <select name="'.$name.'" class="'.$class.'" onchange="#">';
			if(!empty($arrValue)){
				foreach ($arrValue as $key => $value) {
					if($key == $keySelected){
						$xhtml .= '<option selected=selected value="'.$key.'">'.$value.'</option>';
					}
					else $xhtml .= '<option value="'.$key.'">'.$value.'</option>';	
				}	
			}
			$xhtml .= '</select>';
			return $xhtml;
		}

		//CREATE MESSAGE
		public static function cmsMessage($message){
			$xhtml 	= "";
			if(!empty($message)){
				$xhtml .= '<dl id="system-message"
								<dt class="'.$message["class"].'">'.$message["class"].'</dt>
								<dd class="'.$message["class"].' message">
									<ul>
										<li>'.$message["content"].'</li>
									</ul>
								</dd>
							</dl>';
			}
			return $xhtml;	
		}

		//CREATE INPUT
		public static function cmsInput($type, $name = null, $id = null, $value = null, $class = null, $size = null){
			if($size != null) $strSize ="size='$size'";
			else $strSize = "";
			if($class != null) $strClass ="class='$class'";
			else $strClass = "";
			
			return $xhtml = '<input type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" '.$strSize.$strClass.'>';
		}

		//CREATE ROW - ADMIN
		public static function cmsRowForm($labelName, $content, $require = false){
			$strRequire = '';
			if($require) $strRequire = '<span class="star">&nbsp;*</span>';
				$xhtml = '<li><label>'.$labelName.$strRequire.'</label>'.$content.'</li>';
			return $xhtml;
		}

		//CREATE ROW - PUBLIC DEFAULT
		public static function cmsRow($labelName, $content, $submit = false){
			if($submit){
				$xhtml = '<div class="form_row">'.$content.'</div> ';
			}else{
				$xhtml = '<div class="form_row">
       					<label class="contact"><strong>'.$labelName.':</strong></label>'.$content.'</div> ';	
			}
			
			return $xhtml;
		}

		//Create Image
		public static function cmsImg($folder, $frefix = WIDTH_RESIZE_98 . "x" . HEIGHT_RESIZE_150 . "-", $picutreName, $attr){

			$class 	= isset($attr["class"]) ? 'class="'.$attr["class"].'"' : "";
			$width 	= isset($attr["width"]) ? 'width="'.$attr["width"].'"' : "";
			$height = isset($attr["height"]) ? 'height="'.$attr["height"].'"' : "";

			if(file_exists(UPLOAD_PATH . $folder . DS . $frefix .$picutreName)){
                $picture    = '<img '.$class.$width.$height.' src ="' . UPLOAD_URL . $folder . DS . $frefix .$picutreName . '">';
            }else{
                $picture    = '<img '.$class.$width.$height.' src ="' .  UPLOAD_URL .$folder . DS . $frefix ."default.png" . '">';
            }

            return $picture;
		}

		public static function sliceStr($str, $length = 2){
			$result = "";
			$str 	= trim($str);
	        if(strlen($str) > 0){
	            $arrStr = explode(" ",$str);
	            if(count($arrStr) > $length){
	            	$flag = false; 					//Kiểm tra xem có từ nào có length bằng 1 không (quá ngắn)
	                for($i=0; $i<$length; $i++){
	                	if(strlen($arrStr[$i]) == 1) $flag = true;
	                    $result .= $arrStr[$i] . " ";
	            	}
	            	//Lấy thêm 1 từ nếu quá ít, không lấy khi từ tiếp theo chỉ có length = 1
	            	if($flag || strlen($result) < 12 && strlen($arrStr[$length]) > 1) $result .=  $arrStr[$length];
	            $result .= "...";
	            }else{
	            	$result = $str;
	            }
	        }
	        return trim($result);
    	}




	}