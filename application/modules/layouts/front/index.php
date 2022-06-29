<?php
$CI =& get_instance();
$CI->load->library('general');
// $meta_info = $CI->general->meta_info();
// $company_info = $CI->general->setting_info('Company');
// $method_name = $this->router->fetch_method();

//echo "<pre>";print_r($banner);exit;
?>
<!DOCTYPE html>

<html lang="en">

    
<!-- Mirrored from leverage.codings.dev/home-portfolio-3 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 18 Aug 2020 06:22:16 GMT -->
<head>

    <title><?php echo $meta_info['META_TITLE']['vValue'];?></title>
    <meta charset="utf-8">
    <meta name="description" content="iSyncEvolutions">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <script type="text/javascript" src="<?php echo base_url('assets/front/js/jquery-3.3.1.min.js'); ?>">
    </script>
    <link rel="shortcut icon" href="<?php echo base_url('assets/uploads/logo/favicon.png');?>?123">
    <?php include_once 'css.php';?>
    </head>
	<body>
			<?php include_once 'header.php';?>
			
			 	<?php echo $template['body']; ?>
			
		 	<?php include_once 'footer.php';?> 
        <?php include_once 'js.php';?>
       	<!-- Start of  Zendesk Widget script -->
		<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=1f280d6a-507b-4816-a4c5-277b96fca79d"> </script>
		<!-- End of  Zendesk Widget script -->
		
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
