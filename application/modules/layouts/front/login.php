<?php
$CI =& get_instance();
$CI->load->library('general');
$meta_info = $CI->general->meta_info();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			<?php echo $meta_info['META_TITLE']['vValue'];?>
		</title>
		<meta name="keywords" content="<?php echo $meta_info['META_KEYWORD']['vValue'];?>">
		<meta name="description" content="<?php echo $meta_info['META_DESCRIPTION']['vValue'];?>">
		<?php include_once 'css.php';?>
		<script src="<?php echo base_url('assets/front/vendor/jquery.min.js');?>"></script>
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/uploads/logo/favicon.png">
	</head>
	<body>
		<?php echo $template['body']; ?>
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
