<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_template {

	protected $CI;

    public function activation_email($email_data)
    {
    	$this->CI=& get_instance();

     $arr_email_template = $this->CI->master_model->getRecords('email_template' , array('id' => 33));
      
       if($arr_email_template)
       {
          $reminder = "<a href=".$email_data['reset_link']." target=\"_blank\">Click Here</a>";

          $content = $arr_email_template[0]['template_html'];
          $content = str_replace("##FIRST_NAME##",$email_data['name'],$content);
          $content = str_replace("##USER_EMAIL##", $email_data['email'], $content);
          $content = str_replace("##REMINDER_URL##", $reminder, $content);
          
          $content = html_entity_decode($content);
  			
  		  $email_data = array(
  			'to' => $email_data['email'],
  			'subject' => $arr_email_template[0]['template_subject'],
  			'content' => $content
  			);

             $issent = $this->send_email_template($email_data);
       }  

       return $issent;  
    }

	public function send_email_template($email_data)
  {
             $this->CI=& get_instance();

		$config['protocol']     = 'smtp';
          $config['smtp_host']    = 'ssl://smtp.gmail.com';
          $config['smtp_port']    = '465';
          $config['smtp_timeout'] = '7';
          $config['smtp_user']    = 'yanikluis5@gmail.com';
          $config['smtp_pass']    = 'webwing@webwing';
          $config['charset']      = 'utf-8';
          $config['newline']      = "\r\n";
          $config['mailtype']     = 'html'; // or html
          $config['validation']   = TRUE; // bool whether to validate email or not  

          // Load email library and passing configured values to email library
          $this->CI->load->library('email', $config);
        
          $this->CI->email->initialize($config);
          // Sender email address
          $this->CI->email->from('yanikluis5@gmail.com','webwing@webwing');
          // Receiver email address
          $this->CI->email->to($email_data['to']); 
          
          $this->CI->email->set_mailtype("html");
          // Subject of email
          $this->CI->email->subject($email_data['subject']);
          // Message in email

		$this->CI->email->message($this->CI->load->view("email/email_template", array('content' => $email_data['content']), true));

          if($this->CI->email->send()) 
          {
             return true;
          }
    }
}
