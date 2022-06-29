<?php
defined('BASEPATH') || exit('No direct script access allowed');

class admin_model extends CI_Model
{
    public $table_name;
    public $table_alias;
    public $primary_key;
    public $primary_alias;
    public $grid_fields;
    public $join_tables;
    public $extra_cond;
    public $groupby_cond;
    public $orderby_cond;
    public $unique_type;
    public $unique_fields;
    public $switchto_fields;
    public $default_filters;
    public $search_config;
    public $relation_modules;
    public $deletion_modules;
    public $print_rec;
    public $multi_lingual;
    public $physical_data_remove;
    
    public $listing_data;
    public $rec_per_page;
    public $message;

    var $table = 'admin';
    var $table_center = 'center';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_data($criteria = array())
    {
        $vCenter = "(SELECT tc.`vCenterName` FROM `".$this->table_center."` tc WHERE tc.`iCenterId` = t.`iCenterId` LIMIT 1) as vCenter";
        $this->db->select("t.*,$vCenter");
        $this->db->from($this->table.' t');

        if($criteria['keyword'] != "")
        {
            $this->db->where('vName like "%'.$criteria['keyword'].'%" OR vEmail like "%'.$criteria['keyword'].'%" OR vPhone like "%'.$criteria['keyword'].'%" OR eStatus like "%'.$criteria['keyword'].'%"' );
        }

        if($criteria['column'] || $criteria['order'] != ""){
            $this->db->order_by($criteria['column'],$criteria['order']);
        }   

        if($criteria['paging'] == true)
        {
            $this->db->limit($criteria['limit'],$criteria['start']);
        }
        // $this->db->where('iRoleId','1');

        $query=$this->db->get();
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('iAdminId',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('iAdminId', $id);
        $this->db->delete($this->table);
    }

    public function check_unique_email($vEmail, $iAdminId = "")
    {
        $this->db->from($this->table);

        $this->db->where('vEmail', $vEmail );

        if($iAdminId)
        {
            $this->db->where("iAdminId <> $iAdminId" );
        }
        
        $query=$this->db->get();
        return $query->row();
    }
}
