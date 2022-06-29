<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MX_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('setting_model');
        $this->load->model('language/language_model');
        $this->load->model('setting_lang/setting_lang_model');
    }

	public function index($mode = '')
	{
        $data['mode'] = $mode;

        $data['settings'] = $this->setting_model->get_all_settings($mode);
        $this->template->build('setting',$data);
	}

	public function setting_edit() 
	{
		$mode = $this->input->post('mode');

    	if($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$settings = $this->setting_model->get_all_settings($mode);

			foreach ($settings as $key => $value) {
				$data = array();

				if($value->vName == 'COMPANY_LOGO'){
					if($_FILES[$value->vName]['name'] != ""){
						$image = 'logo.png';

						$config = array(
							'file_name' => $image,
							'upload_path' => "../assets/uploads/logo/",
							'allowed_types' => "png",
							'overwrite' => TRUE,
						);

						$this->load->library('upload', $config);

						if(!$this->upload->do_upload($value->vName))	{
							echo "<pre>";
							print_r($this->upload->display_errors());
							exit;
						}

						$data['vValue'] = $image;
						$where = array("vName" => $value->vName);
						$this->setting_model->setting_update($where, $data);

					}
				} else if($value->vName == 'COMPANY_FAVICON'){
					if($_FILES[$value->vName]['name'] != ""){
						$image = 'favicon.png';

						$config = array(
							'file_name' => $image,
							'upload_path' => "../assets/uploads/logo/",
							'allowed_types' => "png",
							'overwrite' => TRUE,
						);

						$this->load->library('upload', $config);

						if(!$this->upload->do_upload($value->vName))	{
							echo "<pre>";
							print_r($this->upload->display_errors());
							exit;
						}

						$data['vValue'] = $image;
						$where = array("vName" => $value->vName);
						$this->setting_model->setting_update($where, $data);
					}
				} else if($value->vName == 'COMPANY_ADMIN_LOGO'){
					if($_FILES[$value->vName]['name'] != ""){
						$image = 'logo-admin.png';

						$config = array(
							'file_name' => $image,
							'upload_path' => "../assets/uploads/logo/",
							'allowed_types' => "png",
							'overwrite' => TRUE,
						);

						$this->load->library('upload', $config);

						if(!$this->upload->do_upload($value->vName))	{
							echo "<pre>";
							print_r($this->upload->display_errors());
							exit;
						}

						$data['vValue'] = $image;
						$where = array("vName" => $value->vName);
						$this->setting_model->setting_update($where, $data);
					}
				}else if($value->vName == 'TESTIMONIAL_IMAGE'){
					if($_FILES[$value->vName]['name'] != ""){
						$image = 'testimonial.png';

						$config = array(
							'file_name' => $image,
							'upload_path' => "../assets/uploads/testimonial/",
							'allowed_types' => "png",
							'overwrite' => TRUE,
						);

						$this->load->library('upload', $config);

						if(!$this->upload->do_upload($value->vName))	{
							echo "<pre>";
							print_r($this->upload->display_errors());
							exit;
						}

						$data['vValue'] = $image;
						$where = array("vName" => $value->vName);
						$this->setting_model->setting_update($where, $data);
					}
				} else {

						$data['vValue'] = $_POST[$value->vName];
						
						$where = array("vName" => $value->vName);
						$this->setting_model->setting_update($where, $data);
				}
			}
		}
		
		redirect(base_url('admin/setting/index/'.$mode));
	}
}