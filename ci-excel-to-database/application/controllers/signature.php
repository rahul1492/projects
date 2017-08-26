<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author : Ismo Broto : git @ismo1106
 */

class Signature extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        if (!logged_in())
            redirect('auth/login');
    }
    
    function index(){
        $this->load->view('signature-index');
    }
    
    function convertToImg(){
        define('UPLOAD_DIR', './imgSignature/');
	$img = $GLOBALS['HTTP_RAW_POST_DATA'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';
    }
}