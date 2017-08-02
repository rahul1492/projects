<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct()
    {
        parent::__construct();

        if($this->session->userdata('admin_info') == "")
		{
			redirect(base_url().ADMIN_CTRL.'/login');
		}
    } 

	public function index()
	{	
		
			$data['page_title'] = "Dashboard";
			$data['content'] = "admin/dashboard";
			$this->load->view('admin/template',$data);
		
	}

	public function logout()
	{
		
			$this->session->sess_destroy();
			redirect(base_url().ADMIN_CTRL.'/login');
		
	}
}
