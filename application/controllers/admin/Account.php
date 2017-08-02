<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account extends CI_Controller {

  public function __construct()
    {
        parent::__construct();

    } 
/*sfsdf*/
  ##->by nayan - login for admin
  public function index()
  { 
      $data['arr_account_setting']  = $this->master_model->getRecords('account_setting');
      //$data['arr_admin_info']   =   $this->master_model->getRecords('admin_login');
      $data['page_title'] = PROJECT_NAME.' | Account Setting';
      $data['content'] = "admin/setting/account_setting";
      $this->load->view('admin/template',$data);
  }

  public function edit_profile()
  { 

   /* echo '<pre>'; print_r($_POST);
    echo '<pre>'; print_r($_FILES); die();*/
    $arr_get_user = $this->master_model->getRecords('account_setting',array('admin_profile_id' =>1));
    if(isset($_POST['submit']))
    {
            $this->form_validation->set_rules('first_name','First Name','required');
            $this->form_validation->set_rules('last_name','Last Name','required');
            $this->form_validation->set_rules('mobile_number','Mobile Name','required');
            $this->form_validation->set_rules('email','email Name','required');
            $this->form_validation->set_rules('fb_url','Fb Url','required');
            $this->form_validation->set_rules('google_url','Google Url','required');
            $this->form_validation->set_rules('twitter_url','Twitter Url','required');
         if($this->form_validation->run()==TRUE)
      {


          if(isset($_FILES['profile_img']['name']))
          {
   if($_FILES['profile_img']['name']!="")
            {
                  $config['upload_path']    = 'uploads/admin/profile_image/';
                  $config['allowed_types']  = 'gif|jpg|png';
                  $config['max_width']    =   0;
                  $config['max_height']     = 0;
                  $config['max_size']     = 0;
                  $config['encrypt_name']   = TRUE;

                  $this->load->library('upload',$config);
              
                if ( ! $this->upload->do_upload("profile_img"))
                {
                  echo $this->upload->display_errors();
                  $error = array('error' => $this->upload->display_errors());
                  exit;
                }
                else
                {
                  $upload_data  = $this->upload->data();
                  $file_name    = $upload_data['file_name'];
                  $uploaddir = 'uploads/admin/profile_image/';
                  if (file_exists($uploaddir.$arr_get_user[0]["profile_image"]))
                   {
                      unlink($uploaddir.$arr_get_user[0]["profile_image"]);
                   }

                $array_data             = array();

                $array_data['profile_image']       = $file_name;
                $this->session->set_userdata('profile_image', $file_name);
                $array_data['first_name']          = $this->input->post('first_name');
                $array_data['last_name']           = $this->input->post('last_name');
                $array_data['gender']              = $this->input->post('gender');
                $array_data['mobile_number']       = $this->input->post('mobile_number');
                $array_data['website']             = $this->input->post('website');
                $array_data['email']               = $this->input->post('email');
                $array_data['fb_url']              = $this->input->post('fb_url');
                $array_data['google_url']          = $this->input->post('google_url');
                $array_data['twitter_url']         = $this->input->post('twitter_url');
                $array_data['site_status']         = $this->input->post('site_status');
                $whr = array('admin_profile_id'=>1);
                $make_add_record = $this->master_model->updateRecord('account_setting',$array_data,$whr);
                $add_record = $this->master_model->updateRecord('admin_login',array('admin_image'=>$file_name),array('admin_id'=>1));
                }
                  
            }
            else
            {
                $array_data             = array();

                $array_data['first_name']          = $this->input->post('first_name');
                $array_data['last_name']           = $this->input->post('last_name');
                $array_data['gender']              = $this->input->post('gender');
                $array_data['mobile_number']       = $this->input->post('mobile_number');
                $array_data['website']             = $this->input->post('website');
                $array_data['email']               = $this->input->post('email');
                $array_data['fb_url']              = $this->input->post('fb_url');
                $array_data['google_url']          = $this->input->post('google_url');
                $array_data['twitter_url']         = $this->input->post('twitter_url');
                $array_data['site_status']         = $this->input->post('site_status');
                //$array_data['about']             = $this->input->post('about');

                $whr = array('admin_profile_id'=>1);
                $make_add_record = $this->master_model->updateRecord('account_setting',$array_data,$whr);
            }
        }
              if($make_add_record == TRUE)
                {
                  $this->session->set_flashdata('success',' Admin profile Edited successfully!!');
                  redirect(base_url().ADMIN_CTRL.'/account');
                }
                else
                {
                  $this->session->set_flashdata('error',' Error While editing profile.');
                  redirect(base_url().ADMIN_CTRL.'/account');
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
