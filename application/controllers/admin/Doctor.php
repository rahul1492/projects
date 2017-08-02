<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doctor extends CI_Controller  
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getResetlink($userId='')
	{
		/*
		Reset function sets encrypted confirmation code and verification status will reset to "0"
		*/
		$where = array("id" => $userId);
		$set = array(
			'confirmation_code' => md5($userId),
			'verification_status' => "0"
			);
		
		$edit_record =$this->master_model->updateRecord('user_registration',$set,$where);
			
		return base_url().'front/doctor/reset/'.$set['confirmation_code'];
	}

	public function add($value='')
	{
		$data['success']=$data['error']='';
		if(isset($_POST['add_user']))
		{
			$this->form_validation->set_rules('first_name','First Name','required');
			$this->form_validation->set_rules('last_name','Last Name','required');
			$this->form_validation->set_rules('email_id','Email Id','required|valid_email|is_unique[user_registration.user_email]');
			$this->form_validation->set_rules('gender','Gender','required');
			$this->form_validation->set_rules('phone','Phone','required|numeric');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('addr_line_1','Address','required');
			$this->form_validation->set_rules('addr_line_2','Street/Town','required');
			$this->form_validation->set_rules('state','State','required|numeric');
			$this->form_validation->set_rules('city','City','required|numeric');
			$this->form_validation->set_rules('pin_code','Pin Code','required|numeric');			

			if($this->form_validation->run() == TRUE)
			{
				$password = $this->input->post('password');

				$array_data							=	array();
				$array_data['user_firstname']		=	$this->input->post('first_name');
				$array_data['user_lastname']		=	$this->input->post('last_name');
				$array_data['user_email']			=	$this->input->post('email_id');
				$array_data['user_gender']			=	$this->input->post('gender');
				$array_data['user_password']		=	md5($password);
				$array_data['user_phonenumber']		=	$this->input->post('phone');
				$array_data['user_address1']		=	$this->input->post('addr_line_1');
				$array_data['user_address2']		=	$this->input->post('addr_line_2');
				$array_data['user_state_id']		=	$this->input->post('state');				
				$array_data['user_city_id']			=	$this->input->post('city');	
				$array_data['user_pincode']			=	$this->input->post('pin_code');
				$array_data['verification_status']	=	'0';
				$array_data['user_status']			=	'1';
				$array_data['type']					=	'doctor';

				///////////inserting records/////////////
				if($userId=$this->master_model->insertRecord('user_registration',$array_data,true))
				{
		  
			        $email_data=array(
			          	'reset_link' => $this->getResetlink($userId),
			          	'email' => $array_data['user_email'],
			          	'name' =>$array_data['user_firstname']
			        );

		        	$this->load->library('email_template');
		        	$result = $this->email_template->activation_email($email_data);

		        	if($result){
		        		echo "Success";
		        	}
		        	
				$this->session->set_flashdata('success','New Doctor Added Successfully!!');
				redirect(base_url().ADMIN_CTRL.'/doctor/manage');
				}
				else
				{
					$this->session->set_flashdata('error',' Error While adding New User.');
					redirect(base_url().ADMIN_CTRL.'/doctor/add');
				}		
			}
		}
		
		$data['state_data'] =  $this->master_model->getRecords('state','','',array('state_name' => 'ASC'));
		$data['page_title']	= PROJECT_NAME.' | Add Doctor';
		$data['content']	=ADMIN_CTRL.'/doctor/doctor_add';
		$this->load->view(ADMIN_VIEW.'/template',$data);		
	}

	public function edit($id){

	if(isset($id)!=''){
		$id_edit= $id;
		$id=base64_decode($id);
		
		if(isset($_POST['doctor_edit'])){

			$this->form_validation->set_rules('first_name','First Name','required');
			$this->form_validation->set_rules('last_name','Last Name','required');
			$this->form_validation->set_rules('phone','Phone','required|numeric');
			$this->form_validation->set_rules('addr_line_1','Address','required');
			$this->form_validation->set_rules('addr_line_2','Street/Town','required');
			$this->form_validation->set_rules('state','State','required|numeric');
			$this->form_validation->set_rules('city','City','required|numeric');
			$this->form_validation->set_rules('pin_code','Pin Code','required|numeric');	

			if($this->form_validation->run() == TRUE)
			{

				$array_data							=	array();
				$array_data['user_firstname']		=	$this->input->post('first_name');
				$array_data['user_lastname']		=	$this->input->post('last_name');
				$array_data['user_phonenumber']		=	$this->input->post('phone');
				$array_data['user_address1']		=	$this->input->post('addr_line_1');
				$array_data['user_address2']		=	$this->input->post('addr_line_2');
				$array_data['user_state_id']		=	$this->input->post('state');				
				$array_data['user_city_id']			=	$this->input->post('city');	
				$array_data['user_pincode']			=	$this->input->post('pin_code');
		
					$edit_record = $this->master_model->updateRecord('user_registration',$array_data, array("id"=>$id));
					if($edit_record == TRUE)
					{
						$this->session->set_flashdata('success',' Profile Updated Successfully!');
						redirect(base_url().ADMIN_CTRL.'/doctor/edit/'.$id_edit);
					}
					else
					{
						$this->session->set_flashdata('error',' Error while editing profile.');
						redirect(base_url().ADMIN_CTRL.'/doctor/edit/'.$id_edit);
					}
				}
			}


  				$data['record']=	$this->master_model->getRecords('user_registration',array("id"=>$id));
  				
				$data['state_data'] =  $this->master_model->getRecords('state','','',array('state_name' => 'ASC'));			
				
  				$array_city['state_id'] = $data['record'][0]['user_state_id'];

				$data['city_data'] =  $this->master_model->getRecords('city',$array_city,'',array('city_name' => 'ASC'));
				$data['page_title']		=PROJECT_NAME.' | Doctor Edit';
				$data['page_name']		= 'Doctor Edit';
				$data['content']		=ADMIN_CTRL.'/doctor/doctor_edit';
				$this->load->view(ADMIN_VIEW.'/template',$data);	
			}
	}

	public function manage()
	{
		// $condition  = isset($_POST['search_name'])? "`user_firstname` LIKE '".$_POST['search_name']."%' AND type='doctor'":"type='doctor'";

		// if(isset($_POST['search_name'])){

		// 	$condition="`user_firstname` LIKE '".$_POST['search_name']."%' AND type='doctor'";
		// 	$data['page'] = 0;
		// }else{

		// 	$condition=(isset($condition)? $condition : '');
		// 	$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// }

		// $array_cond =  array("type"=>'doctor');
		// $rows_count = $this->master_model->getRecordCount('user_registration',$condition);

		// $data['blocked'] = $this->master_model->getRecordCount('user_registration',array('user_status'=>'0','type'=>'doctor'));

		// $config['base_url'] = base_url().ADMIN_CTRL.'/doctor/manage';
		// $config['total_rows'] = $this->master_model->getRecordCount('user_registration',$condition);
		// $config['per_page'] = isset($_POST['perpage'])? $_POST['perpage'] : 10; 
		// $config['uri_segment'] = 4;

		// $config['next_link'] = 'Next →';
		// $config['next_tag_open'] = '<li>';
		// $config['next_tag_close'] = '</li>';

		// $config['prev_link'] = '← Prev';
		// $config['prev_tag_open'] = '<li>';
		// $config['prev_tag_close'] = '</li>';

		// $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
		// $config['cur_tag_close'] = '</a></li>';

		// $config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
		// $config['full_tag_close'] = '</ul></div>';

		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';

		// $this->pagination->initialize($config); 
		// $data['pagination']= $this->pagination->create_links();

		// $data['per_page'] 		= $config['per_page'];
	
		// $data['user_registration_records'] 	= $this->master_model->getRecords('user_registration',$condition,'',array("id"=>'ASC'),$data['page'] ,$config['per_page']);
		// $data['totaldoctors'] = $this->master_model->getRecordCount('user_registration', array('type'=>'doctor'));

		// $data['total'] = $rows_count;

		// $data['page_title']		=	PROJECT_NAME.' | Manage Doctor Registration';

		$perpage=isset($_POST['per_page'])? $_POST['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1):0;

		$searchName 	= 	$this->input->get('search_name');

		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM user_registration WHERE user_firstname like "'.$searchName.'%" AND type="doctor"';
			$data['total'] = 	$this->db->query($sqlQry)->num_rows();
		}
		else
		{
			$sqlQry  = "SELECT * FROM user_registration WHERE type='doctor'" ;	
			$data['total'] = $this->master_model->getRecordCount('user_registration',array('type'=>'doctor'));
		}

		$data['blocked'] = $this->master_model->getRecordCount('user_registration',array('user_status'=>'0','type'=>'doctor'));
		$dataCnt 		= 	$this->db->query($sqlQry);

		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/doctor/manage?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['user_registration_records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage Doctor';
		$data['module_name'] = 'Manage Doctor';

		$data['content']		=	ADMIN_CTRL.'/doctor/doctor_manage';
		$this->load->view(ADMIN_VIEW.'/template',$data);			
	}

	public function commonPagination($segmnetUri,$baseUrl,$totalRec,$configuri,$numOfRec='')
	{
		$resp = array();
        $page_number = $segmnetUri;
        $page_url = $config['base_url'] = $baseUrl;
        $config['uri_segment'] = $configuri;
        if(empty($numOfRec))
        {$numOfRec = 25;}
        $config['per_page'] = $resp['per_page'] = $numOfRec;
        $config['num_links'] = 4;
        if(empty($page_number)) $page_number = 1;
        $offset = ($page_number-1) * $config['per_page'];
        $resp['offset'] = $offset;
        $config['use_page_numbers'] = TRUE; 
        $config['page_query_string'] = TRUE; 
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $totalRec;        
        $page_url = $page_url.'/'.$page_number;
        $config['full_tag_open'] = '<div><nav><ul class="pagination pagination-sm pagination-colory">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="'.$page_url.'">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';     
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';        
        $this->pagination->cur_page = $offset;
        $this->pagination->initialize($config);
        $config['page_links'] = $this->pagination->create_links();
        $resp['page_links'] = $config['page_links'] ;
        return $resp;
	}


	// public function view($id)
	// {
		

	// 	if(isset($id)!='')
	// 	{
	// 		$data['success']=$data['error']	='';
	// 			$this->db->select('tbl_user_registration_address_master.*,tbl_country_master.country_name,tbl_state_master.state_name,tbl_city_master.city_name');
	// 			$this->db->join('tbl_country_master','tbl_country_master.id=tbl_user_registration_address_master.user_country');
	// 			$this->db->join('tbl_state_master','tbl_state_master.id=tbl_user_registration_address_master.user_state');
	// 			$this->db->join('tbl_city_master','tbl_city_master.id=tbl_user_registration_address_master.user_city');
	// 			$data['view_user_registration_address'] = $this->Master_model->getRecords('tbl_user_registration_address_master',array("user_id"=>$id),'',array("id"=>'ASC'));

	// 			//$data['view_user_registration_address'] = $this->master_model->getRecords('tbl_user_registration_address_master',array("user_id"=>$id));
	// 			$data['view_user_registration_show']  	= $this->master_model->getRecords('user_registration',array("id"=>$id));
	// 			$data['page_title']					  	= PROJECT_NAME.' | Doctor Details';
	// 			$data['content']					  	= ADMIN_CTRL.'/doctor_view';
	// 			$this->load->view(ADMIN_VIEW.'/template',$data);	

	// 		}
	// 		else
	// 		{
	// 			redirect(base_url().ADMIN_CTRL.'/doctor/manage');
	// 		}
	// }

	public function unblock($id)///////vikas////////unblock color function
	{
		if(isset($id)!='')
		{
			$id = base64_decode($id);
			$array_data	= array("user_status"=>'1');
			$array_cond	= array("id"=>$id);

			$block = $this->master_model->updateRecord('user_registration',$array_data,$array_cond);

			$data['error']='';
			if($block == TRUE)
			{
				$this->session->set_flashdata('success','Doctor Unblock Successfully');
				redirect(base_url().ADMIN_CTRL.'/doctor/manage');
			}
			else
			{
				$this->session->set_flashdata('error','Error while Unblocking record');
				redirect(base_url().ADMIN_CTRL.'/doctor/manage');	
			}

		}
		else
		{
			redirect(base_url().ADMIN_CTRL.'/doctor/manage');
		}	
	}

	public function unblock_page($id)///////vikas////////unblock color function
	{
		if(isset($id)!='')
		{
			$id = base64_decode($id);
			$array_data	= array("user_status"=>'1');
			$array_cond	= array("id"=>$id);

			$block = $this->master_model->updateRecord('user_registration',$array_data,$array_cond);

			$data['error']='';
			if($block == TRUE)
			{
				$this->session->set_flashdata('success','Doctor Unblock Successfully');
				redirect(base_url().ADMIN_CTRL.'/doctor/blocked_doctors');
			}
			else
			{
				$this->session->set_flashdata('error','Error while Unblocking record');
				redirect(base_url().ADMIN_CTRL.'/doctor/blocked_doctors');	
			}

		}
		else
		{
			redirect(base_url().ADMIN_CTRL.'/doctor/blocked_doctors');
		}	
	}

	public function block($id)
	{
			if(isset($id)!='')
			{	
				$id = base64_decode($id);
				$array_data	= array("user_status"=>'0');
				$array_cond	= array("id"=>$id);

				$block = $this->master_model->updateRecord('user_registration',$array_data,$array_cond);

				$data['error']='';
				if($block == TRUE)
				{
					$this->session->set_flashdata('success','Doctor Block Successfully');
					redirect(base_url().ADMIN_CTRL.'/doctor/manage');
				}
				else
				{
					$this->session->set_flashdata('error','Error while blocking record');
					redirect(base_url().ADMIN_CTRL.'/doctor/manage');	
				}

			}
			else
			{
				redirect(base_url().ADMIN_CTRL.'/doctor/manage');
			}	
		}	

	public function multi_action()
	{
		// print_r($_POST); die();
		if($_POST['action']=='delete'){
				foreach ($_POST['chk'] as $key) {
					$delete = $this->master_model->deleteRecord('user_registration',array("id"=>$key));
				}
				if($delete==TRUE){
					$this->session->set_flashdata('success',' Selected Doctor Deleted Successfully');
					redirect(base_url().ADMIN_CTRL.'/doctor/manage');
				}else{
					$this->session->set_flashdata('error','Error While Deleting Selected Doctor. ');
					redirect(base_url().ADMIN_CTRL.'/doctor/manage');
				}
			}
			if($_POST['action']=='block'){
				foreach ($_POST['chk'] as $key) {
					$id=$key;
					$data = array("user_status"=>'0');	
					$condition = array("id"=>$id);
					$block = $this->master_model->updateRecord('user_registration',$data,$condition);
				}
				$this->session->set_flashdata('success',' Selected Doctor Blocked Successfully');
				redirect(base_url().ADMIN_CTRL.'/doctor/manage');
			}
			if($_POST['action']=='unblock'){
				foreach ($_POST['chk'] as $key) {
					$id=$key;
					$data = array("user_status"=>'1');	
					$condition = array("id"=>$id);
					$block = $this->master_model->updateRecord('user_registration',$data,$condition);
				}
				$this->session->set_flashdata('success',' Selected Doctor Unblocked Successfully');
				redirect(base_url().ADMIN_CTRL.'/doctor/manage');
			}
		
	}

	public function delete($id) 
	{
			if(isset($id)!='')
			{
				$id = base64_decode($id);
				$delete = $this->master_model->deleteRecord('user_registration',array("id"=>$id));

				$data['error']='';
				if($delete == TRUE)
				{
					$this->session->set_flashdata('del_success','Record Deleted Successfully');
					redirect(base_url().ADMIN_CTRL.'/doctor/manage');
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleteing record');
					redirect(base_url().ADMIN_CTRL.'/doctor/manage');
				}	

			}
			else
			{
				redirect(base_url().ADMIN_CTRL.'/doctor/manage');
			}	
	}

	public function blocked_doctors()
	{	
		// $condition=isset($_POST['search_name'])? "`user_firstname` LIKE '".$_POST['search_name']."%' AND user_status='0' AND type='doctor'":"user_status='0' AND type='doctor'";
		// // $condition['category_status']= '0';

		// $rows_count = $this->master_model->getRecordCount('user_registration', array('type'=>'doctor'));
		// $data['blocked'] = $this->master_model->getRecordCount('user_registration',array('user_status'=>'0','type'=>'doctor'));
		// $config['base_url'] = base_url().ADMIN_CTRL.'/doctor/blocked_doctors';
		// $config['total_rows'] = $this->master_model->getRecordCount('user_registration',$condition);
		// $config['per_page'] = isset($_POST['perpage'])? $_POST['perpage'] : 10;
		// $config['uri_segment'] = 4;

		// $config['next_link'] = 'Next →';
		// $config['next_tag_open'] = '<li>';
		// $config['next_tag_close'] = '</li>';

		// $config['prev_link'] = '← Prev';
		// $config['prev_tag_open'] = '<li>';
		// $config['prev_tag_close'] = '</li>';

		// $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
		// $config['cur_tag_close'] = '</a></li>';

		// $config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
		// $config['full_tag_close'] = '</ul></div>';

		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';

		// $this->pagination->initialize($config); 
		// $data['pagination']= $this->pagination->create_links();

		// $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// $data['totaldoctors'] = $rows_count;

		// $data['per_page'] 		= $config['per_page'];
		// //$array_cond =  array("type"=>'user',"user_status"=>'0');
		// $data['user_registration_records'] 	= $this->master_model->getRecords('user_registration',$condition,'',array("id"=>'ASC'),$data['page'] ,$config['per_page']);

		// $data['total'] = $config['total_rows']; 
		// $data['page_title']		=	PROJECT_NAME.' | Manage Doctor';
	
		$perpage=isset($_POST['per_page'])? $_POST['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1):0;

		$searchName 	= 	$this->input->get('search_name');

		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM user_registration WHERE user_firstname like "'.$searchName.'%" AND user_status="0" AND type="doctor"';
			$data['blocked'] = 	$this->db->query($sqlQry)->num_rows();
		}
		else
		{
			$sqlQry  = "SELECT * FROM user_registration WHERE type='doctor' AND user_status='0'" ;	
			$data['blocked'] = $this->master_model->getRecordCount('user_registration',array('user_status'=>'0','type'=>'doctor'));
		}
		
		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total'] = $this->master_model->getRecordCount('user_registration',array('type'=>'doctor'));
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/doctor/blocked_doctors?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['user_registration_records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage Doctor';
		$data['module_name'] = 'Manage Doctor';
		$data['content']		=	ADMIN_CTRL.'/doctor/blocked_doctors';
		$this->load->view(ADMIN_VIEW.'/template',$data);	
	}

	public function getcity_records($value=''){

		$data['state_id'] 		= $this->input->post('state_id');
		$response = $this->master_model->getRecords('city',$data,'',array("city_id"=>'ASC'));

		echo json_encode($response);
	}
}
