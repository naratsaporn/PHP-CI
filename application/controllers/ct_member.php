<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Ct_member extends CI_Controller {

 function __construct() {
  parent::__construct();
  date_default_timezone_set('Asia/Bangkok');
  $this->datetime = date('Y-m-d H:i:s');
  $this->load->model('member_model');
  $this->load->model('db_model');

}


public function edit_member()
{

  $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $data = parse_url($url);
  $member_id = basename($data['path'], '.html');

  $this->load->view("edit_view");		
}

public function edit()
{
  $member_id = $this->input->post("member_id");

  $data_member =   $this->member_model->edit_member($member_id);
  echo json_encode($data_member);

}

public function edit_member_data()
{

  $member_id = $this->input->post("member_id");
  $username = $this->input->post("username");
  $password = $this->input->post("password");

  $data_edit = array(
    "date_modify" => $this->datetime,
    "username" => $username,
    "password" => $password
    );


  $sddas = $this->member_model->edit_member_data($member_id,$data_edit);

}

public function insert_member_data()
{
  $username = $this->input->post("username");
  $password = $this->input->post("password");
  
  $data_add = array(

    "username" => $username,
    "password" => $password,
    "img_name" => 0,
    "date_create" => $this->datetime,
    "date_modify" => $this->datetime

    );

  $data_id = $this->member_model->add_member($data_add);

  echo $data_id;
}

function delete_member()
{
  $member_id = $this->input->post("member_id");
  $this->member_model->delete_member($member_id);
  //echo $member_id;
}


 function data_table() {

        if ($this->input->is_ajax_request() AND $this->input->server('REQUEST_METHOD') == 'POST') {

            // Field Parameter
            $tb = 'member m'; 
            $column_index = 'm.member_id';
            $column_select = '*';

            $join = array();

            $init_where = 'm.member_id != 0';

            $column_search = array('m.username', 'm.password');
            $column_search_num = count($column_search);

            $column_sort = array('m.member_id');

            $join_type = array();
            // Filter all column (WHERE)
            $where = $init_where;
            if ($this->input->post('sSearch') !== FALSE and $this->input->post('sSearch') != '') {
                $search = $this->input->post('sSearch');
                $where .= ((!is_null($where) and $where != '') ? ' AND (' : '(');
                for ($c = 0; $c < $column_search_num; $c++) {
                    if ($c == 0) {
                        $where .= $column_search[$c] . ' LIKE "%' . $this->db->escape_like_str($search) . '%"';
                    } else {
                        $where .= ' OR ' . $column_search[$c] . ' LIKE "%' . $this->db->escape_like_str($search) . '%"';
                    }
                }
                $where .= ')';
            }

            // Filter each column (WHERE)
            for ($c = 0; $c < $column_search_num; $c++) {
                if ($this->input->post('bSearchable_' . $c) !== FALSE and $this->input->post('sSearch_' . $c) !== FALSE and $this->input->post('sSearch_' . $c) != '') {
                    ${'search_' . $c} = $this->input->post('sSearch_' . $c);
                    $where .= ' AND ' . $column_search[$c] . ' LIKE "%' . $this->db->escape_like_str(${'search_' . $c}) . '%"';
                }
            }

            // Order By
            $order_by = NULL;
            if ($this->input->post('iSortCol_0') !== FALSE) {
                $iSortingCols = (int) $this->input->post('iSortingCols');
                for ($s = 0; $s < $iSortingCols; $s++) {
                    if ($s == 0) {
                        $order_by .= $column_sort[$this->input->post('iSortCol_' . $s)] . ' ' . strtoupper($this->input->post('sSortDir_' . $s));
                    } else {
                        $order_by .= ', ' . $column_sort[$this->input->post('iSortCol_' . $s)] . ' ' . strtoupper($this->input->post('sSortDir_' . $s));
                    }
                }
            }

            // Limit
            if ($this->input->post('iDisplayLength') != -1) {
                $limit = array($this->input->post('iDisplayLength'), $this->input->post('iDisplayStart'));
            } else {
                $limit = NULL;
            }

            // iTotalRecords
            $query_all_row = $this->db_model->getAllJoin($tb, $column_index, NULL, $init_where, NULL, NULL, NULL);
            $all_row = $query_all_row->num_rows();

            // Filter Data
            $this->db->select('SQL_CALC_FOUND_ROWS ' . $column_select, FALSE);
            $member_query = $this->db_model->getAllJoin($tb, NULL, NULL, $where, $order_by, $limit, NULL);

            // iTotalDisplayRecords
            $query_found_row = $this->db_model->getQuery('SELECT FOUND_ROWS() AS "found_row"');
            $found_row = $query_found_row->row()->found_row;

            // Output
            $data = array(
                'sEcho' => (int) $this->input->post('sEcho'),
                'iTotalRecords' => $all_row,
                'iTotalDisplayRecords' => $found_row,
                //'query' => $this->db->last_query(),
                'aaData' => array()
            );
            if ($member_query->num_rows() > 0) {
                $count = 0;
                foreach ($member_query->result() as $data_member) {
                   
                    $count = $count + 1;
                    $row = array(
                        '0' => "<center>" . $count . "</center>",
                        '1' => $data_member->username,
                        '2' => $data_member->password,
                        '3' => "",
                        '4' => ""
                    );
                    $data['aaData'][] = $row;
                }
            }
            echo $this->input->get('jsoncallback') . '(' . json_encode($data) . ')';
        } else {
            exit();
        }
    }


}
