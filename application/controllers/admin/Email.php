<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Email extends CI_Controller  
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
	
		$data['email_records'] 	= $this->master_model->getRecords('email_template','','',array("id"=>'ASC'));

		//$data['total'] = $rows_count;
		$data['page_title']		=	PROJECT_NAME.' | Manage User Registration';
		$data['content']		=	ADMIN_CTRL.'/email/manage_email';
		$this->load->view(ADMIN_VIEW.'/template',$data);	
	
	}



	public function edit($id){
	/*	echo '<pre>'; print_r($_POST); die();*/
		//if(isset($id)!=''){
			if(isset($_POST['edit_email'])){
				//die('hii');
				$id = $this->input->post('record_id');

				$this->form_validation->set_rules('template_name','Template Name','required');
				$this->form_validation->set_rules('template_from','Template From Name','required');
				$this->form_validation->set_rules('template_from_mail','Template From Mail Name','required');
				$this->form_validation->set_rules('template_subject','Template Subject Name','required');
				$this->form_validation->set_rules('body','Template Body Name','required');
				$this->form_validation->set_message('required', 'This field is required');
				if($this->form_validation->run() == TRUE){

				$data['template_name']      = $this->input->post('template_name');
				$data['template_from']      = $this->input->post('template_from');
				$data['template_from_mail'] = $this->input->post('template_from_mail');
				$data['template_subject']   = $this->input->post('template_subject');
				$data['template_html']      = $this->input->post('body');
				$edit_record                = $this->master_model->updateRecord('email_template',$data,array("id"=>$id));
				if($edit_record == TRUE)
				{
					$this->session->set_flashdata('success',' Email Template edited successfully!');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('error',' Error while editing Email Template.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			$id=base64_encode($id);
		}
			$id=base64_decode($id);
			$data['email']		=	$this->master_model->getRecords('email_template',array("id"=>$id));
			$data['page_title']		=PROJECT_NAME.' | Edit Email Template';
			$data['page_name']		= 'Edit Email Template';
			$data['module_name']    = 'Manage Email Template';
			$data['content']		=ADMIN_CTRL.'/email/edit_email';
			$this->load->view(ADMIN_VIEW.'/template',$data);	
		
	}


		public function delete($id) 
		{
			if(isset($id)!='')
			{	
				$id=base64_decode($id);
				$delete = $this->master_model->deleteRecord('email_template',array("id"=>$id));

				$data['error']='';
				if($delete == TRUE)
				{
					$this->session->set_flashdata('del_success','Record Deleted Successfully');
					redirect(base_url().ADMIN_CTRL.'/email/manage');
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleteing record');
					redirect(base_url().ADMIN_CTRL.'/email/manage');
				}	

			}
			else
			{
				redirect(base_url().ADMIN_CTRL.'/User/manage');
			}	
		}


	
	
}