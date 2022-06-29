<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends MX_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->library('general');
        $this->load->model('admin_model');
        $this->load->model('center/center_model');
        $this->load->model('role/role_model');
        $this->load->model('admin_role/admin_role_model');
    }

	public function index()
	{
		$user_role_permission_info   = $this->general->admin_role_permission_info();
		if(in_array('view', $user_role_permission_info)){
        	$this->template->build('listing',null);
		}else{
			$this->session->set_flashdata('error', "Access Denied" );
			redirect(base_url('admin/dashboard'));
		}
	}

	public function ajax_listing()
	{
		$action = $this->input->post('action');

		if($action == "sort"){
			$column = $this->input->post('column');
			$order = $this->input->post('order');
		} else{
			$column = "iAdminId";
			$order = "DESC";
		}

		if($action == "search"){
			$keyword = $this->input->post('keyword');
		} else {
			$keyword = "";
		}

		if($action == "delete"){
			$id = $this->input->post('id');
			$this->admin_model->delete_by_id($id);
		}

		if($action == "status")
		{
			$iAdminId = $this->input->post('iAdminId');
			$eStatus = $this->input->post('eStatus');

			if($eStatus == "delete_admin"){
				foreach ($iAdminId as $key => $value) {						
					$this->admin_model->delete_by_id($value);
				}
			} else{
				foreach ($iAdminId as $key => $value) {	
					$data['eStatus'] = $eStatus;
					$where = array("iAdminId" => $value);
					$this->admin_model->update($where, $data);
				}
			}
		}

		$criteria['keyword'] 	= $keyword;
		$criteria['column'] 	= $column;
		$criteria['order'] 		= $order;

		// ========Page==========
        $data = $this->admin_model->get_all_data($criteria);

        $pages = 1;

		if($this->input->post('pages') != "")
		{
			$pages = $this->input->post('pages');
		}

		$paginator = new Paginator($pages);
		$paginator->total = count($data);

		$start = ($paginator->currentPage - 1) * $paginator->itemsPerPage;
		$limit = $paginator->itemsPerPage;

		$paginator->is_ajax = true;
		$paging = true;

		$criteria['start']  = $start;
		$criteria['limit']  = $limit;
		$criteria['paging'] = $paging;

		$data['data'] = $this->admin_model->get_all_data($criteria);

		$data['paging'] = $paginator->paginate();
		// ========Page==========

        $data['data'] = $this->admin_model->get_all_data($criteria);
        $this->load->view('ajax_listing', $data);
	}

	public function add() 
	{
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$id = $this->input->post('id');

			$data['vName'] 		= $_POST['vName'];
			$data['vEmail'] 	= $_POST['vEmail'];
			$data['vPhone'] 	= $_POST['vPhone'];
			$data['eStatus'] 	= $_POST['eStatus'];
			if (!empty($this->input->post('iCenterId'))) 
			{
				$data['iCenterId'] 	= $this->input->post('iCenterId');
			}
			else
			{
				$data['iCenterId'] 	= null;
			}

			$data['iRoleId'] 	= $_POST['iRoleId'];
			$data['vIPAddress'] = $_SERVER['REMOTE_ADDR'];

			if($id){
				$data['dtUpdatedDate'] = date("Y-m-d h:i:s");
			}
			else{
				$data['vPassword'] = md5($this->input->post('vPassword'));
				$data['dtAddedDate'] = date("Y-m-d h:i:s");
				$data['dtUpdatedDate'] = date("Y-m-d h:i:s");
			}

			if($_FILES['image']['name'] != "")
			{
				if($_FILES['image']['type'] == 'image/gif'){
					$ext = ".gif";
				} else if($_FILES['image']['type'] == 'image/jpeg'){
					$ext = ".jpeg";
				} else if($_FILES['image']['type'] == 'image/png'){
					$ext = ".png";
				}

				$image = time().$ext;

				$config = array(
					'file_name' => $image,
					'upload_path' => "../assets/uploads/admin/",
					'allowed_types' => "gif|jpg|png|jpeg",
				);

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload('image'))	{
					echo "<pre>";
					print_r($this->upload->display_errors());
					exit;
				}

				$data['vImage'] = $image;
			}

			if($id){

				$data_role['iRoleId'] = 1;
				$data_role['iAdminId'] = $id;

				$where_role = array("iAdminId" => $id);
				$this->admin_role_model->update($where_role, $data_role);		

				$where = array("iAdminId" => $id);
				$this->admin_model->update($where, $data);
				$this->session->set_flashdata('success', "Admin update successfully." );
			} else {
				$id = $this->admin_model->add($data);
				$data_role['iRoleId'] 	= 1;
				$data_role['iAdminId'] 	= $id;
				// echo "<pre>"; print_r($data_role); exit();
				$this->admin_role_model->add($data_role);
			}
			redirect(base_url('admin/admin/admin'));
		} else {
			$user_role_permission_info   = $this->general->admin_role_permission_info();
			if(in_array('add', $user_role_permission_info)){
				$data['center'] = $this->center_model->get_all_data();
				$data['role'] = $this->role_model->get_all_data();

				$criteria = array();
				$criteria['eStatus'] = "Active";
				$data['role'] 		 = $this->role_model->get_all_data($criteria);

				$this->template->build('add',$data);

			}else{
				$this->session->set_flashdata('error', "Access Denied" );
				redirect(base_url('admin/dashboard'));
			}
		}
	}

	public function edit($id) 
	{
		$user_role_permission_info   = $this->general->admin_role_permission_info();
		if(in_array('edit', $user_role_permission_info)){
			$criteria = array();
			$criteria['eStatus'] = "Active";
			$data['role'] = $this->role_model->get_all_data($criteria);

        	$data['data'] = $this->admin_model->get_by_id($id);
        	$data['center'] = $this->center_model->get_all_data();
	    	$this->template->build('add',$data);
		}else{
			$this->session->set_flashdata('error', "Access Denied" );
			redirect(base_url('admin/dashboard'));
		}
	}

	public function change_password($id = "") 
	{
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$id = $this->input->post('id');
			
			$data['vPassword'] = md5($_POST['vPassword']);
			
			$where = array("iAdminId" => $id);
			$this->admin_model->update($where, $data);
			
			redirect(base_url('admin/admin/admin'));
		} else {
			$user_role_permission_info   = $this->general->admin_role_permission_info();
			if(in_array('edit', $user_role_permission_info)){
				$data['admin_role'] 	= $this->admin_role_model->get_by_iAdminId($id);
	    		$data['role'] 			= $this->role_model->get_all_data();
	        	$data['id'] = $id;
				$this->template->build('change_password', $data);
			}else{
				$this->session->set_flashdata('error', "Access Denied" );
				redirect(base_url('admin/dashboard'));
			}
		}
	}

	public function check_unique_email() 
	{
		$iAdminId = $this->input->post('iAdminId');
		$vEmail = $this->input->post('vEmail');

		$data = $this->admin_model->check_unique_email($vEmail, $iAdminId);

		if(count($data) == 1)
		{
			echo "1";
		} else {
			echo '0';
		}
	}
}
