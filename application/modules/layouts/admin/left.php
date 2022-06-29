<?php
$CI =& get_instance();
$CI->load->library('session');
$CI->load->library('general');
 $admin_info = $CI->general->admin_info();
 $center = $CI->general->get_all_center();
 $iRoleId = $CI->session->userdata('iRoleId');
 $Admin_iCenterId = $CI->session->userdata('Admin_iCenterId');
?>

<?php
$controller         = $this->router->fetch_class();
$method             = $this->router->fetch_method();  
$uri_3              = $this->uri->segment(3);

?>

<?php $sub_menu = $this->router->fetch_class();?>

<?php 
    $banner_left_menu       = $CI->general->admin_role_permission_info('banner');
    $gallery_left_menu      = $CI->general->admin_role_permission_info('gallery');
    $blog_left_menu         = $CI->general->admin_role_permission_info('blog');
    $testimonial_left_menu  = $CI->general->admin_role_permission_info('testimonial');
    $pageimage_left_menu    = $CI->general->admin_role_permission_info('page_image');
    $event_left_menu        = $CI->general->admin_role_permission_info('event');
    $activities_left_menu   = $CI->general->admin_role_permission_info('activities');
    $center_left_menu       = $CI->general->admin_role_permission_info('center');
    $careers_left_menu      = $CI->general->admin_role_permission_info('careers');
    $page_new_left_menu     = $CI->general->admin_role_permission_info('page_new');
    $parents_left_menu      = $CI->general->admin_role_permission_info('parents');
    $role_left_menu         = $CI->general->admin_role_permission_info('role');
    $model_left_menu         = $CI->general->admin_role_permission_info('module_permission');
    $menu_left_menu         = $CI->general->admin_role_permission_info('menu');
    $upload_pdf_left_menu   = $CI->general->admin_role_permission_info('upload_pdf');
    $messages_left_menu     = $CI->general->admin_role_permission_info('messages');
    $newsletter_left_menu   = $CI->general->admin_role_permission_info('newsletter');
    $contact_us_left_menu   = $CI->general->admin_role_permission_info('contact_us');
    $faq_left_menu          = $CI->general->admin_role_permission_info('faq');
?>


<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">

    <ul class="nav nav-tabs">
        <!-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dashboard"><i class="zmdi zmdi-home"></i></a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#user">Professors</a></li> -->
    </ul>
    <div class="tab-content">
        <div class="tab-pane stretchRight active" id="dashboard">
            <div class="menu">
                <ul style="list-style-type:none;padding:0;margin:0;">
                    <li>
                        <div class="user-info">
                            <?php
                                $image = base_url('assets/admin/images/avatar.png');
                                if($admin_info->vImage != ""){
                                    $image = base_url('assets/uploads/admin/'.$admin_info->vImage);
                                }
                            ?>
                            <div class="image"><a href="<?php echo base_url('admin/admin/edit/'.$admin_info->iAdminId);?>"><img src="<?php echo $image;?>" alt="User"></a></div>
                            <div class="detail">
                                <h4><?php echo $admin_info->vName; ?></h4>
                                <small><?php echo $admin_info->vEmail; ?></small>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="list">
                    <li><a href="<?php echo base_url('admin/dashboard');?>"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                    <?php $user_array = array('admin','user');?>
                    <?php 
                        if (empty($Admin_iCenterId)) 
                        { ?>
                            <?php if($controller == "admin") { $class = "active";} else { $class = '';}?>
                            <li class="<?php echo (in_array($sub_menu, $user_array)) ? 'active':''?>"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-outline"></i><span>Users</span> </a>
                                <ul class="ml-menu" style="display: <?php echo (in_array($sub_menu, $user_array)) ? 'block':'none'?>;">

                                <?php if($iRoleId == '1') { ?>
                                     <?php if($controller == "admin") { $class = "active";} else { $class = '';}?>
                                    <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/admin/admin');?>">Admin</a></li>
                                <?php } ?>
                                <!-- <?php if(in_array(1, $sub_admin_permission) || $iRoleId == '1') { ?>
                                    <li><a href="<?php echo base_url('admin/user/user');?>">Customer</a></li>
                                <?php } ?> -->
                                </ul>
                            </li>
                            <?php if($iRoleId == '1' || in_array('view', $banner_left_menu) || in_array('view', $careers_left_menu) || in_array('view', $center_left_menu) || in_array('view', $activities_left_menu) || in_array('view', $event_left_menu) || in_array('view', $blog_left_menu) || in_array('view', $testimonial_left_menu) || in_array('view', $pageimage_left_menu)) { ?>
                                <?php $master_array = array('banner','activities','event','blog','category','faq','testimonial','careers','center','language_label','page_image');?>

                                <?php if($controller == "banner" OR $controller == "careers" OR $controller == "center" OR $controller == "activities" OR $controller == "event" OR $controller == "blog" OR $controller == "testimonial" OR  $controller == "language_label" OR  $controller == "page_image") { $class = "active";} else { $class = '';}?>

                                <li class="<?php echo $class; ?>"> 
                                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account"></i><span>Master</span> </a>
                                    <ul class="ml-menu" style="<?php echo (in_array($sub_menu, $master_array)) ? 'display:block':''?>">


                                        <?php if(in_array('view', $banner_left_menu) || $iRoleId == '1') { ?>
                                        <?php if($controller == "banner") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/banner/banner');?>">Banner</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $careers_left_menu) || $iRoleId == '1') { ?>
                                             <?php if($controller == "careers") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/careers/careers');?>">Careers</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $center_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "center") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/center/center');?>">Center</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $activities_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "activities") { $class = "active";} else { $class = '';}?>

                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/activities/activities');?>">Activities</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $event_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "event") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/event/event');?>">Event</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $blog_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "blog") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/blog/blog');?>">Blog</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $testimonial_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "testimonial") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/testimonial/testimonial');?>">Testimonial</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $pageimage_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "page_image") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/page_image/page_image');?>">PageImage</a></li>
                                        <?php } ?>
                                        <!-- <?php if($iRoleId == '1') { ?>
                                            <li><a href="<?php echo base_url('admin/role/role');?>">Role</a></li>
                                        <?php } ?>
                                        <?php if($iRoleId == '1') { ?>
                                            <li><a href="<?php echo base_url('admin/module_permission/add');?>">Module Permission</a></li>
                                        <?php } ?> -->
                                        <?php if($iRoleId == '1') { ?>
                                            <?php if($controller == "language_label") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/language_label/language_label');?>">Language Label</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if($iRoleId == '1' || in_array('view', $gallery_left_menu) || in_array('view', $upload_pdf_left_menu)) { ?>
                                <?php $master_array = array('gallery','upload_pdf');?>
                                <?php if($controller == "gallery" OR $controller == "upload_pdf") { $class = "active";} else { $class = '';}?>
                                <li class="<?php echo $class; ?>">
                                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-collection-folder-image"></i><span>Gallery</span> </a>
                                    <ul class="ml-menu" style="<?php echo (in_array($sub_menu, $master_array)) ? 'display:block':''?>">
                                        <?php if(in_array('view', $gallery_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "gallery") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/gallery/gallery');?>">Gallery</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $upload_pdf_left_menu) || $iRoleId == '1') { ?>
                                            <?php if($controller == "upload_pdf") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/upload_pdf/upload_pdf');?>">Upload PDF</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?> 
                        <?php }
                    ?>

                    <?php if($iRoleId == '1' || in_array('view', $parents_left_menu) || in_array('view', $messages_left_menu)) { ?>
                        <?php $master_array = array('parents');?>
                         <?php if($controller == "parents") { $class = "active";} else { $class = '';}?>
                        <li class="<?php echo $class; ?>">
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-menu"></i><span>Enrollment</span> </a>
                            <ul class="ml-menu" style="<?php echo (in_array($sub_menu, $master_array)) ? 'display:block':''?>">
                                <?php if(in_array('view', $parents_left_menu) || $iRoleId == '1') { ?>
                                    <?php if($controller == "parents" && $uri_3 == "") { $class = "active";} else { $class = '';}?>
                                    <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/parents/parents');?>">Enrolment</a></li>
                                    <?php if($iRoleId == '1'){ ?>
                                        <?php foreach ($center as $key => $value) { ?>
                                            <li class="<?php if($uri_3 == $value->iCenterId){echo "active";} ?>"><a href="<?php echo base_url('admin/parents/center/'.$value->iCenterId);?>"><?php echo $value->vCenterName; ?></a></li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <!-- <?php if(in_array('view', $messages_left_menu) || $iRoleId == '1') { ?>
                                    <li><a href="<?php echo base_url('admin/messages/messages');?>">Messages</a></li>
                                <?php } ?> -->
                            </ul>
                        </li>
                    <?php } ?> 

                    <?php if($iRoleId == '1' || in_array('view', $role_left_menu) || in_array('view', $messages_left_menu)) { ?>
                        <?php $master_array = array('role');?>
                         <?php if($controller == "role" OR $controller == "module_permission") { $class = "active";} else { $class = '';}?>
                        <li class="<?php echo $class; ?>">
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-lock"></i><span>Role Permission</span> </a>
                            <ul class="ml-menu" style="<?php echo (in_array($sub_menu, $master_array)) ? 'display:block':''?>">
                                <?php if(in_array('view', $role_left_menu) || $iRoleId == '1') { ?>

                                    <?php if($controller == "role") { $class = "active";} else { $class = '';}?>
                                    <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/role/role');?>">Role</a></li>
                                <?php } ?>
                                <?php if(in_array('view', $model_left_menu) || $iRoleId == '1') { ?>

                                    <?php if($controller == "module_permission") { $class = "active";} else { $class = '';}?>
                                    <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/module_permission/add');?>">Module Permission</a></li>
                                <?php } ?>
                                <!-- <?php if(in_array('view', $messages_left_menu) || $iRoleId == '1') { ?>
                                    <li><a href="<?php echo base_url('admin/messages/messages');?>">Messages</a></li>
                                <?php } ?> -->
                            </ul>
                        </li>
                    <?php } ?>

                    <?php 
                        if (empty($Admin_iCenterId)) 
                        { ?>
                            <?php if($iRoleId == '1' || in_array('view', $newsletter_left_menu)) { ?>
                                <?php $master_array = array('newsletter');?>

                                <?php if($controller == "newsletter") { $class = "active";} else { $class = '';}?>
                                <li class="<?php echo $class; ?>">
                                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-label-alt"></i><span>Newsletter</span> </a>
                                    <ul class="ml-menu" style="<?php echo (in_array($sub_menu, $master_array)) ? 'display:block':''?>">
                                        <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/newsletter/newsletter');?>">Newsletter</a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if($iRoleId == '1' || in_array('view', $contact_us_left_menu) || in_array('view', $faq_left_menu)) { ?>
                                <?php $config_array = array('system_email','notification_master','faq','contact_us');?>

                                <?php if($controller == "contact_us" OR $controller == "faq" OR $controller == "system_email" OR $controller == "notification_master") { $class = "active";} else { $class = '';}?>

                                <li class="<?php echo $class; ?>"><a href="javascript:void(0);" class="menu-toggle <?php echo (in_array($sub_menu, $config_array)) ? 'active':''?>"><i class="material-icons">email</i><span>Email</span> </a>
                                    <ul class="ml-menu" style="display: <?php echo (in_array($sub_menu, $config_array)) ? 'block':'none'?>;">
                                        <?php if(in_array('view', $contact_us_left_menu)){ ?>
                                            <?php if($controller == "contact_us") { $class = "active";} else { $class = '';}?>

                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/contact_us/contact_us');?>">Contact Us</a></li>
                                        <?php } ?>
                                        <?php if(in_array('view', $faq_left_menu)){ ?>
                                            <?php if($controller == "faq") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/faq/faq');?>">Faq</a></li>
                                        <?php } ?>
                                        <?php if($iRoleId == 1){ ?>
                                            <?php if($controller == "system_email") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/system_email/system_email');?>">Email</a></li>
                                            <?php if($controller == "notification_master") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/notification_master/notification_master');?>">Notification Master</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if($iRoleId == '1' || in_array('view', $page_new_left_menu) || in_array('view', $menu_left_menu)) { ?>
                                <?php $config_array = array('page_setting','page_new','menu');?>

                                 <?php if($controller == "page_new" OR $controller == "menu") { $class = "active";} else { $class = '';}?>

                                <li class="<?php echo $class; ?>"><a href="javascript:void(0);" class="menu-toggle <?php echo (in_array($sub_menu, $config_array)) ? 'active':''?>"><i class="zmdi zmdi-graduation-cap"></i><span>Static</span> </a>
                                    <ul class="ml-menu" style="display: <?php echo (in_array($sub_menu, $config_array)) ? 'block':'none'?>;">
                                        <?php if($iRoleId == 1){ ?>
                                            <?php if($controller == "page_new") { $class = "active";} else { $class = '';}?>

                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/page_new/page_new');?>">Page</a></li>
                                        <?php } ?>

                                        <?php if(in_array('view', $menu_left_menu)){ ?>
                                            <?php if($controller == "menu") { $class = "active";} else { $class = '';}?>
                                            <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/menu/menu');?>">Menu</a></li>
                                        <?php } ?>
                                        <!-- <li><a href="<?php echo base_url('admin/page_setting/page_setting');?>">Page Setting</a></li> -->
                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if($iRoleId == '1') { ?>
                                <?php $settings_array = array('setting');?>

                                <?php if(($controller == "setting" && $method == "index/Appearance") OR ($controller == "setting" && $method == "Email") OR ($controller == "setting" && $method == "Company")) { $class = "active";} else { $class = '';}?>

                                <li class="<?php echo (in_array($sub_menu, $settings_array)) ? 'active':''?>"><a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">settings</i><span>Settings</span></a>

                                    <ul class="ml-menu" style="display: <?php echo (in_array($sub_menu, $settings_array)) ? 'block':'none'?>;">

                                        <?php if($controller == "setting" && $uri_3 == "Appearance") { $class = "active";} else { $class = '';}?>

                                        <li class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/setting/index/Appearance');?>">General Settings</a></li>
                                        
                                        <?php if($controller == "setting" && $uri_3 == "Email") { $class = "active";} else { $class = '';}?>

                                        <li  class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/setting/index/Email');?>">Email Settings</a></li>

                                       <?php if($controller == "setting" && $uri_3 == "Company") { $class = "active";} else { $class = '';}?>
                                        <li  class="<?php echo $class; ?>"><a href="<?php echo base_url('admin/setting/index/Company');?>">Company Info</a></li>

                                       <?php if($controller == "setting" && $uri_3 == "Meta") { $class = "active";} else { $class = '';}?>
                                        <li class="<?php echo $class; ?>">
                                            <a href="<?php echo base_url('admin/setting/index/Meta');?>">Meta Info
                                            </a>
                                        </li>
                                        <?php if($controller == "setting" && $uri_3 == "Social") { $class = "active";} else { $class = '';}?>
                                        <li class="<?php echo $class; ?>">
                                            <a href="<?php echo base_url('admin/setting/index/Social');?>">Social Info
                                            </a>
                                        </li>
                                        <!-- <li><a href="<?php echo base_url('admin/setting/index/Payment');?>">Payment Settings</a></li> -->
                                    </ul>
                                </li>
                                <?php } ?>
                            
                        <?php }
                    ?>
                   <!--  <?php if($iRoleId == '1') { ?>
                    <?php $config_array = array('order','separate_order','complete_order','contact_us');?>
                        <li><a href="javascript:void(0);" class="menu-toggle <?php echo (in_array($sub_menu, $config_array)) ? 'active':''?>"><i class="material-icons">add_shopping_cart</i><span>Order</span> </a>
                            <ul class="ml-menu" style="display: <?php echo (in_array($sub_menu, $config_array)) ? 'block':'none'?>;">
                                <li><a href="<?php echo base_url('admin/order/order');?>">Order</a></li>
                                <li><a href="<?php echo base_url('admin/order/separate_order');?>">Separate Order</a></li>
                                <li><a href="<?php echo base_url('admin/order/complete_order');?>">Complete Order</a></li>
                            </ul>
                        </li>
                    <?php } ?> -->
                <!--     <?php if(in_array(5, $sub_admin_permission) != '') { ?>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-graduation-cap"></i><span>Order</span> </a>
                        <ul class="ml-menu">
                            <li><a href="<?php echo base_url('admin/order/order_staff');?>">Order</a></li>
                        </ul>
                    </li>
                    <?php } ?> -->
                    
                    <li><a href="<?php echo base_url('admin/login/logout');?>"><i class="zmdi zmdi-device-hub"></i><span>Logout</span> </a></li>
                </ul>
            </div>
        </div>
    </div>    
</aside>


