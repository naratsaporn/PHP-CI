<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

			function __construct() {
        		  parent::__construct();
       			  date_default_timezone_set('Asia/Bangkok');
      			  $this->datetime = date('Y-m-d H:i:s');
              $this->load->helper(array('form', 'url'));
      			  $this->load->model('member_model');
       			
    		}


	public function index()
	{
		 $data["member_list"] = $this->member_model->getmember();
		   $this->load->view('index',$data);
       // $this->load->view('data_table');
       // $this->load->view('upload_form', array('error' => ' ' ));
       
	}

}
