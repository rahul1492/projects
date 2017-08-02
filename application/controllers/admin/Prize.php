<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prize extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
      

    } 

	##->by nayan - login for admin
	public function index()
	{	
      $data['arr_pricing_setting']  = $this->master_model->getRecords('pricing_plan');
      //$data['arr_admin_info']   =   $this->master_model->getRecords('admin_login');
      $data['page_title'] = PROJECT_NAME.' | Pricing Setting';
      $data['content'] = "admin/setting/pricing_setting";
      $this->load->view('admin/template',$data);
	}

  public function edit()
  {
   /* echo '<pre>'; print_r($_POST);
    echo '<pre>'; print_r($_FILES); die();*/
    $arr_get_price = $this->master_model->getRecords('pricing_plan',array('id' =>1));
    if(isset($_POST['submit']))
    {
            $this->form_validation->set_rules('platinum','Platinum','required');
            $this->form_validation->set_rules('gold','Gold','required');
            
      if($this->form_validation->run()==TRUE)
      {

                $array_data             = array();

           
                $array_data['platinum']         = $this->input->post('platinum');
                $array_data['gold']             = $this->input->post('gold');  
              
                $whr = array('id'=>1);
                $make_add_record = $this->master_model->updateRecord('pricing_plan',$array_data,$whr);
              
     
              if($make_add_record == TRUE)
                {
                  $this->session->set_flashdata('success',' Pricing Setting Edited Successfully!!');
                  redirect(base_url().ADMIN_CTRL.'/prize');
                }
                else
                {
                  $this->session->set_flashdata('error',' Error While Editing Pricing Setting.');
                  redirect(base_url().ADMIN_CTRL.'/prize');
                }
        }
      }
   }

  

  
  }



