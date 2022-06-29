<?php
$CI = & get_instance();
$CI->load->library('session');
$CI->load->helper('cookie');

$panel = $CI->config->item('panel');

if($panel == "admin"){
	$iAdminId = $CI->session->userdata('iAdminId');
	$controller = $CI->router->class;

	$action = array("login", "logout");

	if(empty($iAdminId)) {
	    if(!in_array($controller, $action)) {
	        redirect(base_url('admin/login'));
	    }
	}
}

if(empty(get_cookie('cart_session'))) {
	$uniqid = uniqid();
	setcookie("cart_session", $uniqid,"0","/");
}

$CI->lang->load('message','EN');
?>