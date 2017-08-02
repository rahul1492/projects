<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class City extends CI_Controller  
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

	// manage cities
	public function index(){
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$data['search_name']=$searchName = ($this->input->get('search_name'))? $this->input->get('search_name'):'';
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT city.*, state.*,city.is_active AS status FROM city INNER JOIN state ON state.id=city.state_id WHERE city.city_name like "'.$searchName.'%"';	
			$con='city_name like "'.$searchName.'%"';
			$data['total'] = $this->master_model->getRecordCount('city',$con);
		}
		else
		{
			$sqlQry = 'SELECT city.*, state.*,city.is_active AS status FROM city INNER JOIN state ON state.id=city.state_id';	
			$data['total'] = $this->db->count_all('city');
		}
		$aa = $this->db->query('SELECT city.*, state.*,city.is_active AS status FROM city INNER JOIN state ON state.id=city.state_id WHERE city.is_active="0"');
		$data['blocked'] = $aa->num_rows();
		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/city?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Cities';
		$data['module_name'] = 'Cities';
		$data['content']	=ADMIN_CTRL.'/location/manage_cities';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

// delete city
	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('city',array("city_id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' city deleted successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting city.');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}	
	}

// edit city
	public function edit($id){
		$id = base64_decode($id);
		if(isset($_POST['edit_city'])){
			$id= base64_decode($this->input->post('record_id')) ;
			$city= $this->master_model->getRecords('city',array("city_id"=>$id));
			$data['city_name'] = $this->input->post('city_name');
			$data['state_id'] = $this->input->post('state');
			$is_unique='';
			if($city[0]['city_name']!=$this->input->post('city_name')){
				$is_unique="|is_unique[city.city_name]";
			}
			$this->form_validation->set_rules('city_name','City Name','required');
			$this->form_validation->set_rules('state','State Name','required');
			$this->form_validation->set_message('required', 'This field is required');
			$this->form_validation->set_message('is_unique', 'The %s already added.');
			if($this->form_validation->run() == TRUE){
				$edit_record = $this->master_model->updateRecord('city',$data,array("city_id"=>$id));
				if($edit_record == TRUE)
				{
					$this->session->set_flashdata('success',' City edited successfully!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error while editing City.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
		$data['city']=	$this->master_model->getRecords('city',array("city_id"=>$id));
		$data['states']=	$this->master_model->getRecords('state');
		$data['page_title']		=PROJECT_NAME.' | Edit City';
		$data['page_name']		= 'Edit City';
		$data['module_name'] = 'City';
		$data['content']		=ADMIN_CTRL.'/location/edit_city';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

// unblock city
	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("is_active"=>'1');	
			$condition = array("city_id"=>$id);
			$block = $this->master_model->updateRecord('city',$data,$condition);
			$this->session->set_flashdata('success',' City Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// block city
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("is_active"=>'0');	
			$condition = array("city_id"=>$id);
			$block = $this->master_model->updateRecord('city',$data,$condition);
			$this->session->set_flashdata('success',' City Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// multi action block, unblock, delete
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('city',array("city_id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected City Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected City. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("is_active"=>'0');	
				$condition = array("city_id"=>$id);
				$block = $this->master_model->updateRecord('city',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected city Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("is_active"=>'1');	
				$condition = array("city_id"=>$id);
				$block = $this->master_model->updateRecord('city',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected city Unblocked Successfully');
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

	// blocked cities
	public function blockedcity(){
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT city.*, state.*,city.is_active AS status FROM city INNER JOIN state ON state.id=city.state_id WHERE city.city_name like "'.$searchName.'%" AND city.is_active="0"';	
			$con='city_name like "'.$searchName.'%" AND is_active="0"';
			// $data['blocked'] = $this->master_model->getRecordCount('city',$con);
			$aa = $this->db->query('SELECT city.*, state.*,city.is_active AS status FROM city INNER JOIN state ON state.id=city.state_id WHERE city.city_name like "'.$searchName.'%" AND city.is_active="0"');
			$data['blocked'] = $aa->num_rows();
			$data['total'] = $this->master_model->getRecordCount('city',$con);
		}
		else
		{
			$sqlQry = 'SELECT city.*, state.*,city.is_active AS status FROM city INNER JOIN state ON state.id=city.state_id WHERE city.is_active="0"';	
				$aa = $this->db->query('SELECT city.*, state.*,city.is_active AS status FROM city INNER JOIN state ON state.id=city.state_id WHERE city.is_active="0"');
			$data['blocked'] = $aa->num_rows();
			$data['total'] = $this->master_model->getRecordCount('city',array('is_active'=>'0'));
		}

		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total_cities'] = $this->db->count_all('city');
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/city/blockedcity?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Cities';
		$data['module_name'] = 'Cities';
		$data['content']	=ADMIN_CTRL.'/location/manage_blockedcities';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}
	
}