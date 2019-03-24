<?php
	class XML{

		public static function getContentXML($file, $option = null){
			if($option == null){
				$filePath 	= UPLOAD_PATH . "xml" . DS . $file;
				$xml 		= simplexml_load_file($filePath);
				return $xml;
			}
		}

		public static function createXML($arrData, $fileName, $option = null){
			if($option == null){
				$strXML  = '<?xml version="1.0" encoding="UTF-8"?>';
				$strXML .= '<book_store>';
				foreach ($arrData as $key => $value) {
					$strXML .= '<category>
								<id>'.$value["id"].'</id>
								<name>'.$value["name"].'</name>
								<picture>'.$value["picture"].'</picture>
							</category>';
				}//end foreac
				echo $strXML 	.= '</book_store>';
				$filePath 	 = UPLOAD_PATH . "xml" . DS . $fileName;
				file_put_contents($filePath, $strXML);
			}//end if
		}



	}