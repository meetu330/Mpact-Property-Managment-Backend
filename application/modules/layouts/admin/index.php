<?php
$CI =& get_instance();
$CI->load->library('general');
$CI->load->library('session');
$CI->load->helper('cookie');
$general_info = $CI->general->setting_info('Appearance');

$cookie = get_cookie('admin_left');

if($cookie == ''){
	$cookie = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $general_info['CPANEL_TITLE']['vValue'];?></title>
		<?php include_once 'css.php';?>
  		<script src="<?php echo base_url('assets/admin/js/jquery-3.3.1.min.js');?>"></script> 		
  		<link rel="shortcut icon" href="<?php echo base_url();?>assets/uploads/logo/favicon.png">
  			</head>
	<body class="theme-cyan">
		<!-- Page Loader -->
		<div class="page-loader-wrapper">
		    <div class="loader">
		        <div class="m-t-30"><img class="zmdi-hc-spin" src="<?php echo base_url('assets/admin/images/logo.svg'); ?>" width="48" height="48" alt="Oreo"></div>
		        <p>Please wait...</p>
		    </div>
		</div>
		<!-- Overlay For Sidebars -->
		<div class="overlay"></div>
		<!-- Top Bar -->

		
			<?php include_once 'header.php';?>
			<?php include_once 'left.php';?>
			<!-- content -->
			<div id="content" class="app-content" role="main">
				<div class="app-content-body ">
					<?php echo $template['body'];?>
			  	</div>
			</div>
			<!-- /content -->
		  	<?php include_once 'footer.php';?>
		
			<?php include_once 'js.php';?>
			<?php if($this->session->flashdata('success')){?>
				<script type="text/javascript">
					$.Toast("<?php echo $this->session->flashdata('success');?>", "", "success", {
				        has_icon:true,
				        has_close_btn:true,
						stack: true,
				        fullscreen:true,
				        timeout:8000,
				        sticky:false,
				        has_progress:true,
				        rtl:false,
				    });
				</script>
			<?php }?>
			<?php if($this->session->flashdata('error')){?>
				<script type="text/javascript">
					$.Toast("<?php echo $this->session->flashdata('error');?>", "", "error", {
				        has_icon:true,
				        has_close_btn:true,
						stack: true,
				        fullscreen:true,
				        timeout:8000,
				        sticky:false,
				        has_progress:true,
				        rtl:false,
				    });
				</script>
			<?php }?>
	</body>
</html>
<script type="text/javascript">
	$(document).on('click','.xyz',function(){
	  cookie = $.cookie("admin_left");

	  if (cookie == '1') {
	    $.cookie("admin_left", 0);
	    $("#img").css('width','auto');
	  } else {
	    $.cookie("admin_left", 1);
	    $("#img").css('width','50px');
	  }
	});
</script>
