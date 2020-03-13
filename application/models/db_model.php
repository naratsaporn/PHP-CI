<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Db_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAllJoin($tb, $select = NULL, $join = NULL, $where = NULL, $order_by = NULL, $limit = NULL, $join_type = NULL, $group_by = NULL, $having = NULL) {
        if (!is_null($select)) {
            $this->db->select($select);
        }

        if (!is_null($tb)) {
            $this->db->from($tb);
        }

        if (!is_null($join)) {
            if (!is_null($join_type)) {
                $t = 0;
                foreach ($join as $key => $value) {
                    if ($join_type[$t] != '') {
                        $this->db->join($key, $value, $join_type[$t]);
                    } else {
                        $this->db->join($key, $value);
                    }
                    $t++;
                }
            } else {
                foreach ($join as $key => $value) {
                    $this->db->join($key, $value);
                }
            }
        }

        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!is_null($order_by)) {
            $this->db->order_by($order_by);
        }

        if (!is_null($limit)) {
            if (is_array($limit)) {
                $this->db->limit($limit[0], $limit[1]);
            } else {
                $this->db->limit($limit);
            }
        }

        if (!is_null($group_by)) {
            $this->db->group_by($group_by);
        }
        if (!is_null($having)) {
            $this->db->having($having);
        }

        return $this->db->get();
    }

    function getData($select = NULL, $tb = NULL, $where = NULL, $order_by = NULL, $limit = NULL, $start = NULL) {
        if (!is_null($select)) {
            $this->db->select($select);
        }
        $this->db->from($tb);

        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!is_null($order_by)) {
            $this->db->order_by($order_by);
        }
        if (!is_null($limit)) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get();
    }

    function getQuery($query) {
        return $this->db->query($query);
    }

    function insert($tb, $data) {
        $this->db->insert($tb, $data);
        return $this->db->affected_rows();
    }

    // $where = array('m.id !=' => '12', 't.id <' => '0', 'status' => 'active'); or "m.id = '12' AND t.id < 1 OR status = 'active'";
    function update($tb, $data, $where /* = NULL */) {
        if (!is_null($where)) {
            $this->db->where($where);
        }

        $this->db->update($tb, $data);
        return $this->db->affected_rows();
    }

    // $where = array('m.id !=' => '12', 't.id <' => '0', 'status' => 'active'); or "m.id = '12' AND t.id < 1 OR status = 'active'";
    function delete($tb, $where = NULL) {
        if (!is_null($where)) {
            $this->db->where($where);
        }

        $this->db->delete($tb);
        return $this->db->affected_rows();
    }

    function getDom($tb, $field_id, $field_name, $where = NULL, $order_by = NULL, $blank = FALSE, $word = '') {
        $dom = array();
        $this->db->select($field_id . ", " . $field_name);

        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!is_null($order_by)) {
            $this->db->order_by($order_by);
        }

        $query = $this->db->get($tb);

        if ($blank == TRUE) {
            $dom[''] = $word;
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $dom[$data->{$field_id}] = $data->{$field_name};
            }
        }
        return $dom;
    }

    // $tb = 'lang';
    // $field_id = 'lang_id';
    // $id = 2;
    // $direction = 'up'; or 'down';
    // $where = array('active' => '1');
    function changeSequence($tb, $field_id, $id, $direction, $where = NULL) {
        if ($id == '' or $field_id == '') {
            return FALSE;
        }

        if (!is_null($where)) {
            $this->db->where($where);
        }
        $query = $this->getData($field_id . ', seq', $tb, array($field_id => $id));
        $data = $query->row();
        //print_array($data);

        if (is_null($data)) {
            return FALSE;
        }

        if ($direction == 'up') {
            if (!is_null($where)) {
                $this->db->where($where);
            }
            $query = $this->getData($field_id . ', seq', $tb, array('seq <' => $data->seq), 'seq DESC');
            //echo $this->db->last_query().'<br/>';
            $row_down = $query->row();
            //print_array($row_down);

            if (!is_null($where)) {
                $this->db->where($where);
            }
            $this->update($tb, array('seq' => $row_down->seq), array($field_id => $data->{$field_id}));

            if (!is_null($where)) {
                $this->db->where($where);
            }
            $this->update($tb, array('seq' => $data->seq), array($field_id => $row_down->{$field_id}));

            return $this->db->affected_rows();
        } elseif ($direction == 'down') {
            if (!is_null($where)) {
                $this->db->where($where);
            }
            $query = $this->getData($field_id . ', seq', $tb, array('seq >' => $data->seq), 'seq ASC');
            //echo $this->db->last_query().'<br/>';
            $row_up = $query->row();
            //print_array($row_up);

            if (!is_null($where)) {
                $this->db->where($where);
            }
            $this->update($tb, array('seq' => $row_up->seq), array($field_id => $data->{$field_id}));
            //echo $this->db->last_query().'<br/>';

            if (!is_null($where)) {
                $this->db->where($where);
            }
            $this->update($tb, array('seq' => $data->seq), array($field_id => $row_up->{$field_id}));
            //echo $this->db->last_query().'<br/>';

            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    function getMinMax($tb, $where = NULL) {
        if (!is_null($where)) {
            $this->db->where($where);
        }
        $this->db->where('seq >', 0);
        $this->db->select('MIN(seq) AS "min_seq", MAX(seq) AS "max_seq"');
        $query = $this->db->get($tb, 1);
        return $query->row();
    }

    // $tb = 'member';
    // $where = array('m.id !=' => '12', 't.id <' => '0', 'status' => 'active'); or "m.id = '12' AND t.id < 1 OR status = 'active'";
    function getSequence($tb, $where = NULL) {
        if (!is_null($where)) {
            $this->db->where($where);
        }

        $this->db->select_max("seq", "seq");
        $query = $this->db->get($tb, 1);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if ($row->seq != '' and $row->seq != NULL) {
                return (int) $row->seq + 1;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

}
?>