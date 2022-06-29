<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcomApache/2.4.29 (Ubuntu) Server at local.subscription.com Port 80e" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 	= "content";
$route['404_override'] 			= '';

$route['about'] 						= 'page_new/page_preview2/about-us';
$route['about-us'] 						= 'page_new/page_preview2/about-us';
$route['healthy-eating'] 				= 'page_new/page_preview2/healthy-eating';
$route['how-we-differ'] 				= 'page_new/page_preview2/how-we-differ';
$route['our-values'] 					= 'page_new/page_preview2/our-values';
$route['our-centre'] 					= 'page_new/page_preview2/our-centre';
$route['our-rooms'] 					= 'page_new/page_preview2/our-rooms';
$route['curriculum'] 					= 'page_new/page_preview2/curriculum';
$route['orientation'] 					= 'page_new/page_preview2/orientation';
$route['operating-hours'] 				= 'page_new/page_preview2/operating-hours';
$route['fees-and-govt-subsidies'] 		= 'page_new/page_preview2/fees-and-govt-subsidies';
$route['why-we-are-different'] 			= 'page_new/page_preview2/why-we-are-different';
$route['our-team'] 						= 'page_new/page_preview2/our-team';
$route['menu'] 							= 'page_new/page_preview2/menu';
$route['recipes'] 						= 'page_new/page_preview2/recipes';
$route['identity'] 						= 'page_new/page_preview2/identity';
$route['our-world'] 					= 'page_new/page_preview2/our-world';
$route['wellbeing'] 					= 'page_new/page_preview2/wellbeing';
$route['learners'] 						= 'page_new/page_preview2/learners';
$route['communicators'] 				= 'page_new/page_preview2/communicators';
$route['sustainability'] 				= 'page_new/page_preview2/sustainability';
$route['krupesh'] 							= 'page_new/page_preview2/krupesh';
$route['page/(:any)'] 					= 'page_new/page_preview2/$1';

$route['family-handbook'] 				= 'content/family_handbook';
$route['cj-goes-to-evergreen'] 			= 'content/cj_goes_to_evergreen';

$route['message/(:any)'] 				= 'message1/messages/$1';
$route['thankyou'] 						= 'message1/thank_you';

$route['activities'] 					= 'activities';
$route['centre'] 						= 'center';
$route['activities_detail/(:any)'] 		= 'activities/activities_detail/$1';

$route['related_page/(:any)'] 			= 'related_page/related_page_detail/$1';

// $route['page/(:any)'] 					= "page/pages/$1";
$route['faq'] 							= 'faq';
$route['mailing'] 						= 'newsletter';
$route['forgot-password'] 				= 'login/forgot_password';

$route['contact-us'] 					= 'contact_us/contact_us';

$route['plan_detail'] 					= 'plan/plan_detail';
$route['buy_plan'] 						= 'plan/buy_plan';

$route['repair'] 						= 'repair';
$route['cover/(:any)'] 					= 'cover/appliance/$1';

$route['blog_detail/(:any)'] 			= 'blog/blog_detail/$1';

$route['enrol'] 						= 'parents';

/* End of file routes.php */
/* Location: ./application/config/routes.php */