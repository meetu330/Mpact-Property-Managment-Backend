<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Setting_model extends CI_Model
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

    var $table = 'setting';

    
    public function __construct()
    {
        parent::__construct();
    }

   

   
}
