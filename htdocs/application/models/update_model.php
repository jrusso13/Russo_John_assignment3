<?php
class update_model extends CI_Model{
// Function To Fetch All site Records
    function show_sites(){
        $query = $this->db->get('sites');
        $query_result = $query->result();
        return $query_result;
    }
// Function To Fetch Selected site Record
    function show_site_id($data){
        $this->db->select('*');
        $this->db->from('sites');
        $this->db->where('site_id', $data);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
// Update Query For Selected site
    function update_site_id1($id,$data){
        $this->db->where('site_id', $id);
        $this->db->update('sites', $data);
    }

}
?>