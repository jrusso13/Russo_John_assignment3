<?php
class display_model extends CI_Model{

    function search($limit, $offset, $sort_by, $sort_order){

        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_columns = array('site_id', 'site_number', 'site_date_school', 'fname', 'lname', 'eid', 'email', 'phone');
        $sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'site_id';

        $q = $this->db->select('site_id, site_number, site_date_school, fname, lname, eid, email, phone')
            ->from('sites')
            ->limit($limit, $offset)
            ->order_by($sort_by, $sort_order);

        $ret['rows'] = $q->get()->result();

        $q = $this->db->select('COUNT(*) as count', FALSE)
            ->from('sites');

        $tmp = $q->get()->result();

        $ret['num_rows'] = $tmp[0]->count;

        return $ret;

    }

//    function find(){
//
//        $query = "select * from sites where fname like '%?%' or lname like '%?%' or eid like '%?%' or email like '%?%' or site_number like '%?%' or site_date_school like '%%'";
////        $this->db->query($query, array(3, 'live', 'Rick'));
//
//        $result = $this->db->query($query, array($_POST["searchterm"], $_POST["searchterm"], $_POST["searchterm"], $_POST["searchterm"],$_POST["searchterm"]));
//
//        return $result->result();
//
//
////        $sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
//
//
//    }


}
?>