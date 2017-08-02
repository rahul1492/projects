<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctor extends CI_Controller  
{
	public function __construct()
	{
		parent::__construct();
	}

	public function reset($encrypted_userid='')
	{
		/*
			if doctor verified then not allow to reset the password, for that he needs to forget password again

			forget password set the confirmation code and set verification status to the "0"
		*/

	$data['success']=$data['error']='';

	$getRecords = $this->master_model->getRecordCount('user_registration', array("confirmation_code"=>$encrypted_userid, "verification_status"=>'0'));

	if($getRecords == 1){

		if(isset($_POST['reset'])){

			$this->form_validation->set_rules('new_password','New Password','trim|required|min_length[6]|max_length[25]|matches[cnf_password]');
			$this->form_validation->set_rules('cnf_password','Confirm Password','trim|required|min_length[6]|max_length[25]|matches[new_password]');

			if($this->form_validation->run() == TRUE)
			{
				$array_data=$where=	array();

				$array_data['user_password']		=	md5($this->input->post('new_password'));
				$array_data['verification_status']  = "1";
				$array_data['type'] 				= "doctor";

				$where["confirmation_code"]		=	"'".$encrypted_userid."'";

				$edit_record = $this->master_model->updateRecord('user_registration',$array_data, $where);

				if($edit_record == TRUE)
					{
						$this->session->set_flashdata('success','Password Changed Successfully!');
						redirect(base_url().ADMIN_CTRL);
					}
					else
					{
						$this->session->set_flashdata('error','Error while changing password');
						redirect(base_url().'front/doctor/reset/'.$where['user_password']);
					}
			}
		}		

			$arrayData['data'] = $encrypted_userid; 
			$this->load->view('front/reset_password', $arrayData);		
		}else{

			$this->session->set_flashdata('error','You have already verified');
			redirect(base_url().ADMIN_CTRL);
		}
	}
}