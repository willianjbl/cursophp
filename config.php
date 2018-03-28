<?php 

spl_autoload_register(function($class_name){
	
	$filename = str_replace("\\", "/", "classes" . DIRECTORY_SEPARATOR . $nome . ".php");

	if (file_exists(($filename))){
		require_once($filename);
	}
});

?>