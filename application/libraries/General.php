<?php defined('BASEPATH') OR exit('No direct script access allowed');

//require __DIR__ . '/paypal/paypal.php';
// require __DIR__ . '/mobi_pay/mobi.php';
// require __DIR__ . '/credit_card/credit_card.php';
 //require __DIR__ . '/TextToImage/TextToImage.php';
 // require __DIR__ . '/php-graph-sdk-master/src/facebokk.php';
// require (dirname(__FILE__).'/library/php-graph-sdk-master/src/facebokk.php');
class General
{
    function __construct($config = array())
    {
    }

    function authentication()
    {
        $CI =& get_instance();
        $iUserId = $CI->session->userdata('iUserId');

        if(empty($iUserId)){
            redirect(base_url('login'));
        }
    }

    function get_lang()
    {
        $CI =& get_instance();
        $CI->load->database();

        $vLangCode = "";

        if($CI->session->userdata('vLangCode') != "")
            $vLangCode = $CI->session->userdata('vLangCode');
        else{
            $CI->load->model('language/language_model');
            $primary_lang = $CI->language_model->get_primary_language();

            $session_data['vLangCode'] =  $primary_lang;
            $CI->session->set_userdata($session_data);

            $vLangCode = $CI->session->userdata('vLangCode');
        }

        return $vLangCode;
    }

    function set_lang($vLangCode)
    {
        $CI =& get_instance();
        $session_data['vLangCode'] =  $vLangCode;
        $this->session->set_userdata($session_data);

        return $this->get_lang();
    }

    function date_time_format($date)
    {
        return date("Y/m/d h:i A",strtotime($date));
    }

    function fbtest()
    {
        $fb = new Facebook();
    }

    function date_format($date)
    {
        return date("Y/m/d",strtotime($date));
    }

    // function save_date_format($date)
    // {
    //     $date = explode("/", $date);
    //     return $date[0]."-".$date[1]."-".$date[2];
    // }

    function get_date_format($date)
    {
        if($date != ''){
            return date("d/m/Y",strtotime($date));
        }else{
            echo "";
        } 
    }

    function save_date_format($date)
    {
        $date = explode("/", $date);
        return $date[2]."-".$date[1]."-".$date[0];
    }

    function time_format($time)
    {
        return date("h:i A",strtotime($time));
    }

    function price_format($price)
    {
        return "$".$price;
    }

    // function setting_info($config)
    // {
    //     $CI =& get_instance();
    //     $CI->load->database();
    //     $CI->load->model('setting/setting_model');
    //     return $CI->setting_model->get_setting($config);
    // }


    /*function cart_info()
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('cart/cart_model');
        $iUserId = $CI->session->userdata('iUserId');
        $vCookie = get_cookie('cart_session');
        if($iUserId){
            $data['cart'] = $CI->cart_model->get_by_user($iUserId);
            $count = count($data['cart']);
        } else {
            $data['cart'] = $CI->cart_model->get_by_cookie($vCookie);
            $count = count($data['cart']);
        }
        return $count;
    }*/

    function admin_info()
    {
        $CI =& get_instance();
        $CI->load->database();
        $iAdminId = $CI->session->userdata('iAdminId');
        $CI->load->model('admin/admin_model');
        return $CI->admin_model->get_by_id($iAdminId);
    }

    function banner()
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('banner/banner_model');

        $vLangCode = $this->get_lang();
        return $CI->banner_model->get_banner($vLangCode);
    }

    function get_locations()
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('center/center_model');
        return $CI->center_model->get_locations();
    }

    function get_menu($vMenu)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('menu/menu_model');
        return $CI->menu_model->get_by_vMenu($vMenu);
    }

    function menu()
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('menu/menu_model');

        $vLangCode = $this->get_lang();
        return $CI->menu_model->get_all_data();
    }

    function admin_role_permission_info($dashboard_div = "")
    {
        $CI =& get_instance();
        $CI->load->database();
        $controller = $CI->router->fetch_class();
        $method     = $CI->router->fetch_method();
       
        if ($controller == "admin" && $method == "index") {
            $iModuleId = 3;
        }elseif ($controller == "user" && $method == "index") {
            $iModuleId = 27;
        }elseif ($dashboard_div != "") {
            $CI->load->model('module_master/module_master_model');
            $module_data = $CI->module_master_model->get_by_vModuleName($dashboard_div);
            $iModuleId = $module_data->iModuleId;
        }else{
            $CI->load->model('module_master/module_master_model');
            $module_data = $CI->module_master_model->get_by_vModuleName($controller);
            $iModuleId = $module_data->iModuleId;
        }

        $CI->load->model('admin_role/admin_role_model');
        $CI->load->model('module_permission/module_permission_model');

        $iAdminId  = $CI->session->userdata('iAdminId');

        $data_admin_role = $CI->admin_role_model->get_by_iAdminId($iAdminId);
        $iRoleId = $data_admin_role->iRoleId;
        $result = $CI->module_permission_model->get_by_iRoleId_iModuleId($iRoleId,$iModuleId);
        
        $res_array = array();
        foreach ($result as $value) {
            $res_array[] = $value->vPermission;
        }
        return $res_array;
        
    }


    /*function sub_admin_permission()
    {
        $CI =& get_instance();
        $CI->load->database();
        $iAdminId = $CI->session->userdata('iAdminId');
        $CI->load->model('role/role_model');
        $permission =  $CI->role_model->get_by_subadmin_id($iAdminId);

        $permission_data = "";
            for ($i=0; $i < count($permission); $i++) { 
                $permission_data .= $permission[$i]->iModuleId. ",";
            }
            $permission_data = substr($permission_data, 0,-1);

        return   $module = explode(",", $permission_data);
    }*/

    function replace_content($vTitle){
        $rs_catname = trim(strtolower(($vTitle)));
        $rs_catname = str_replace("/","",$rs_catname);
        $rs_catname = str_replace("G��","",$rs_catname);
        $rs_catname = str_replace("(","",$rs_catname);
       
        $rs_catname = trim(strtolower(($vTitle)));
        $rs_catname = str_replace("/","",$rs_catname);
        $rs_catname = str_replace("G��","",$rs_catname);
        $rs_catname = str_replace("(","",$rs_catname);
        $rs_catname = str_replace(")","",$rs_catname);
        $rs_catname = str_replace("?","",$rs_catname);
        $rs_catname = str_replace("-","-",$rs_catname);
        $rs_catname = str_replace("#","",$rs_catname);
        $rs_catname = str_replace(",","",$rs_catname);
        $rs_catname = str_replace(";","",$rs_catname);
        $rs_catname = str_replace(":","",$rs_catname);
        $rs_catname = str_replace("'","",$rs_catname);
        $rs_catname = str_replace("\"","",$rs_catname);
        $rs_catname = str_replace("++","-",$rs_catname);
        $rs_catname = str_replace("+","-",$rs_catname);
        $rs_catname = str_replace("+","-",$rs_catname);
        $rs_catname = str_replace("+�","-",$rs_catname);
        //$rs_catname = str_replace("s","_",$rs_catname);

        $rs_catname = str_replace(" ","-",str_replace("&","and",$rs_catname));
        return $rs_catname;
    }

    function send_notifiction1($vCode, $data = array()){
        $CI =& get_instance();
        $CI->load->database();

        $CI->load->model('notification_master/notification_master_model');
        $notification = $CI->notification_master_model->get_notification_by_code($vCode);

        if($notification->eEmail == 'Yes'){
            $CI->load->helper(array('email')); 
            $CI->load->library('email');

            $CI->load->model('setting/setting_model');

            $company_setting = $CI->setting_model->get_setting('Company');

            $rights = $company_setting['COPYRIGHTED_TEXT']['vValue'];
            $rights = str_replace("#CURRENT_YEAR#", date("Y"), $rights);

            $constant   = array('#SITE_NAME#', '#SITE_URL#','#COPYRIGHTS#');
            $value      = array($company_setting['COMPANY_NAME']['vValue'], base_url(), $rights);

            $stream_opts = [
                "ssl" => [
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ]
            ];  

            $header_text = file_get_contents(base_url('assets/uploads/email/header.html'),false, stream_context_create($stream_opts));
            $header  = str_replace("#LOGO#", base_url('assets/uploads/logo/logo.png'), $header_text);
            $header  = str_replace("#LOGO_EMAIL#", base_url('assets/uploads/logo/logo.png'), $header);
            $header  = str_replace("#BG#", base_url('assets/front/images/logo_bg.png'), $header);
            $header  = str_replace("#SITE_NAME#", $company_setting['COMPANY_NAME']['vValue'], $header);

            $footer_text = file_get_contents(base_url('assets/uploads/email/footer.html'),false, stream_context_create($stream_opts));
            $footer  = str_replace($constant, $value, $footer_text);


            $data['message'] = $header.$data['message'].$footer;

            $email_setting = $CI->setting_model->get_setting('Email');

            $config['protocol']     = 'smtp';
            $config['smtp_host']    = $email_setting['SMTP_HOST']['vValue'];
            $config['smtp_crypto']  = $email_setting['EMAIL_PROTOCOL']['vValue'];
            $config['smtp_port']    = $email_setting['SMTP_PORT']['vValue'];

            $config['smtp_user']    = $email_setting['SMTP_USERNAME']['vValue'];
            $config['smtp_pass']    = $email_setting['SMTP_PASS']['vValue'];

            $CI->email->initialize($config);

            $CI->email->set_newline("\r\n");  
            $CI->email->set_mailtype("html");
            
            $CI->email->from($email_setting['SMTP_USERNAME']['vValue']);
            $CI->email->to($data['to']);
            $CI->email->subject($data['subject']);
            $CI->email->message($data['message']);
            if ($data['attach'] != "") {
                $CI->email->attach($data['attach']);
            }

            $CI->email->send();

            // echo "<pre>"; print_r($CI->email->print_debugger());exit;
        }

        if($notification->eInternalMessage == 'Yes'){
            
        }

        if($notification->eSms == 'Yes1'){
            $sms_setting = $CI->setting_model->get_setting('SMS');
            echo "<pre>"; print_r($sms_setting); exit();

            $sid = $sms_setting['SMS_SID']['vValue'];;
            $token = $sms_setting['SMS_TOKEN']['vValue'];
            $client = new Client($sid, $token);

            $client->messages->create(
                '+919824800872',
                array(
                    'from' => $sms_setting['SMS_FROM']['vValue'],
                    'body' => "hello"
                )
            );
            
        }
    }

    function social_info1()
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('setting/setting_model');
        return $CI->setting_model->get_setting('Social');
    }

    function payment_info1()
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('setting/setting_model');
        return $CI->setting_model->get_setting('Payment');
    }

    function mobi_card_process($config, $user, $vExamCode, $amount) 
    {
        $config = new Mobi($config);
        $data = $config->card_process($vExamCode, $user, $amount);
        return $data->STR;
    }

    function mobi_card_response($config) 
    {
        $config = new Mobi($config);
        $response = $config->card_response();

        return $response;
    }

    function mobi_sms_process($config, $user, $vExamCode, $amount) 
    {
        $config = new Mobi($config);
        $data = $config->sms_process($vExamCode, $user, $amount);
        return $data->STR;
    }


    function mobi_sms_response($config) 
    {
        $config = new Mobi($config);
        $response = $config->sms_response();

        return $response;
    }

    function payment($config, $payment_data) 
    {
        $paypal = new Paypal($config);

        $paypal->process_form($payment_data);
        $paypal->submit_form();exit;
    }

    function credit_card_payment($payment_setting, $payment_data) 
    {
        $paypal = new credit_card($payment_setting);
        return $paypal->payment_process($payment_data);
    }

    function meta_info1()
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('setting/setting_model');
        $CI->load->model('page_new/page_new_model');
        $setting = $CI->setting_model->get_setting('Meta');
       
        $controller = $CI->router->fetch_class();
        $method     = $CI->router->fetch_method(); 
        // $CI->load->model('setting/setting_model');
        // return $CI->setting_model->get_setting('Meta');
       if($controller == "page_new" && $method == "page_preview2") 
       {
            $page_code = $CI->uri->segment(1);
            $criteria['vPageCode'] = $page_code;
            $page_data = $CI->page_new_model->get_by_vPageCode($criteria);
            if ($page_data->tMetaTitle != "" ) 
            {
                $meta_info['META_TITLE']['vValue']        =  'Evergreen - '.$page_data->tMetaTitle;
                $meta_info['META_KEYWORD']['vValue']      =  'Evergreen - '.$page_data->tMetaKeyword;
                $meta_info['META_DESCRIPTION']['vValue']  =  'Evergreen - '.$page_data->tMetaDesc;
            }
            else
            {
                $meta_info['META_TITLE']['vValue']        =  $setting['META_TITLE']['vValue'];
                $meta_info['META_KEYWORD']['vValue']      =  $setting['META_KEYWORD']['vValue'];
                $meta_info['META_DESCRIPTION']['vValue']  =  $setting['META_DESCRIPTION']['vValue'];
            }
             return $meta_info;
        }
        else 
        {
            return $CI->setting_model->get_setting('Meta');
        }
    }

    function get_all_center()
    {
        $criteria['eStatus'] = "Active";

        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('center/center_model');
        return $CI->center_model->get_all_data($criteria);
    }

     function get_page_image($iPageImageId)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->model('page_image/page_image_model');
        return $CI->page_image_model->get_by_id($iPageImageId);
    }
}

