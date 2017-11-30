<?php
function is_on_demo_host()
{
	if ( isset($_SERVER['CI_DEMO']))
	{
		return $_SERVER['CI_DEMO'];
	}
	
	return isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] == 'demo039948827merc.skyone.com.co' || $_SERVER['HTTP_HOST'] == 'demo039948827mercdev.skyone.com.co');
}
?>
