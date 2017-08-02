<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Petcolor extends CI_Controller  
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
		
									//Color add code start here//

		if(isset($_POST['add_color']))
		{
			$this->form_validation->set_rules('color_name','Color Name','required|is_unique[pet_colors.color_name]');
			$this->form_validation->set_message('is_unique', 'Color Alredy Exists.');
			if($this->form_validation->run() == TRUE)
			{
				$data['color_name'] = $this->input->post('color_name');
				$data['created_at'] = $date;
				$add_record = $this->master_model->insertRecord('pet_colors',$data);
				if($add_record == TRUE)
				{
					$this->session->set_flashdata('success',' Color Name added successfully!!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error While adding Color.');
					redirect($_SERVER['HTTP_REFERER']);
				}			
			}
		}


							//Pagination Code start here  //

		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
		$data['total'] = $this->master_model->getRecordCount('pet_colors');

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pet_colors WHERE color_name like "'.$searchName.'%"';	
			$data['total'] = 	$this->db->query($sqlQry)->num_rows();
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pet_colors' ;	
			$data['total'] = 	$this->db->query($sqlQry)->num_rows();
		}

		$data['blocked'] = $this->master_model->getRecordCount('pet_colors',array('color_status'=>'0'));
		//$data['all'] = $this->master_model->getRecordCount('pet_colors',array('type'=>'user'));
		$dataCnt 		= 	$this->db->query($sqlQry);

		$pageNum 		= 	$this->input->get('page');
		
		$pageURL		= 	base_url().ADMIN_CTRL.'/petcolor?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['links']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['page_title']	= PROJECT_NAME.' | Manage Color';
		$data['module_name'] = 'Manage Color';
		$data['content']		=	ADMIN_CTRL.'/petcolor/manage_color';
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$this->load->view(ADMIN_VIEW.'/template',$data);	


	}

	public function blockedpetcolor($value='')
	{
		
							//Pagination Code start here  //

		$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
		$data['total'] = $this->master_model->getRecordCount('pet_colors');

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM pet_colors WHERE color_name like "'.$searchName.'%" AND color_status="0"';
			$data['blocked'] = 	$this->db->query($sqlQry)->num_rows();	
		}
		else
		{
			$sqlQry  = 'SELECT * FROM pet_colors WHERE color_status="0"' ;	
			$data['blocked'] = 	$this->db->query($sqlQry)->num_rows();
		}

		$data['total'] = $this->db->count_all('pet_colors');
		//$data['all'] = $this->master_model->getRecordCount('pet_colors',array('type'=>'user'));
		$dataCnt 		= 	$this->db->query($sqlQry);

		$pageNum 		= 	$this->input->get('page');
		
		$pageURL		= 	base_url().ADMIN_CTRL.'/petcolor/blockedpetcolor?search_name='.$searchName;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['links']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['page_title']	= PROJECT_NAME.' | Manage Color';
		$data['module_name'] = 'Manage Color';
		$data['content']		=	ADMIN_CTRL.'/petcolor/blocked_manage_color';
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$this->load->view(ADMIN_VIEW.'/template',$data);	
	}
	
	public function edit($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			if(isset($_POST['edit_color'])){
				$id= $this->input->post('record_id') ;
				$data['color_name'] = $this->input->post('color_name');
				$edit_record = $this->master_model->updateRecord('pet_colors',$data,array("id"=>$id));
				if($edit_record == TRUE)
				{
					$this->session->set_flashdata('success',' Color edited successfully!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error while editing Color.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			$data['color_name']		=	$this->master_model->getRecords('pet_colors',array("id"=>$id));
			$data['page_title']		=PROJECT_NAME.' | Edit Color';
			$data['page_name']		= 'Edit Color';
			$data['module_name']    = 'Manage Color';
			$data['content']		=ADMIN_CTRL.'/petcolor/edit_color';
			$this->load->view(ADMIN_VIEW.'/template',$data);	
		}
	}

	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('pet_colors',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Color deleted successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Color. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}	
	}

	public function unblock($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("color_status"=>'1');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pet_colors',$data,$condition);
			if($block==TRUE){
				$this->session->set_flashdata('success',' Color unblock successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While unblock Color. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function block($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$data = array("color_status"=>'0');	
			$condition = array("id"=>$id);
			$block = $this->master_model->updateRecord('pet_colors',$data,$condition);
			if($block==TRUE){
				$this->session->set_flashdata('success',' Color block successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While block Color. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('pet_colors',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected Color Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected Color. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		if($_POST['action']=='block'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("color_status"=>'0');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pet_colors',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Color Blocked Successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($_POST['action']=='unblock'){
			foreach ($_POST['chk'] as $key) {
				$id=$key;
				$data = array("color_status"=>'1');	
				$condition = array("id"=>$id);
				$block = $this->master_model->updateRecord('pet_colors',$data,$condition);
			}
			$this->session->set_flashdata('success',' Selected Color Unblocked Successfully');
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

