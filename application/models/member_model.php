<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
   
    function getmember()
    {
    	$this->db->select('*')->from('member');
                // ->where("member_id" ,$member_id);
        $query = $this->db->get();
        return $query->result();
    }

    function edit_member($member_id)
    {
    	$this->db->select('*')->from('member')
    	->where("member_id" ,$member_id);
        $query = $this->db->get();
        return $query->result();
    }

    function edit_member_data($member_id,$data_edit)
    {
    	$this->db->where("member_id", $member_id)->update("member", $data_edit);
        return TRUE;
    }

    function add_member($data)
    {

    	$this->db->insert("member",$data);
    	return $this->db->insert_id();

    	
    }
    function delete_member($member_id)
    {

      $this->db->where("member_id", $member_id)->delete("member");
        return TRUE;  
    
    }   
    
     function update_img_name($ar,$member_id)
    {   
        // print_r($ar);
        // print_r($member_id);
      if($this->db->where('member_id', $member_id)->update('member', $ar)){
        return TRUE;
      }else{
        return FALSE;
      }
        

    }
    
}