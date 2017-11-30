<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_add_config_fields extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20170924222656_add_config_fields.sql'));
	    }

	    public function down() 
			{
	    }

	}
