<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_osTickets extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20170928121304_osTickets.sql'));
	    }

	    public function down() 
			{
	    }

	}
