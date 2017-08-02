<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('print_data'))
{
	function print_data($data)
	{
		$data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strtolower($data);
        $data = ucfirst($data);
        return $data;
	}   
}

if( ! function_exists('test_data'))
{
	function test_data($data)
	{
		$data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strtolower($data);
        return $data;
	}   
}

if(!function_exists('session_check')){
        
        function session_check(){
                $CI = & get_instance();

                // if($CI->session->userdata('admin_info') == ""){

                //          redirect(base_url().ADMIN_CTRL.'/login');
                // }

                // if($CI->session->userdata('admin_info')['admin_url'] != base_url().ADMIN_CTRL){

                //      redirect(base_url().ADMIN_CTRL.'/login');
                // }

                if($CI->session->userdata('admin_info') != ""){
                        redirect(base_url().ADMIN_CTRL.'/dashboard');
                }
        }
}