<?php

require_once ("Secure_area.php");
require_once ("interfaces/Idata_controller.php");

class osTickets extends Secure_area {

    function __construct() {

        parent::__construct('ostickets');
  			$this->lang->load('module');	
			$this->load->helper('osticket');	
		  
    }

    function index() {

        $this->check_action_permission('check_update');
		$data['search']='';
		$data['controller_name']=strtolower(get_class());
        $this->load->view('osticket/manage', $data);
    }

    function search() {
 		//allow parallel searchs to improve performance.
 		session_write_close();
		 
        $this->check_action_permission('check_update');
		$data['controller_name']=strtolower(get_class());
        $search = $this->input->post('search');
        $data['search']=$search;
        $this->load->view('osticket/manage', $data);
    }

   



}

?>
