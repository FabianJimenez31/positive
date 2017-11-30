<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_add_osticketsItemFields extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20170925222656_add_osticketsItemFields.sql'));
	    }

	    public function down() 
			{
	    }

	}
