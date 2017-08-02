<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Petbreed extends CI_Controller  
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
	public function index(){ 
		
					//Petbreed add code start here//

		if(isset($_POST['add_type']))
		{
			$this->form_validation->set_rules('type_name','Type Name','required|is_unique[pet_breed.type_name]');
			$this->form_validation->set_message('is_unique', 'Breed Type Alredy Exists.');
			if($this->form_validation->run() == TRUE)
			{
				$data['type_name']  = $this->input->post('type_name');
				//$data['created_at'] = $date;
				$add_record = $this->master_model->insertRecord('pet_breed',$data);
				if($add_record == TRUE)
				{
					$this->session->set_flashdata('success','Breed type added successfully!!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error while adding breed type.');
					redirect($_SERVER['HTTP_REFERER']);
				}			
			}
		}

				//Pagination Code start here  //

		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
		$data['total'] = $this->master_model->getRecordCount('pet_breed');

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pet_breed WHERE type_name like "'.$searchName.'%"';	
			$data['total'] = $this->db->query($sqlQry)->num_rows();	
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pet_breed' ;
			$data['total'] = $this->db->query($sqlQry)->num_rows();		
		}

		 $data['blocked'] = $this->master_model->getRecordCount('pet_breed',array('status'=>'0'));
		//$data['all'] = $this->master_model->getRecordCount('pet_colors',array('type'=>'user'));
		$dataCnt 		= 	$this->db->query($sqlQry);

		$pageNum 		= 	$this->input->get('page');
		
		$pageURL		= 	base_url().ADMIN_CTRL.'/petbreed?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['links']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();

		$data['page_title']	 = PROJECT_NAME.' | Manage Pet Breed';
		$data['module_name'] = 'Manage Pet Breed';
		$data['content']	 = ADMIN_CTRL.'/petbreed/pet_breed';
		$data['search_name']   = isset($searchName) && $searchName!=''?$searchName:'';
		$this->load->view(ADMIN_VIEW.'/template',$data);	

		
	}

	public function blockedpetbreed($value='')
	{
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
		$data['total'] = $this->master_model->getRecordCount('pet_breed');

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pet_breed WHERE type_name like "'.$searchName.'%" AND status="0"';	
			$data['blocked'] = $this->db->query($sqlQry)->num_rows();
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pet_breed WHERE status="0"' ;	
			$data['blocked'] = $this->db->query($sqlQry)->num_rows();
		}

		$data['total'] = $this->db->count_all('pet_breed');
		//$data['all'] = $this->master_model->getRecordCount('pet_colors',array('type'=>'user'));
		$dataCnt 		= 	$this->db->query($sqlQry);

		$pageNum 		= 	$this->input->get('page');
		
		$pageURL		= 	base_url().ADMIN_CTRL.'/petbreed/blockedpetbreed?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['links']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();

		$data['page_title']	 = PROJECT_NAME.' | Manage Pet Breed';
		$data['module_name'] = 'Manage Pet Breed';
		$data['content']	 = ADMIN_CTRL.'/petbreed/blocked_pet_breed';
		$data['search_name']   = isset($searchName) && $searchName!=''?$searchName:'';
		$this->load->view(ADMIN_VIEW.'/template',$data);	
	}
	
	public function edit($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			if(isset($_POST['edit_pettype'])){
				$id= $this->input->post('record_id') ;
				$data['type_name'] = $this->input->post('type_name');
				$edit_record = $this->master_model->updateRecord('pet_breed',$data,array("id"=>$id));
				if($edit_record == TRUE)
				{
					$this->session->set_flashdata('success',' Breed Type edited successfully!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error while editing Breed Type.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			$data['type_name']		=	$this->master_model->getRecords('pet_breed',array("id"=>$id));
			$data['page_title']		=PROJECT_NAME.' | Edit Pet Breed';
			$data['page_name']		= 'Edit Breed Type';
			$data['module_name']    = 'Manage Pet Breed';
			$data['content']		=ADMIN_CTRL.'/petbreed/edit_pettype';
			$this->load->view(ADMIN_VIEW.'/template',$data);	
		}
	}

	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('pet_breed',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Pet Type deleted successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Pet Type. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}	
	}

	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("status"=>'1');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pet_breed',$data,$condition);
			if($block==TRUE){
				$this->session->set_flashdata('success',' Pet Type unblock successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While unblock Pet Type. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("status"=>'0');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pet_breed',$data,$condition);
			if($block==TRUE){
				$this->session->set_flashdata('success',' Pet Type block successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While block Pet Type. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('pet_breed',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected Pet type Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected Pet type. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("status"=>'0');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pet_breed',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Pet type Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("status"=>'1');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pet_breed',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Pet type Unblocked Successfully');
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

