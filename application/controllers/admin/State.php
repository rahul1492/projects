<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class State extends CI_Controller  
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('master_model');

		if($this->session->userdata('admin_info') == "")
		{
			redirect(base_url().ADMIN_CTRL.'/login');
		}

	}

	// manage states
	public function index(){
		$data['per_page']=$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM state WHERE state_name like "'.$searchName.'%"';	
			$con='state_name like "'.$searchName.'%"';
			$data['total'] = $this->master_model->getRecordCount('state',$con);
		}
		else
		{
			
			$sqlQry  = 'SELECT * FROM state' ;	
			$data['total'] = $this->db->count_all('state');
		}

		$dataCnt 		= 	$this->db->query($sqlQry);
		// $data['total'] = $this->db->count_all('state');
		$data['blocked'] = $this->master_model->getRecordCount('state',array('is_active'=>'0'));
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/state?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage State';
		$data['module_name'] = 'Manage State';
		$data['content']	=ADMIN_CTRL.'/location/manage_states';
		$this->load->view(ADMIN_VIEW.'/template',$data);

	}

	// delete state
	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('state',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' State deleted successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting State.');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}	
	}

// unblock state
	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("is_active"=>'1');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('state',$data,$condition);
			$this->session->set_flashdata('success',' State Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// block state
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("is_active"=>'0');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('state',$data,$condition);
			$this->session->set_flashdata('success',' State Blocked Successfully');

			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// block unblock delete multitple states
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('state',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected State Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected State. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("is_active"=>'0');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('state',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected State Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("is_active"=>'1');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('state',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected State Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// view cities in state
	public function viewcity($id='')
	{
		if($id!=''){
			$id = base64_decode($id);
			$this->session->set_userdata('state_id',$id);
		}

		$data['per_page']=$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM city WHERE city_name like "'.$searchName.'%" WHERE state_id='.$this->session->userdata('state_id');	
		}
		else
		{
			
			$sqlQry  = 'SELECT * FROM city WHERE state_id='.$this->session->userdata('state_id');	
		}

		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total'] = $this->master_model->getRecordCount('city',array('state_id'=>$this->session->userdata('state_id')));
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/state/viewcity?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Cities';
		$data['module_name'] = 'Cities';
		$data['content']	=ADMIN_CTRL.'/location/view_cities';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

	// function for common pagination
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

	// manage blocked states
	public function blockedstate(){
		$data['per_page']=$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM state WHERE state_name like "'.$searchName.'%" AND is_active="0"';
			$con= 'state_name like "'.$searchName.'%" AND is_active="0"';
			$data['total'] = $this->master_model->getRecordCount('state',$con);
			$data['blocked'] = $this->master_model->getRecordCount('state',$con);
		}
		else
		{
			$sqlQry  = 'SELECT * FROM state WHERE is_active="0"' ;	
			$data['total'] = $this->master_model->getRecordCount('state',array('is_active'=>'0'));
			$data['blocked'] = $this->master_model->getRecordCount('state',array('is_active'=>'0'));
		}
		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total_states'] = $this->master_model->getRecordCount('state');
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/state/blockedstate?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage State';
		$data['module_name'] = 'Manage State';
		$data['content']	=ADMIN_CTRL.'/location/manage_blockstates';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}
}