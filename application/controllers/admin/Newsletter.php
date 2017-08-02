<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){

		$data['per_page']=$perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
		$data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;

		$searchName 	= 	$this->input->get('search_name');
		if(isset($searchName) && $searchName!='')
		{
			$sqlQry = 'SELECT * FROM news_letter WHERE user_email like "'.$searchName.'%"';	
		}
		else
		{
			
			$sqlQry  = 'SELECT * FROM news_letter' ;	
		}

		$dataCnt 		= 	$this->db->query($sqlQry);
		$data['total'] = $this->db->count_all('news_letter');
		$pageNum 		= 	$this->input->get('page');
		$pageURL		= 	base_url().ADMIN_CTRL.'/newsletter?search_name='.$searchName.'&per_page='.$perpage;
		$_pageRes 		= 	$this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
		$data['pagination']	=	$_pageRes['page_links'];
		$sqlQuery		= 	$sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
		$dataSql 		= 	$this->db->query($sqlQuery);
		$data['records']= 	$dataSql->result_array();
		$data['search_name']		=	isset($searchName) && $searchName!=''?$searchName:'';
		$data['page_title']	= PROJECT_NAME.' | Manage Newsletter';
		$data['module_name'] = 'Manage Newsletter';
		$data['content']	=ADMIN_CTRL.'/newsletter/manage_newsletter';
		$this->load->view(ADMIN_VIEW.'/template',$data);
	}

	public function multi_action(){
		if($_POST['action']=='delete'){
			foreach ($_POST['chk'] as $key) {
				$delete = $this->master_model->deleteRecord('news_letter',array("id"=>$key));
			}
			if($delete==TRUE){
				$this->session->set_flashdata('success',' Selected News Letter Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting Selected News Letter. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function delete($id){
		if(isset($id)!=''){
			$id=base64_decode($id);
			$delete = $this->master_model->deleteRecord('news_letter',array("id"=>$id));
			if($delete==TRUE){
				$this->session->set_flashdata('success',' News Letter Deleted Successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error While Deleting News Letter. ');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		
	}

	// public function viewenquiry($id){
	// 	$id=base64_decode($id);
	// 	$edit_record = $this->master_model->updateRecord('news_letter',array('is_view'=>'1'),array("id"=>$id));
	// 	$data['enquiry']=	$this->master_model->getRecords('news_letter',array("id"=>$id));
	// 	$data['page_title']		=PROJECT_NAME.' | View Enquiry';
	// 	$data['page_name']		= 'View Enquiry';
	// 	$data['module_name'] = 'Contact Enquiry';
	// 	$data['content']		=ADMIN_CTRL.'/contact/view_enquiry';
	// 	$this->load->view(ADMIN_VIEW.'/template',$data);
	// }
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