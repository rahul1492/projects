<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Petage extends CI_Controller  
{
	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('admin_info') == "")
		{
			redirect(base_url().ADMIN_CTRL.'/login');
		}
	}

	public function index(){
		
		if(isset($_POST['add_type'])){

			$this->form_validation->set_rules('age_type','Age Type','required|is_unique[pet_age.age_type]');
			$this->form_validation->set_message('is_unique', 'Sorry! Age Type Already Added.');
			if($this->form_validation->run() == TRUE){
				$data['age_type'] = $this->input->post('age_type');
				$add_record = $this->master_model->insertRecord('pet_age',$data);
				if($add_record == TRUE)
				{
					$this->session->set_flashdata('success','Age type added successfully!!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error While adding Age Type.');
					redirect($_SERVER['HTTP_REFERER']);
				}			
			}
		}

		// $rows_count = $this->master_model->getRecordCount('pet_age',$condition);
		// $data['blocked'] = $this->master_model->getRecordCount('pet_age',array('status'=>'0'));
		// $config['base_url'] = base_url().ADMIN_CTRL.'/petage/index';
		// $config['total_rows'] = $rows_count;
		// $config['per_page'] = isset($_POST['perpage'])? $_POST['perpage'] : 10;
		// $config['uri_segment'] = 4;
		// $config['next_link'] = 'Next →';
		// $config['next_tag_open'] = '<li>';
		// $config['next_tag_close'] = '</li>';
		// $config['first_link'] = FALSE;	
		// $config['last_link'] = FALSE;
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
		// $data['records'] = $this->master_model->getRecords('pet_age',$condition,'',array("age_type"=>'ASC'),$data['page'],$config['per_page']);
		// $data['total'] = $rows_count; 

		// $condition=isset($_POST['search_name'])? "`age_type` LIKE '".$_POST['search_name']."%'":(isset($condition)? $condition : '');

		$perpage=isset($_POST['per_page'])? $_POST['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pet_age WHERE age_type like "'.$searchName.'%"';
			$data['total'] = $this->db->query($sqlQry)->num_rows();	
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pet_age';	
			$data['total'] = $this->db->count_all('pet_age');
		}

		$data['blocked'] = $this->master_model->getRecordCount('pet_age',array('status'=>'0'));
		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/petage?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';

		$data['page_title']	= PROJECT_NAME.' | Manage Pet Age';
		$data['module_name'] = 'Manage Pet Age';
		$data['content']	=ADMIN_CTRL.'/pet_age/petage_manage';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

	public function blockedpetage($value='')
	{
		$perpage=isset($_POST['per_page'])? $_POST['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pet_age WHERE age_type like "'.$searchName.'%" AND status="0"';
			$data['blocked'] = $this->db->query($sqlQry)->num_rows();	
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pet_age WHERE status="0"';	
			$data['blocked'] = $this->master_model->getRecordCount('pet_age',array('status'=>'0'));
		}

		//$data['blocked'] = $this->master_model->getRecordCount('pet_age',array('status'=>'0'));
		$data['total'] = $this->db->count_all('pet_age');
		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/petage/blockedpetage?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';

		$data['page_title']	= PROJECT_NAME.' | Manage Pet Age';
		$data['module_name'] = 'Manage Pet Age';
		$data['content']	=ADMIN_CTRL.'/pet_age/blocked_petage_manage';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

	public function edit($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			if(isset($_POST['edit_type'])){
				$id= $this->input->post('record_id') ;
				$data['age_type'] = $this->input->post('age_type');
				$edit_record = $this->master_model->updateRecord('pet_age',$data,array("id"=>$id));
				if($edit_record == TRUE)
				{
					$this->session->set_flashdata('success','Age type edited successfully!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error while editing age type.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			$data['pet_age']=	$this->master_model->getRecords('pet_age',array("id"=>$id));
			$data['page_title']		=PROJECT_NAME.' | Edit Pet Type';
			$data['page_name']		= 'Edit Pet Type';
			$data['module_name']	= 'Petage';
			$data['content']		=ADMIN_CTRL.'/pet_age/petage_edit';
			$this->load->view(ADMIN_VIEW.'/template',$data);	
		}
	}

	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('pet_age',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Age Type deleted successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Age Type. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}	
	}

	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("status"=>'1');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pet_age',$data,$condition);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("status"=>'0');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pet_age',$data,$condition);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('pet_age',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected Age Type Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected Age Type. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("status"=>'0');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pet_age',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Age Type Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("status"=>'1');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pet_age',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Age Type Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
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