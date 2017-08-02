<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller  
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('master_model');
		//$this->load->model('email_sending');
		if($this->session->userdata('admin_info') == "")
		{
			redirect(base_url().ADMIN_CTRL.'/login');
		}
	}


	public function manage()
	{	

		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
		$data['total'] = $this->master_model->getRecordCount('user_registration',array('type'=>'user'));

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM user_registration WHERE type="user" AND user_firstname like "'.$searchName.'%"';
			$data['total'] = 	$this->db->query($sqlQry)->num_rows();	
		}
		else
		{
			$sqlQry  = 'SELECT * FROM user_registration WHERE type="user"' ;
			$data['total'] = 	$this->db->query($sqlQry)->num_rows();	
		}

		$data['blocked'] = $this->master_model->getRecordCount('user_registration',array('user_status'=>'0','type'=>'user'));
		//$data['all'] = $this->master_model->getRecordCount('user_registration',array('type'=>'user'));
		$dataCnt 		= 	$this->db->query($sqlQry);

		$pageNum 		= 	$this->input->get('page');
		
		$pageURL		= 	base_url().ADMIN_CTRL.'/user/manage?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['links']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['dataRes']= 	$dataSql->result_array();
		//$data['total']  = 	count($data['dataRes']);

		/*echo '<pre>';
		echo $data['links'];
		print_r($data['blocked']);

		die;
		*/
		$data['page_title'] = PROJECT_NAME.' | Manage User';
		$data['content'] = ADMIN_CTRL.'/user/user_registration';
		$data['search_name'] = isset($searchName) && $searchName!=''?$searchName:'';
		$this->load->view(ADMIN_VIEW.'/template',$data);	
	
	}

	public function blocked_users()
	{	

		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
		$data['total'] = $this->master_model->getRecordCount('user_registration',array('type'=>'user','user_status'=>'0'));
		
		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM user_registration WHERE type="user" AND user_status="0" AND user_firstname like "'.$searchName.'%"';
			$data['total'] = 	$this->db->query($sqlQry)->num_rows();
		}
		else
		{
			$sqlQry  = 'SELECT * FROM user_registration WHERE type="user" AND user_status="0"' ;	
			$data['total'] = 	$this->db->query($sqlQry)->num_rows();
		}
		$data['blocked'] = $this->master_model->getRecordCount('user_registration',array('user_status'=>'0','type'=>'user'));

		
		$data['all'] = $this->master_model->getRecordCount('user_registration',array('type'=>'user'));
		
		$dataCnt 		= 	$this->db->query($sqlQry);

		$pageNum 		= 	$this->input->get('page');
		
		$pageURL		= 	base_url().ADMIN_CTRL.'/user/blocked_users?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['links']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['dataRes']= 	$dataSql->result_array();
		//$data['total']  = 	count($data['dataRes']);

		/*echo '<pre>';
		echo $data['links'];
		print_r($data['dataRes']);

		die;*/
		$data['page_title'] = PROJECT_NAME.' | Manage Blocked User';
		$data['content']		=	ADMIN_CTRL.'/user/blocked_users';
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$this->load->view(ADMIN_VIEW.'/template',$data);	

	}

	public function view($id)
	{
			if(isset($id)!='')
		    {
			    $data['success']=$data['error']	='';
				
				$data['view_user_registration_show']  	= $this->master_model->getRecords('user_registration',array("id"=>$id));
				$data['page_title']					  	= PROJECT_NAME.' | Edit User Registration';
				$data['content']					  	= ADMIN_CTRL.'/user/user_registration_view';
				$this->load->view(ADMIN_VIEW.'/template',$data);	
			}
			else
			{
				redirect(base_url().ADMIN_CTRL.'/user_registration/manage');
			}

		}


		public function delete($id) 
		{
			if(isset($id)!='')
			{	
				$id=base64_decode($id);
				$delete = $this->master_model->deleteRecord('user_registration',array("id"=>$id));

				$data['error']='';
				if($delete == TRUE)
				{
					$this->session->set_flashdata('del_success','Record Deleted Successfully');
					redirect(base_url().ADMIN_CTRL.'/user/manage');
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleteing record');
					redirect(base_url().ADMIN_CTRL.'/user/manage');
				}	

			}
			else
			{
				redirect(base_url().ADMIN_CTRL.'/User/manage');
			}	
		}


		public function block($id)
		{	

			if(isset($id)!='')
			{
				$id=base64_decode($id);
				$array_data	= array("user_status"=>'0');
				$array_cond	= array("id"=>$id);

				$block = $this->master_model->updateRecord('user_registration',$array_data,$array_cond);

				$data['error']='';
				if($block == TRUE)
				{
					
					$this->session->set_flashdata('success',' User Blocked Successfully');
					redirect(base_url().ADMIN_CTRL.'/user/manage');
					
				}
				else
				{
					$this->session->set_flashdata('error','Error while blocking record');
					redirect(base_url().ADMIN_CTRL.'/user/manage');	
				}

			}
			else
			{
				redirect(base_url().ADMIN_CTRL.'/user/manage');
			}	


		}


	public function unblock($id)
	{
		if(isset($id)!='')
		{	
			$id=base64_decode($id);
			$array_data	= array("user_status"=>'1');
			$array_cond	= array("id"=>$id);

			$block = $this->master_model->updateRecord('user_registration',$array_data,$array_cond);

			$data['error']='';
			if($block == TRUE)
			{	
				$this->session->set_flashdata('success',' User Unblocked Successfully');
				redirect(base_url().ADMIN_CTRL.'/user/manage');
				
			}
			else
			{
				$this->session->set_flashdata('error','Error while Unblocking record');
				redirect(base_url().ADMIN_CTRL.'/user/manage');	
			}

		}
		else
		{
			redirect(base_url().ADMIN_CTRL.'/color/manage');
		}	

	}

	public function block_verify($id)
	{
		if(isset($id)!='')
		{
			$array_data	= array("verification_status"=>'0');
			$array_cond	= array("id"=>$id);

			$block = $this->master_model->updateRecord('tbl_user_registration_master',$array_data,$array_cond);

			$data['error']='';
			if($block == TRUE)
			{
				redirect(base_url().ADMIN_CTRL.'/user_registration/manage');
			}
			else
			{
				$this->session->set_flashdata('error','Error while blocking record');
				redirect(base_url().ADMIN_CTRL.'/user_registration/manage');	
			}

		}
		else
		{
			redirect(base_url().ADMIN_CTRL.'/user_registration/manage');
		}	

		
	}

	
	public function unblock_verify($id)
	{
		if(isset($id)!='')
		{
			$array_data	= array("verification_status"=>'1');
			$array_cond	= array("id"=>$id);

			$block = $this->master_model->updateRecord('tbl_user_registration_master',$array_data,$array_cond);

			$data['error']='';
			if($block == TRUE)
			{
				redirect(base_url().ADMIN_CTRL.'/user_registration/manage');
			}
			else
			{
				$this->session->set_flashdata('error','Error while Unblocking record');
				redirect(base_url().ADMIN_CTRL.'/user_registration/manage');	
			}

		}
		else
		{
			redirect(base_url().ADMIN_CTRL.'/color/manage');
		}	

	}

	public function multi_action()
	{
		if($_POST['action']=='delete'){
				foreach ($_POST['chk'] as $key) {
					$delete = $this->master_model->deleteRecord('user_registration',array("id"=>$key));
				}
				if($delete==TRUE){
					$this->session->set_flashdata('success',' Selected Users Deleted Successfully');
					redirect(base_url().ADMIN_CTRL.'/user/manage');
				}else{
					$this->session->set_flashdata('error','Error While Deleting Selected Users. ');
					redirect(base_url().ADMIN_CTRL.'/user/manage');
				}
			}
			if($_POST['action']=='block'){
				foreach ($_POST['chk'] as $key) {
					$id=$key;
					$data = array("user_status"=>'0');	
					$condition = array("id"=>$id);
					$block = $this->master_model->updateRecord('user_registration',$data,$condition);
				}
				$this->session->set_flashdata('success',' Selected Users Blocked Successfully');
				redirect(base_url().ADMIN_CTRL.'/user/manage');
			}
			if($_POST['action']=='unblock'){
				foreach ($_POST['chk'] as $key) {
					$id=$key;
					$data = array("user_status"=>'1');	
					$condition = array("id"=>$id);
					$block = $this->master_model->updateRecord('user_registration',$data,$condition);
				}
				$this->session->set_flashdata('success',' Selected Users Unblocked Successfully');
				redirect(base_url().ADMIN_CTRL.'/user/manage');
			}
		
		
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

	
}