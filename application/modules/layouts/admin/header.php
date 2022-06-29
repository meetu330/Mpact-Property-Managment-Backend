<?php
$CI = & get_instance();
$CI->load->library('session');
$CI->load->library('general');
$CI->load->helper('cookie');

$vName = $CI->session->userdata('vName');
$iAdminId = $CI->session->userdata('iAdminId');
$iUserId = $CI->session->userdata('iUserId');

$company_info = $CI->general->setting_info('Company');

$cookie = get_cookie('admin_left');

if($cookie == ''){
    $cookie = 0;
}
?>
<nav class="navbar p-l-5 p-r-5">
    <ul class="nav navbar-nav navbar-left">
        <li>
            <div class="navbar-header">
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url('admin/dashboard');?>"><img src="<?php echo base_url('assets/admin/images/logo.png');?>" width="180" alt="Oreo"><span class="m-l-10"></span></a>
            </div>
        </li>
        <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>       
        <li class="float-right">            
            <a href="<?php echo base_url('admin/login/logout');?>" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a>
        </li>
    </ul>

</nav>