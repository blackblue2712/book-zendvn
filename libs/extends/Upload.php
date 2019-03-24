<?php
	require_once SCRIPTS_PATH . "PhpThumb/ThumbLib.inc.php";
	class Upload{
		public function uploadFile($fileObj, $folderUpload, $width = 60, $height = 90, $option = null){
			if($option == null){
				if($fileObj["tmp_name"] != null && $fileObj["error"] == 0){
					$newName 		= $this->randomString();
					$destionation 	= $this->setFolderUpload($folderUpload, $newName, $fileObj["name"]);

					//upload start
					@copy($fileObj["tmp_name"], $destionation);

					//réize
					$thumb = PhpThumbFactory::create($destionation);
					$thumb->adaptiveResize($width, $height);
					$newNameResize = $this->setFolderUpload($folderUpload, $width."x".$height."-".$newName, $fileObj["name"]);
					$thumb->save($newNameResize);

					// return name file
					return $newName.".".pathinfo($fileObj["name"], PATHINFO_EXTENSION);
				}
			}
		}
		public function removeFile($folderUpload, $filename, $width = 60, $height = 90){
			$filenameO 	=  UPLOAD_PATH . $folderUpload . "/" . $filename;
			$filenameRS =  UPLOAD_PATH . $folderUpload . "/" . $width."x".$height."-".$filename;
			@unlink($filenameO);
			@unlink($filenameRS);
		}

		private function setFolderUpload($folderName, $newName, $filename){
			return UPLOAD_PATH . $folderName . "/" . $newName . $this->getExtensionFile($filename);
		}
		private function getExtensionFile($filename){
			return "." . pathinfo($filename, PATHINFO_EXTENSION);
		}
		private function randomString($length = 5){
			$arrCharacter 	= array_merge(range("A", "Z"), range('a', 'z'), range(0, 9));
			$str 			= implode("", $arrCharacter);
			$strRandom 		= str_shuffle($str);
			$result = substr($strRandom, 0, $length);
			return $result;
		}

	}