<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Password extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
      

    } 

	##->by nayan - login for admin
	public function index()
	{	
      //$data['arr_account_setting']  = $this->master_model->getRecords('tbl_account_setting');
      $data['arr_admin_info']   =   $this->master_model->getRecords('admin_login');
      $data['page_title'] = PROJECT_NAME.' | Password Change';
      $data['content'] = "admin/password_change";
      $this->load->view('admin/template',$data);
	}



  public function change_password()
  { 

    if(isset($_POST['submit']))
    {
            $this->form_validation->set_rules('current_password','Current Password','required');
            $this->form_validation->set_rules('new_password','New Password','required');
            $this->form_validation->set_rules('confirm_password','Confirm Password','required');
            

      if($this->form_validation->run()==TRUE)
      {
            $array_data             = array();

             $cond = array('admin_password'=>md5($this->input->post('current_password')));
             // $array_data['admin_password']       = $this->input->post('current_password');

             $old_pass = $this->master_model->getRecords('admin_login',$cond,$select=FALSE,$order_by=FALSE,$start=FALSE,$limit=FALSE);
             if(!$old_pass)
             {
                 $this->session->set_flashdata('error',' Invalid Old Password');
              redirect(base_url().ADMIN_CTRL.'/password');
             }
             else
             {
              $array_data['admin_password']       = $this->input->post('new_password');
              $arr_where=array('admin_id'=>1);
              $update_password = $this->master_model->updateRecord('admin_login',$array_data,$arr_where);

             if($update_password==TRUE)
             {
                $this->session->set_flashdata('success',' Password Changed successfully!!');
                redirect(base_url().ADMIN_CTRL.'/password');
             }
            else
            {
              $this->session->set_flashdata('error',' Error While Changed Password.');
              redirect(base_url().ADMIN_CTRL.'/password');
            }
          }
      }

    }
  }

  public function recover_password()
  {
    if(isset($_POST['email']))
    {
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
         $email_addr[0]['admin_email'];
        
         $data= array('admin_password'=>$new_password);
         $whr = array('admin_id'=>1);
         $update_password = $this->master_model->updateRecord('admin_login',$data,$whr);

         if($update_password)
         {
          $config['protocol']     = 'smtp';
          $config['smtp_host']    = 'ssl://smtp.gmail.com';
          $config['smtp_port']    = '465';
          $config['smtp_timeout'] = '7';
          $config['smtp_user']    = 'webwing.testing@gmail.com';
          $config['smtp_pass']    = 'webwing@webwing';
          $config['charset']      = 'utf-8';
          $config['newline']      = "\r\n";
          $config['mailtype']     = 'html'; // or html
          $config['validation']   = TRUE; // bool whether to validate email or not  

          // Load email library and passing configured values to email library
          $this->load->library('email', $config);
        
          $this->email->initialize($config);
          // Sender email address
          $this->email->from('nayan0394@gmail.com','nayan0394');
          // Receiver email address
          $this->email->to($email_addr[0]['admin_email']); 
          // Subject of email
          $this->email->subject('Forgot Password??');
          // Message in email
          $this->email->message('Hey,'.$email_addr['admin_username'].' Your new password is: '.$new_password );

          if ($this->email->send()) 
          {
             echo "success";
          } 
        }  
/*
    $this->load->helper('string');
    $new_password = random_string('alnum', 8);
    echo  

    $update_password = array( 'password' => $this->phpass->hash($new_password));
    $update_password = $this->user->update_password($email, $update_password);

    $this->load->library('email');

    $config['newline'] = '\r\n';
    $this->email->initialize($config);

    $this->email->from('your@example.com', 'Your Name');
    $this->email->to($email);  
    $this->email->subject('New password');
    $this->email->message("Hey, " .$email_addr['name']. ". Your new password is: " .$new_password); 

    if($this->email->send())
    {
    echo json_encode(array('pls'=>1, 'msg' => "Password has been sent to given e-mail address"));
    }
*/
  
    }
  }


}
