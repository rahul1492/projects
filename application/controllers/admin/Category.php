<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends CI_Controller  
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

// manage category
	public function index(){
		if(isset($_POST['add_category'])){
			$this->form_validation->set_rules('category_name','Category Name','required|is_unique[category.category_name]');
			$this->form_validation->set_message('is_unique', 'Sorry! Category Alredy Added.');
			$this->form_validation->set_message('required', 'This field is required.');
			if($this->form_validation->run() == TRUE){
				$data['category_name'] = $this->input->post('category_name');
				$add_record = $this->master_model->insertRecord('category',$data);
				if($add_record == TRUE)
				{
					$this->session->set_flashdata('success',' Category added successfully!!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error While adding category.');
					redirect($_SERVER['HTTP_REFERER']);
				}			
			}
		}
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM category WHERE category_name like "'.$searchName.'%"';	
			$con='category_name like "'.$searchName.'%"';
			$data['total'] = $this->master_model->getRecordCount('category',$con);
		}
		else
		{
			$sqlQry  = 'SELECT * FROM category' ;
			$data['total'] = $this->db->count_all('category');	
		}

		$data['blocked'] = $this->master_model->getRecordCount('category',array('category_status'=>'0'));
		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/category?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage Category';
		$data['module_name'] = 'Manage Category';
		$data['content']	=ADMIN_CTRL.'/category/manage_category';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

	// manage blocked category

	public function blockedcategory(){

		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM category WHERE category_name like "'.$searchName.'%" AND category_status="0"';
			$con='category_name like "'.$searchName.'%" AND category_status="0"';
			$data['blocked'] = $data['total'] = $this->master_model->getRecordCount('category',$con);
		}
		else
		{
			$sqlQry  = 'SELECT * FROM category WHERE category_status="0"' ;	
		$data['blocked'] =$data['total'] = $this->master_model->getRecordCount('category',array('category_status'=>'0'));
		}
		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total_category'] = $this->master_model->getRecordCount('category');
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/category/blockedcategory?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage Category';
		$data['module_name'] = 'Manage Category';
		$data['content']	=ADMIN_CTRL.'/category/manage_blockcategory';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

// edit category
	public function edit($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			if(isset($_POST['edit_category'])){
				$id= $this->input->post('record_id') ;
				$this->form_validation->set_rules('category_name','Category Name','required');
				$this->form_validation->set_message('required', 'This field is required.');
				if($this->form_validation->run() == TRUE){
					
					$data['category_name'] = $this->input->post('category_name');
					$edit_record = $this->master_model->updateRecord('category',$data,array("id"=>$id));
					if($edit_record == TRUE)
					{
						$this->session->set_flashdata('success',' Category edited successfully!');
						redirect($_SERVER['HTTP_REFERER']);
					}
					else
					{
						$this->session->set_flashdata('error',' Error while editing category.');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
			}
			$data['category']=	$this->master_model->getRecords('category',array("id"=>$id));
			$data['page_title']		=PROJECT_NAME.' | Edit Category';
			$data['page_name']		= 'Edit Category';
			$data['module_name'] = 'Category';
			$data['content']		=ADMIN_CTRL.'/category/edit_category';
			$this->load->view(ADMIN_VIEW.'/template',$data);	
		}
	}

// delete category
	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('category',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Category deleted successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Category. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}	
	}

// unblock category
	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("category_status"=>'1');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('category',$data,$condition);
			$this->session->set_flashdata('success',' Category Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// block category
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("category_status"=>'0');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('category',$data,$condition);
			$this->session->set_flashdata('success',' Category Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

// multi action delete, block ,unblock
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('category',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected Category Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected Category. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("category_status"=>'0');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('category',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Category Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("category_status"=>'1');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('category',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Category Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
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
}