<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ct_change extends CI_Controller {

			function __construct() {
        		  parent::__construct();
       			  date_default_timezone_set('Asia/Bangkok');
      			 
    		}


	public function index()
	{
		 
		   $this->load->view('change');
       
       
	}

}
