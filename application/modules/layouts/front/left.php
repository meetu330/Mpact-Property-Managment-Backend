<?php
$CI =& get_instance();
$CI->load->library('session');
?>
<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
	<div class="mdk-drawer__content ">
		<div class="sidebar sidebar-left sidebar-light sidebar-transparent-sm-up o-hidden borderleftshadow">
			<div class="sidebar-p-y" data-simplebar data-simplebar-force-enabled="true">
				<?php if($CI->session->userdata('eAccountType')=='Tutor') { ?>
					<ul class="sidebar-menu">
						<li class="sidebar-menu-item">
							<a class="sidebar-menu-button" href="<?php echo base_url('tutor');?>">
								<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i> Dashboard
							</a>
						</li>
						<li class="sidebar-menu-item">
							<a class="sidebar-menu-button" href="<?php echo base_url('tutor/profile');?>">
								<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">account_box</i> Edit Account
							</a>
						</li>
						<li class="sidebar-menu-item">
							<a class="sidebar-menu-button" href="<?php echo base_url('tutor/assignment');?>">
								<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">import_contacts</i> My Assignment
							</a>
						</li>
						<li class="sidebar-menu-item">
							<a class="sidebar-menu-button" href="<?php echo base_url('tutor/add');?>">
								<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">receipt</i> New Assignment
							</a>
						</li>
						<li class="sidebar-menu-item">
							<a class="sidebar-menu-button" href="<?php echo base_url('tutor/school');?>">
								<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">school</i> View Schools
							</a>
						</li>
						<li class="sidebar-menu-item">
							<a class="sidebar-menu-button" href="<?php echo base_url('login/logout');?>">
								<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">lock_open</i> Logout
							</a>
						</li>
					</ul> 
				<?php } ?>
				<?php if($CI->session->userdata('eAccountType')=='Student') { ?>
					<ul class="sidebar-menu">
					<li class="sidebar-menu-item">
						<a class="sidebar-menu-button" href="<?php echo base_url('student');?>">
							<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i> Dashboard
						</a>
					</li>
					<li class="sidebar-menu-item">
						<a class="sidebar-menu-button" href="<?php echo base_url('student/profile');?>">
							<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">account_box</i> Edit Account
						</a>
					</li>
					<li class="sidebar-menu-item">
						<a class="sidebar-menu-button" href="<?php echo base_url('student/assignment');?>">
							<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">import_contacts</i> My Assignment
						</a>
					</li>
					<li class="sidebar-menu-item">
						<a class="sidebar-menu-button" href="<?php echo base_url('student/school');?>">
							<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">school</i> View Schools
						</a>
					</li>
					<li class="sidebar-menu-item">
						<a class="sidebar-menu-button" href="<?php echo base_url('login/logout');?>">
							<i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">lock_open</i> Logout
						</a>
					</li>
				</ul>
				<?php } ?>
			</div>
		</div>
	</div>        
</div>