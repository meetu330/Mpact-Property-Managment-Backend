<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Login_model extends CI_Model
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

    var $table                  = 'admin';
    var $table_house_file       = 'house_file';
    var $table_house_file_dub   = 'house_file_dub';
    var $table_prospecting      = 'prospecting';
    var $table_prospecting_dub  = 'prospecting_dub';
    var $table_suffix_abb       = 'suffix_abb';

    
    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function house_data_add($data)
    {
        $this->db->insert($this->table_house_file, $data);
        return $this->db->insert_id();
    }
    public function house_data_dublicate($data)
    {
        $this->db->insert($this->table_house_file_dub, $data);
        return $this->db->insert_id();
    }
    
    public function prospecting_data_add($data)
    {
        $this->db->insert($this->table_prospecting, $data);
        return $this->db->insert_id();
    }
    
    public function prospecting_data_add_dub($data)
    {
        $this->db->insert($this->table_prospecting_dub, $data);
        return $this->db->insert_id();
    }

    public function login($email, $password)
    {
        $this->db->from($this->table);
        $this->db->where('vEmail', $email );
        $this->db->where('vPassword', $password );
        $this->db->where('eStatus', 'Active');
        $query=$this->db->get();
        return $query->row();
    }

    public function get_by_all_data($criatarea)
    {  
        if($criatarea['table']==1)
        {
            $this->db->select('t.id,t.contributor_street_1,t.iCsvId');
            $this->db->from($this->table_prospecting.' t');
            $this->db->where('t.iDeleteId','0');
            $this->db->where('t.contributor_street_1 !=', 'NULL');
            $this->db->where('t.iReplaceId !=',$criatarea['SelecttextNumber']);
            $this->db->limit(3000);
            $this->db->where('t.iCsvId',$criatarea['id']);
            $query=$this->db->get();
            $data = $query->result();
            return $data;
        }
        else if($criatarea['table']==2)
        {
            $this->db->select('t.id,t.vStreet,t.iCsvId');
            $this->db->from($this->table_house_file.' t');
            $this->db->where('t.iDeleteId','0');
            $this->db->where('t.iReplaceId !=',$criatarea['SelecttextNumber']);
            $this->db->limit(3000);
            $this->db->where('t.vStreet !=', 'NULL');
            $this->db->where('t.iCsvId',$criatarea['id']);
            $query=$this->db->get();
            $data = $query->result();
            return $data;
        }
        
    }
    public function get_by_update_data()
    {
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','0');
        $this->db->order_by('id','DESC');
        $this->db->limit(1);
        $query=$this->db->get();
        $data = $query->row();
        return $data; 
    }

     public function get_by_lastid_housefile()
    {
        $this->db->from($this->table_house_file);
        $this->db->where('iDeleteId','0');
        $this->db->order_by('id','DESC');
        $this->db->limit(1);
        $query=$this->db->get();
        $data = $query->row();
        return $data; 
    }


     public function get_by_update_data_hosefile()
    {
        $this->db->from($this->table_house_file);
        $this->db->where('iDeleteId','0');
        $query=$this->db->get();
        $data = $query->num_rows();
        return $data; 
    }

    public function get_by_last_id()
    {
        $this->db->from($this->table_prospecting);
        $this->db->order_by('id','DESC');
        $this->db->limit(1);
        $query=$this->db->get();
        $data = $query->row();
        return $data;  
    }
    


    public function get_by_all_suffix_check_street($street)
    {
        $this->db->from($this->table_suffix_abb);
        $this->db->like('vSuffixName',$street);
        $query=$this->db->get();
        echo $this->db->last_query();
        exit;

        // $data0 = $query->num_rows();
        return $data_0 = $query->result();
            
    }
    // Replace Data in Prospecting
  
   
    public function get_by_all_text2($text2)
    {
        $this->db->from($this->table_suffix_abb);
        $this->db->where('vSuffixName',preg_replace('/\s+/', '', $text2));
        $query=$this->db->get();

        $data = $query->row();
        return $data;   
    }
    
    // ***********************update*********************
   
    public function update2($where2, $data2)
    {
        $this->db->update($this->table_prospecting, $data2, $where2);
        return $this->db->affected_rows();
    }
    public function update6($where6, $data6)
    {
        $this->db->update($this->table_prospecting, $data6, $where6);
        return $this->db->affected_rows();
    }
    public function update_house_file($where, $data)
    {
        $this->db->update($this->table_house_file, $data, $where);
        return $this->db->affected_rows();
    }

    public function update_data_null($data6)
    {
        $this->db->update($this->table_prospecting, $data6);
        return $this->db->affected_rows();
    }

    public function update_data_null_housefile($data6)
    {
        $this->db->update($this->table_house_file, $data6);
        return $this->db->affected_rows();
    }

    

    

    
}
