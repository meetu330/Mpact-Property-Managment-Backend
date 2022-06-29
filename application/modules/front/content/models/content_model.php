<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Content_model extends CI_Model
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

    var $table                      = 'user';
    var $table_house_file           = 'house_file';
    var $table_prospecting          = 'prospecting';
    var $table_suffix               = 'suffix';
    var $table_suffix_abb           = 'suffix_abb';


    public function __construct()
    {
        parent::__construct();
    }
    public function add($data)
    {
        $this->db->insert($this->table_suffix, $data);
        return $this->db->insert_id();
    }
    public function add_suffix($data)
    {
        $this->db->insert($this->table_suffix_abb, $data);
        return $this->db->insert_id();
    }
    public function get_by_csv_data_date_wise($criteria)
    {
        if($criteria['Table']!="")
        {
            if($criteria['Table']=='1')
            {
                $this->db->from($this->table_prospecting);
            }
            else
            {
                $this->db->from($this->table_house_file);
            }
            if($criteria['StartDate']!="")
            {
                $this->db->where('vStartDate >=', $criteria['StartDate']);
            }
            if($criteria['EndDate']!="")
            {
                $this->db->where('vStartDate <=', $criteria['EndDate']);
            }
            $this->db->where('vStartDate !=','null');
            $this->db->group_by('iCsvId');
            $query = $this->db->get();
            $data = $query->result();
            return $data;
        }
    }

    public function get_by_all_suffix()
    {
        $this->db->from($this->table_suffix);
        $this->db->group_by('vName');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_by_all_suffixdata()
    {
        $this->db->select('t.*,t2.vName');
        $this->db->from($this->table_suffix_abb.' t');
        $this->db->join($this->table_suffix.' t2','t.iSuffixId=t2.iSuffixId');
        $this->db->order_by('t.iSuffixAbbId','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_single_suffix($iSuffixAbbId)
    {
        $this->db->select('t.*,t2.vName');
        $this->db->from($this->table_suffix_abb.' t');
        $this->db->join($this->table_suffix.' t2','t.iSuffixId=t2.iSuffixId');
        $this->db->where('t.iSuffixAbbId',$iSuffixAbbId);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_by_all_suffix_abb($iSuffixId)
    {
        $this->db->from($this->table_suffix_abb);
        $this->db->where('iSuffixId',$iSuffixId);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_by_id($criteria = array())
    {
        $this->db->from($this->table_house_file);
        $this->db->where('vStreet',$criteria['vStreet']);
        $this->db->where('vCity',$criteria['vCity']);
        $this->db->where('vState',$criteria['vState']);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_by_id_dub($criteria = array())
    {
        $this->db->from($this->table_prospecting);
        $this->db->where('contributor_street_1',$criteria['vStreet']);
        $this->db->where('contributor_city',$criteria['vCity']);
        $this->db->where('contributor_state',$criteria['vState']);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_by_all_country()
    {   
        $this->db->select('id,vFirstName,vLastname,vStreet,vState');
        $this->db->from($this->table_house_file);
        $this->db->where('iDeleteId','0');
        $this->db->where('vFirstName !=','');
        $this->db->where('vLastname !=','');
        $this->db->group_by('vStreet,vState,vCity');
        $query=$this->db->get();
        // echo $this->db->last_query();
        // exit;

        $data = $query->result();
        return $data;
    }
    public function get_by_all_country1()
    {   
        $this->db->select('id,vFirstName,vLastname,vStreet,vState');
        $this->db->from($this->table_house_file);
        $this->db->where('iDeleteId','0');
        $this->db->where('vFirstName !=','');
        $this->db->where('vLastname !=','');
        $this->db->group_by('vStreet,vState,vCity');
        $query=$this->db->get();
        $data = $query->num_rows();
        return $data;
    }


    public function two_table_data_metch($criatarea)
    {
        $this->db->select('id,vFirstName,vLastname,vStreet,vCity,vState');
        $this->db->from($this->table_house_file);
        $this->db->where('iDeleteId','0');
        if(!empty($criatarea['vFirstName']))
        {
            $this->db->where('vFirstName',$criatarea['vFirstName']);
        }

        if(!empty($criatarea['vLastname']))
        {
            $this->db->where('vLastname',$criatarea['vLastname']);
        }

        if(!empty($criatarea['vStreet']))
        {
            $this->db->where('vStreet',$criatarea['vStreet']);
        }

        if(!empty($criatarea['vCity']))
        {
            $this->db->where('vCity',$criatarea['vCity']);
        }

        if(!empty($criatarea['vState']))
        {
            $this->db->where('vState',$criatarea['vState']);
        }
        $query=$this->db->get();
        $data = $query->result();

        if(count($data) > 0)
        {   
            $wheres = array('id'=> $criatarea['id']);
            $datas['vMetchData'] = '1';

            $this->db->update($this->table_prospecting, $datas, $wheres);
            $this->db->affected_rows();

            foreach($data as $key => $value)
            {
                $where = array('id'=> $value->id);
                $dataupdate['vMetchData'] = '1';

                $this->db->update($this->table_house_file, $dataupdate, $where);
                // echo $this->db->last_query();
                // exit;

                $this->db->affected_rows();
                
            }
        }
        else
        {
            $wheres = array('id'=> $criatarea['id']);
            $datas['vMetchData'] = '0';

            $this->db->update($this->table_prospecting, $datas, $wheres);
            $this->db->affected_rows();
        }

        return $data;
    }
    public function get_by_duplicate_data_not_get()
    {   
        $this->db->select('id,contributor_first_name,contributor_last_name,contributor_street_1,contributor_city,contributor_state,contributor_zip');
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','0');
        $this->db->where(array('vMetchData' => NULL));
        $this->db->limit(2000);
        $query=$this->db->get();
        $data = $query->result();
        return $data;
    }
    
    public function get_by_dublicatedata_hosefile()
    {   
        $this->db->select('id,contributor_first_name,contributor_last_name,contributor_street_1,contributor_city,contributor_state,contributor_zip');
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','0');
        $this->db->where('vMetchData','0');
        $query=$this->db->get();
        $data = $query->result();
        return $data;
    }

    public function get_by_dublicatedata_hosefile1()
    {   
        $this->db->select('id,contributor_first_name,contributor_last_name,contributor_street_1,contributor_city,contributor_state,contributor_zip');
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','0');
        $this->db->where('vMetchData','0');
        $query=$this->db->get();
        $data = $query->num_rows();
        return $data;
    }
    
    

    public function get_by_all_prospectingdata()
    {   
        $this->db->select('id,contributor_first_name,contributor_last_name,contributor_street_1,contributor_city,contributor_state,contributor_zip');
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','0');
        $query=$this->db->get();
        $data = $query->result();
        return $data;
    }
    public function get_by_all_prospectingdata1()
    {   
        $this->db->select('id,contributor_first_name,contributor_last_name,contributor_street_1,contributor_city,contributor_state,contributor_zip');
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','0');
        $query=$this->db->get();
        $data = $query->num_rows();
        return $data;
    }

    public function get_by_get_dublicate_data()
    {   
        $this->db->select('id,contributor_first_name,contributor_last_name,contributor_street_1,contributor_city,contributor_state,contributor_zip');
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','0');
        $this->db->where('vMetchData','1');
        $this->db->or_where('vMetchData','');
        $query=$this->db->get();
        $data = $query->result();
        return $data;
    }

    public function get_by_all_duplicatedata()
    {   
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','1');
        $query=$this->db->get();
        $data = $query->result();
        return $data;
    }

    public function get_by_all_duplicatedata1()
    {   
        $this->db->from($this->table_prospecting);
        $this->db->where('iDeleteId','1');
        $query=$this->db->get();
        $data = $query->num_rows();
        return $data;
    }

    public function get_by_all_duplicatedata_housefile()
    {   
        $this->db->from($this->table_house_file);
        $this->db->where('iDeleteId','1');
        $query=$this->db->get();
        $data = $query->result();
        return $data;
    }
    public function get_by_all_duplicatedata_housefile1()
    {   
        $this->db->from($this->table_house_file);
        $this->db->where('iDeleteId','1');
        $query=$this->db->get();
        $data = $query->num_rows();
        return $data;
    }


    public function get_by_all_dublicate()
    {      
        $this->db->select('t.id,t.contributor_first_name,t.contributor_last_name,t.contributor_street_1,t.contributor_city,t.contributor_state,COUNT(*) as count');
        $this->db->from($this->table_prospecting.' t');
        $this->db->group_by('contributor_street_1,contributor_city,contributor_state');  
        $this->db->having('COUNT(*)>1'); 
        $this->db->where('iDeleteId','0'); 
        // $this->db->where('iCsvId',$iCsvId); 
        $this->db->limit(10000); 
        $query  = $this->db->get();
        $datas  = $query->result();
        $p      = array();
        $c      = count($datas);
        if($c < 50)
        {
            foreach($datas as $value)
            {
                $this->db->select('t.id');
                $this->db->from($this->table_prospecting.' t');
                
                if($value->contributor_street_1!="")
                {
                    $this->db->where('contributor_street_1',$value->contributor_street_1);
                }
                if($value->contributor_city!="")
                {
                    $this->db->where('contributor_city',$value->contributor_city);
                }
                if($value->contributor_state!="")
                {
                    $this->db->where('contributor_state',$value->contributor_state);
                }
                $this->db->where('t.id !=',$value->id);
                $query  =   $this->db->get();
                $data_delete = $query->result();
            
                foreach($data_delete as $k)
                {
                    $id = $k->id;
                    $data_upd = array();
                    $where = array();
                    $where = array('id'=>$id);
                
                    $data_upd['iDeleteId'] = '1';
                    $this->db->update($this->table_prospecting, $data_upd, $where);
                    $this->db->affected_rows();
                }
            }
        }
        else  
        {
        
            $k      = 0;
            while($datas)
            {
                // array_push($p , $datas[$k]->count);
                if($datas[$k]->count > 1)
                {
                    $data = array();
                    $id   = $datas[$k]->id;
                    $where = array('id' => $id);
                    $data_upds['iDeleteId'] = '1';
                    $this->db->update($this->table_prospecting, $data_upds, $where);
                    $upd_id = $this->db->affected_rows();
                }
                if($c==$k)
                {
                    break;
                }
                $k++;  
            }
        }

        // $sum = array_sum($p);
        return $upd_id;
    }
    //house file data
    public function get_by_all_dublicate_housefile()
    {      
        $this->db->select('id,iDeleteId,vFirstName,vLastname,vStreet,vCity,vState,COUNT(*) as count');
        $this->db->from($this->table_house_file.' t');
        $this->db->where('iDeleteId','0'); 
        $this->db->limit(10000);  
        $this->db->group_by('vStreet,vCity,vState');  
        $this->db->having('COUNT(*)>1'); 
        $query  = $this->db->get();
        
        $datas  = $query->result();
        $p      = array();
        $c      = count($datas);
       
        if($c < 50)
        {
            foreach($datas as $value)
            {
                $this->db->select('t.id');
                $this->db->from($this->table_house_file.' t');
                if($value->vStreet!="")
                {
                    $this->db->where('vStreet',$value->vStreet);
                }
                if($value->vCity!="")
                {
                    $this->db->where('vCity',$value->vCity);
                }
                if($value->vState!="")
                {
                    $this->db->where('vState',$value->vState);
                }
                $this->db->where('t.id !=',$value->id);
                $query  =   $this->db->get();
                $data_delete = $query->result();

            
                foreach($data_delete as $k)
                {
                    $id = $k->id;
                    $data_upd = array();
                    $where = array();
                    $where = array('id'=>$id);
                    $data_upd['iDeleteId'] = '1';
                    $this->db->update($this->table_house_file, $data_upd, $where);
                    $this->db->affected_rows();
                }
            }
        }
            
        if($c > 50)
        {
            $k      = 0;
            while($datas)
            {
                if($datas[$k]->count > 1)
                {
                    $data = array();
                    $id   = $datas[$k]->id;
                    $where = array('id' => $id);
                    $data_upds['iDeleteId'] = '1';
                    $this->db->update($this->table_house_file, $data_upds, $where);
                    $upd_id = $this->db->affected_rows();
                }
                if($c==$k)
                {
                    break;
                }
                $k++;  
            }
        }
        return $upd_id;
    }
    
    public function get_by_all_dublicate_count()
    {      
        $this->db->select('COUNT(*) as count');
        $this->db->from($this->table_prospecting.' t');
        $this->db->having('COUNT(*)>1');
        $this->db->group_by('contributor_street_1,contributor_city,contributor_state');   
        $this->db->where('iDeleteId','0'); 
        $query = $this->db->get();
        $data = $query->result();
        $p = array();
        foreach($data as $value)
        {
           array_push($p , $value->count);
        }
        $sum = array_sum($p);
        return $sum;
    
    }
    public function get_by_all_dublicate_house()
    {      
        $this->db->select('COUNT(*) as count');
        $this->db->from($this->table_house_file.' t');
        $this->db->having('COUNT(*)>1');
        $this->db->group_by('vStreet,vCity,vState');   
        $this->db->where('iDeleteId','0'); 
        $query = $this->db->get();
        $data = $query->result();
        $p = array();
        foreach($data as $value)
        {
           array_push($p , $value->count);
        }
        $sum = array_sum($p);
        return $sum;
    
    }

    public function get_by_dublicate_data($data)
    {   
        $this->db->select('t.id,t.iCsvId');
        $this->db->from($this->table_prospecting.' t');

        if($data['contributor_first_name']!="")
        {
            $this->db->where('contributor_first_name',$data['contributor_first_name']);
        }
        if($data['contributor_last_name']!="")
        {
            $this->db->where('contributor_last_name',$data['contributor_last_name']);
        }
        if($data['contributor_street_1']!="")
        {
            $this->db->where('contributor_street_1',$data['contributor_street_1']);
        }
        if($data['contributor_city']!="")
        {
            $this->db->where('contributor_city',$data['contributor_city']);
        }
        if($data['contributor_state']!="")
        {
            $this->db->where('contributor_state',$data['contributor_state']);
        }
        $this->db->limit($data['count']);
      
        $query=$this->db->get();
         
        $data = $query->result();

        return $data;  
    }

    
    public function get_count()
    {
        $this->db->from($this->table);
        $this->db->where('eStatus <> ', 'Pending' );
        $query=$this->db->get();
        return $query->num_rows();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    public function delete_by_id($iSuffixAbbId)
    {
        $this->db->where('iSuffixAbbId', $iSuffixAbbId);
        $this->db->delete($this->table_suffix_abb);
    }
    public function update_suffix($where, $data)
    {
        $this->db->update($this->table_suffix_abb, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_csv_id($iCsvId)
    {
        $this->db->where('iCsvId', $iCsvId);
        $this->db->delete($this->table_house_file);
    }

    public function delete_by_prospectingdata($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_prospecting);
    }

    public function delete_by_csv_file($iCsvId)
    {
        $this->db->where('iCsvId', $iCsvId);
        $this->db->delete($this->table_prospecting);
    }
    public function delete_by_house_file($iCsvId)
    {
        $this->db->where('iCsvId', $iCsvId);
        $this->db->delete($this->table_house_file);
    }



    
    

    


}
