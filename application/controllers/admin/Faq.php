<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}    

	// manage faq
	public function index(){
		if(isset($_POST['add_question'])){
			$this->form_validation->set_rules('question','Question','required|is_unique[faq.question]');
			$this->form_validation->set_rules('answer','Answer','required');
			$this->form_validation->set_message('is_unique', 'Sorry! Question Alredy Added.');
			$this->form_validation->set_message('required', 'This field is required.');
			if($this->form_validation->run() == TRUE){
				$data['question'] = $this->input->post('question');
				$data['answer'] = $this->input->post('answer');
				$add_record = $this->master_model->insertRecord('faq',$data);
				if($add_record == TRUE)
				{
					$this->session->set_flashdata('success',' Question added successfully!!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error While adding question.');
					redirect($_SERVER['HTTP_REFERER']);
				}			
			}
		}

		$data['per_page']=$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM faq WHERE question like "'.$searchName.'%"';	
			$con='question like "'.$searchName.'%"';
			$data['total'] = $this->master_model->getRecordCount('faq',$con);
		}
		else
		{
			
			$sqlQry  = 'SELECT * FROM faq' ;	
			$data['total'] = $this->db->count_all('faq');
		}
		$data['blocked'] = $this->master_model->getRecordCount('faq',array("is_active"=>'0'));

		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/faq?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage Faq';
		$data['module_name'] = 'Manage Faq';
		$data['content']	=ADMIN_CTRL.'/faq/manage_faq';
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

	// delete questions
	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('faq',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Question deleted successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Question. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}	
	}

// unblock question
	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("is_active"=>'1');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('faq',$data,$condition);
			$this->session->set_flashdata('success',' Question Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// block question
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("is_active"=>'0');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('faq',$data,$condition);
			$this->session->set_flashdata('success',' Question Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

// delete block unblock multi action 
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('faq',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected Question Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected Question. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("is_active"=>'0');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('faq',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Question Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("is_active"=>'1');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('faq',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Question Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// block question
	public function blockedfaq(){
		if(isset($_POST['add_question'])){
			$this->form_validation->set_rules('question','Question','required|is_unique[faq.question]');
			$this->form_validation->set_rules('answer','Answer','required');
			$this->form_validation->set_message('is_unique', 'Sorry! Question Alredy Added.');
			$this->form_validation->set_message('required', 'This field is required.');
			if($this->form_validation->run() == TRUE){
				$data['question'] = $this->input->post('question');
				$data['answer'] = $this->input->post('answer');
				$add_record = $this->master_model->insertRecord('faq',$data);
				if($add_record == TRUE)
				{
					$this->session->set_flashdata('success',' Question added successfully!!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error While adding question.');
					redirect($_SERVER['HTTP_REFERER']);
				}			
			}
		}
		$data['per_page']=$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM faq WHERE question like "'.$searchName.'%" AND is_active="0"';	
			$con='question like "'.$searchName.'%" AND is_active="0"';
			$data['blocked'] = $this->master_model->getRecordCount('faq',array("is_active"=>'0'));
			// $data['total'] = $this->master_model->getRecordCount('faq',$con);
		}
		else
		{
			
			$sqlQry  = 'SELECT * FROM faq WHERE is_active="0"';	
		$data['blocked'] = $this->master_model->getRecordCount('faq',array("is_active"=>'0'));
		}

		$data['total_blocked'] = $this->db->count_all('faq');
		$data['total'] = $this->master_model->getRecordCount('faq',array("is_active"=>'0'));
		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/faq/blockedfaq?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage Faq';
		$data['module_name'] = 'Manage Faq';
		$data['content']	=ADMIN_CTRL.'/faq/manageblock_faq';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

	// edit question
	public function edit($id){
		if(isset($id)!=''){
			if(isset($_POST['edit_question'])){
				$id= $this->input->post('record_id') ;
				$this->form_validation->set_rules('question','Question','required');
				$this->form_validation->set_rules('answer','Answer','required');
				$this->form_validation->set_message('required', 'This field is required.');
				if($this->form_validation->run() == TRUE){
					
					$data['question'] = $this->input->post('question');
					$data['answer'] = $this->input->post('answer');
					$edit_record = $this->master_model->updateRecord('faq',$data,array("id"=>$id));
					if($edit_record == TRUE)
					{
						$this->session->set_flashdata('success',' Question edited successfully!');
						redirect($_SERVER['HTTP_REFERER']);
					}
					else
					{
						$this->session->set_flashdata('error',' Error while editing question.');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
				$id=base64_encode($id);
			}
			$id=base64_decode($id);
			$data['question']=	$this->master_model->getRecords('faq',array("id"=>$id));
			$data['page_title']		=PROJECT_NAME.' | Edit Question';
			$data['page_name']		= 'Edit Question';
			$data['module_name'] = 'Faq';
			$data['content']		=ADMIN_CTRL.'/faq/edit_question';
			$this->load->view(ADMIN_VIEW.'/template',$data);	
		}
	}
}