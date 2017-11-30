<?php
function is_phppos_update_available()
{
/*Modificar para cambiar el servidor de actualizaciones, regresa timestamp de la ultima versión*/
/*
	$url = (!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'http://mercurioupdatesdev.skyone.com.co/current_version.php?build_timestamp=1': 'http://mercurioupdates.skyone.com.co/current_version.php?build_timestamp=1';
	
   $ch = curl_init($url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  	$current_build = curl_exec($ch);
  	curl_close($ch);

	return ($current_build != '' && (BUILD_TIMESTAMP != $current_build));

*/
	return false;
}
?>
