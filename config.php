<?php 
//carrega automaticamente as classes dentro da pasta class
spl_autoload_register(function($class_name){
	
	$filename = "class".DIRECTORY_SEPARATOR.$class_name.".php";
	//se a pasta existir, exija o arquivo....
	if (file_exists($filename)) {
		require_once($filename);
	}
});

?>