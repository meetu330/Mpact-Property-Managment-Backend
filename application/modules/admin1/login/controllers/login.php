<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        
        $this->template->set_layout('admin/login.php');

    }

    public function index()
    {
        if ($this->session->userdata('iAdminId')) {
            redirect(base_url('admin/dashboard'));
        }
        $this->template->build('login',null);
        
    }

    public function csv_upload_action()
    {   
          $tmp_name = $_FILES['image']['tmp_name'];

          $handle = fopen($_FILES['image']['tmp_name'], r);

          $csvAsArray = array_map('str_getcsv', file($tmp_name));

         
    
          array_shift($csvAsArray);
        
            for ($i=0; $i<count($csvAsArray); $i++) 
            {  
                
                $csc_data['iCountryId']         = $csvAsArray[$i][0];
                $csc_data['vCountry']           = $csvAsArray[$i][1];
                $csc_data['vCountryCode']       = $csvAsArray[$i][2];
                $csc_data['vCountryISDCode']    = $csvAsArray[$i][3];
                $csc_data['eDefault']           = $csvAsArray[$i][4];
                $csc_data['eStatus']            = $csvAsArray[$i][5];

                $id = $this->login_model->add($csc_data);
            }

           
        $this->session->set_flashdata('success', "CSV File Upload Successfully");

        redirect(base_url('admin/login'));

    }

    public function logout()
    {
        $this->session->unset_userdata('iAdminId');
        redirect(base_url('admin/login'));
    }
}