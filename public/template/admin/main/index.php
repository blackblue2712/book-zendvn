	<?php 
	// echo "<pre>";
	// print_r($this);
	// echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en" >

<head>
	<?php echo $this->_metaHTTP; echo $this->_metaName ?>
	<title><?php echo $this->_title; ?></title>
	<?php echo $this->_cssFiles; ?>
	<?php echo $this->_jsFiles; ?>

</head>
<body>

	<?php include_once "html/header.php"; ?>
    <div id="content-box">
    	<?php require_once MODULE_PATH . $this->moduleName . DS . "views" . DS . $this->_fileView . ".php" ?>
	<?php include_once "html/footer.php"; ?>
       
	
