<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
        parent::__construct();

        session_check();
        $this->load->library('account_details');
  }

	public function index()
	{
		if(isset($_POST['submit']))
		{
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
   			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
   			
        if($this->form_validation->run())
   			{
   				$username = $this->input->post('username');
   				$password = md5($this->input->post('password'));
   				$condition = array('admin_username'=>$username,'admin_password'=>$password);
   				$res=$this->master_model->getRecords('admin_login',$condition);

	   			if(count($res)>0) 
	   			{
            $sess = array(
                'admin_id' => $res[0]['admin_id'],
                'admin_username' => $res[0]['admin_username'],
                'profile_image' => $res[0]['admin_image'],
                'admin_url' => base_url().ADMIN_CTRL
              );

            $this->session->set_userdata('profile_image',$res[0]['admin_image']);

            $this->session->set_userdata('admin_info',$sess);
   					redirect(base_url().ADMIN_VIEW.'/dashboard');
	   			}  	
         	else 
      		{
            $this->session->set_flashdata('login_error','Please Enter Correct Username / Password..');
            redirect(base_url().ADMIN_VIEW.'/login');
      		}
   			}
		}
   	 $this->load->view('admin/login_view');
	}

  public function recover_password()
  {
    if(isset($_POST['email']))
    { 
      $this->form_validation->set_rules('email','Email ID','required|valid_email');

      if($this->form_validation->run()){

        $email = $this->input->post('email');
        $condition  = array('admin_email' => $email);
        $email_addr = $this->master_model->getRecords('admin_login' , $condition);

        if(empty($email_addr))
        {
          echo "E-mail address was not found. Try  again";
        exit;
        }

         $this->load->helper('string');
         $new_password = random_string('alnum', 8);
        
         $data= array('admin_password'=>$new_password);
         $whr = array('admin_email'=> "'".$email_addr[0]['admin_email']."'");
         $update_password = $this->master_model->updateRecord('admin_login', $data, $whr);

         if($update_password)
         {
          
          // $config['protocol']     = 'smtp';
          // $config['smtp_host']    = 'ssl://smtp.gmail.com';
          // $config['smtp_port']    = '465';
          // $config['smtp_timeout'] = '7';
          // $config['smtp_user']    = 'yanikluis5@gmail.com';
          // $config['smtp_pass']    = 'webwing@webwing';
          // $config['charset']      = 'utf-8';
          // $config['newline']      = "\r\n";
          // $config['mailtype']     = 'html'; // or html
          // $config['validation']   = TRUE; // bool whether to validate email or not 

          // $this->load->library('email', $config);        
          // $this->email->initialize($config);
          // $this->email->from('yanikluis5@gmail.com','webwing@webwing');
          // $this->email->to($email_addr[0]['admin_email']); 
          // $this->email->subject('Reset Your Password');

          $email_data=array(
            'reset_link' => $this->getResetlink($email_addr[0]['admin_id']),
            'email' => $email_addr[0]['admin_email'],
            'name' => $email_addr[0]['admin_username']
            );

          //  $this->email->message($this->load->view('email/reset_password', $email_data,true));

          // if ($this->email->send()) 
          // {
          //    echo "success";
          // } 

          $issent = $this->account_details->send_email($email_addr[0]['admin_email'], 'Reset Your Password', $email_data, 'email/reset_password');

          if($issent){
            echo 'success';
          }
        }
      }else{
        echo form_error('email');
      }    
    }
  }

  public function getResetlink($userId='')
  {
    /*
    Reset function sets encrypted confirmation code and verification status will reset to "0"
    */
    $where = array("admin_id" => $userId);
    $set = array(
      'confirmation_code' => md5($userId),
      'verification_status' => "0"
    );
    
    $edit_record =$this->master_model->updateRecord('admin_login', $set, $where);
      
    return base_url().'admin/login/reset/'.$set['confirmation_code'];
  }

  public function reset($encrypted_userid='')
  {
    /*
      if doctor verified then not allow to reset the password, for that he needs to forget password again

      forget password set the confirmation code and set verification status to the "0"
    */

  $data['success']=$data['error']='';

  $getRecords = $this->master_model->getRecordCount('admin_login', array("confirmation_code"=>$encrypted_userid, "verification_status"=>'0'));

  if($getRecords == 1){

    if(isset($_POST['reset'])){

      $this->form_validation->set_rules('new_password','New Password','trim|required|min_length[6]|max_length[25]|matches[cnf_password]');
      $this->form_validation->set_rules('cnf_password','Confirm Password','trim|required|min_length[6]|max_length[25]');

      if($this->form_validation->run() == TRUE)
      {
        $array_data=$where= array();

        $array_data['admin_password']    = md5($this->input->post('new_password'));
        $array_data['verification_status']  = "1";

        $where["confirmation_code"]   = "'".$encrypted_userid."'";

        $edit_record = $this->master_model->updateRecord('admin_login',$array_data, $where);

        if($edit_record == TRUE)
          {
            $this->session->set_flashdata('success','Password Changed Successfully!');
            redirect(base_url().ADMIN_CTRL);
          }
          else
          {
            $this->session->set_flashdata('error','Error while changing password');
            redirect(base_url().'admin/login/reset/'.$where['user_password']);
          }
      }
    }   

      $arrayData['data'] = $encrypted_userid; 
      $this->load->view('admin/reset_password', $arrayData);    
    }else{

      $this->session->set_flashdata('error','You have already verified');
      redirect(base_url().ADMIN_CTRL);
    }
  }
}
