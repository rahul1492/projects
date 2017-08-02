<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pets extends CI_Controller  
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

	// manage pets ad
	public function index(){
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pets WHERE pet_name like "'.$searchName.'%" AND ad_type != "breed"';	
			$con='pet_name like "'.$searchName.'%" AND ad_type != "breed"';
			$data['total'] = $this->master_model->getRecordCount('pets',$con);
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pets WHERE ad_type != "breed"';	
			$data['total'] = $this->master_model->getRecordCount('pets',array('ad_type'=>'own'));
			$data['total'] += $this->master_model->getRecordCount('pets',array('ad_type'=>'adopt'));
		}

		$data['blocked'] = $this->master_model->getRecordCount('pets',array('pets_status'=>'0','ad_type'=>'own'));
		$data['blocked'] += $this->master_model->getRecordCount('pets',array('pets_status'=>'0','ad_type'=>'adopt'));
		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/pets?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Own Adopt Pet';
		$data['module_name'] = 'Own Adopt Pet';
		$data['content']	=ADMIN_CTRL.'/posted_ad/own_adopt';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

// manage breedpets ad
	public function breedpets(){
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pets WHERE pet_name like "'.$searchName.'%" AND ad_type = "breed"';	
			$con='pet_name like "'.$searchName.'%" AND ad_type = "breed"';
			$data['total'] = $this->master_model->getRecordCount('pets',$con);	
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pets WHERE ad_type = "breed"';
			$data['total'] = $this->master_model->getRecordCount('pets',array('ad_type'=>'breed'));	
		}

		$data['blocked'] = $this->master_model->getRecordCount('pets',array('pets_status'=>'0','ad_type'=>'breed'));
		$dataCnt 		= 	$this->db->query($sqlQry);
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/pets/breedpets?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Breed Pet';
		$data['module_name'] = 'Breed Pet';
		$data['content']	=ADMIN_CTRL.'/posted_ad/breedpets_view';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

// view ad
	public function viewpet($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data['pet']=	$this->master_model->getRecords('pets',array("id"=>$id));
		}
		$data['page_title']	= PROJECT_NAME.' | View Pet';
		$data['module_name'] = 'View Pet';
		$data['content']	=ADMIN_CTRL.'/posted_ad/view_pet';
		$this->load->view(ADMIN_VIEW.'/template',$data);	
	}

// unblock ad
	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("pets_status"=>'1');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pets',$data,$condition);
			$this->session->set_flashdata('success',' Pet Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

// block ad
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("pets_status"=>'0');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pets',$data,$condition);
			$this->session->set_flashdata('success',' Pet Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// block unblock delete multiple ad
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('pets',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected pets Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected pets. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("pets_status"=>'0');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pets',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected pets Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("pets_status"=>'1');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pets',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected pets Unblocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// delete ad
	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('pets',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' pets deleted successfully');
				redirect(base_url().ADMIN_CTRL.'/pets');
			}else{
				$this->session->set_flashdata('error','Error While Deleting pets. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	// manage block breed ad
	public function blockedbreedpets(){
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pets WHERE pet_name like "'.$searchName.'%" AND ad_type = "breed" AND pets_status="0"';
			$con='pet_name like "'.$searchName.'%" AND ad_type = "breed" AND pets_status="0"';	
			$data['total'] = $data['blocked'] = $this->master_model->getRecordCount('pets',$con);

		}
		else
		{
			$sqlQry  = 'SELECT * FROM pets WHERE ad_type = "breed" AND pets_status="0"';	
			$con='ad_type = "breed" AND pets_status="0"';	
			$data['total'] = $data['blocked'] = $this->master_model->getRecordCount('pets',$con);
		}

		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total_pets'] = $this->master_model->getRecordCount('pets',array('ad_type'=>'breed'));
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/pets/blockedbreedpets?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Breed Pet';
		$data['module_name'] = 'Breed Pet';
		$data['content']	=ADMIN_CTRL.'/posted_ad/block_breed_pets';
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

	// function for  blocked add
	public function blockedownpets(){
		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pets WHERE pet_name like "'.$searchName.'%" AND ad_type != "breed" AND pets_status="0"';	
			$con='pet_name like "'.$searchName.'%" AND ad_type != "breed" AND pets_status="0"';
			$data['blocked'] = $this->master_model->getRecordCount('pets',$con);
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pets WHERE ad_type != "breed" AND pets_status="0"';	
			$data['blocked'] = $this->master_model->getRecordCount('pets',array('pets_status'=>'0','ad_type'=>'own'));
			$data['blocked'] += $this->master_model->getRecordCount('pets',array('pets_status'=>'0','ad_type'=>'adopt'));
		}
		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total'] = $data['blocked'];
		$data['total_pets']=$this->master_model->getRecordCount('pets',array('ad_type'=>'adopt'));
		$data['total_pets']+=$this->master_model->getRecordCount('pets',array('ad_type'=>'own'));
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/pets/blockedownpets?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Own Adopt Pet';
		$data['module_name'] = 'Own Adopt Pet';
		$data['content']	=ADMIN_CTRL.'/posted_ad/own_adopt_blocked';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}
}