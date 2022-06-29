<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class content extends MX_Controller 
{
    
    public function __construct() 
    {
        parent::__construct();
        // $this->load->library('general');
        // $this->load->model('banner/banner_model');
        // $this->load->model('activities/activities_model');
        // $this->load->model('activity_question_answer/activity_question_answer_model');
        // $this->load->model('gallery/gallery_model');
        // $this->load->model('newsletter/newsletter_model');
        // $this->load->model('blog/blog_model');
        // $this->load->model('setting/setting_model');
        // $this->load->model('testimonial/testimonial_model');
        // $this->load->model('faq/faq_model');
    }

    public function index()
    {
        $this->template->build('home',null);
    }

    public function csv()
    {
        // echo "fgfgfg";
        // exit;

        // print_r($_FILES);
        // exit;
    }

    // public function family_handbook()
    // {
    //     $this->template->build('family_handbook',null);
    // }

    // public function cj_goes_to_evergreen()
    // {
    //     $this->template->build('cj_goes_to_evergreen',null);
    // }

    // public function contact()
    // {
    //     $this->template->build('contact',$data);
    // }

    // public function book_popup()
    // {
    //     $session_data['Book'] =  'Yes';
    //     $this->session->set_userdata($session_data);
    // }
}