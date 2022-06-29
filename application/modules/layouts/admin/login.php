<?php
$CI =& get_instance();
$CI->load->library('general');
// $general_info = $CI->general->setting_info('Appearance');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $general_info['CPANEL_TITLE']['vValue'];?></title>
		<?php include_once 'css.php';?>
  		<script src="<?php echo base_url('assets/admin/js/jquery-3.3.1.min.js');?>"></script>
  		<link rel="shortcut icon" href="<?php echo base_url();?>assets/uploads/logo/favicon.ico">
	</head>
	<body>
		<body class="theme-blush authentication sidebar-collapse">
			<?php include_once 'login_header.php';?>
			<!-- content -->
			<div id="content" class="app-login-content" role="main">
				<div class="app-content-body ">
					<?php echo $template['body'];?>
			  	</div>
			</div>
			<!-- /content -->
		  	<?php include_once 'login_footer.php';?>
			</div>
			<?php include_once 'js.php';?>
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
