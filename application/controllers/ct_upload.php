<?php

class Ct_upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
                date_default_timezone_set('Asia/Bangkok');
                $this->datetime = date('Y-m-d H:i:s');
                $this->load->model("member_model");
        }

        public function index()
        {
                $this->load->view('upload_form', array('error' => ' ' ));
        }

        public function do_upload()
        {
     
                $member_id = $this->input->post("member_id");
                
                $config['upload_path']          = './assets/upload/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 5000;
                $config['max_width']            = 2400;
                $config['max_height']           = 2400;

                $new_name = "PIC_0X00".$member_id."_".$_FILES["userfile"]['name'];
                $config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        echo "FAIL";
                }
                else
                {

                        $ar  = array(
                                "img_name" => $new_name ,
                                "date_modify" =>  $this->datetime
                                );
                        // print_r($new_name);
                        // print_r( $this->datetime);

                        
                        if ($this->member_model->update_img_name($ar,$member_id)) {
                               redirect("welcome/index");
                        }else{
                                echo "NO";
                        }
               }
        }
}
?>