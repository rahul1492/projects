<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        if (!logged_in())
            redirect('auth/login');
        
        $select = $this->db->get('data_orang')->result();
        $numrow = $this->db->get('data_orang')->num_rows();
        
        $data['_select']    = $select;
        $data['_numrow']    = $numrow;
        $this->load->view('welcome_message',$data);
    }
    
    function error_404(){
        $this->load->view('error_404');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */