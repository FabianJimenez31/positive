<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_add_serialforcefields extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20171123175305_add_serialforcefields.sql'));
	    }

	    public function down() 
			{
	    }

	}
