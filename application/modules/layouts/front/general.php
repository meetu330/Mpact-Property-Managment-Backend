<?php
$CI =& get_instance();
$CI->load->library('general');
$CI->load->library('session');
$CI->load->helper('cookie');

$cookie = get_cookie('doctor_left');

if($cookie == ''){
	$cookie = 0;
}

$iUserId = $CI->session->userdata('iUserId');

$company_info = $CI->general->company_info();

$social_info = $CI->general->social_info();

$meta_info = $CI->general->meta_info();

$menu = $this->uri->segment(1); 
?>