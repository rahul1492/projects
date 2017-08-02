<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Petproduct extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
      

    } 
/*sfsdf*/
  ##->by nayan - login for admin
  public function index()
  { 
     //$data['arr_account_setting']  = $this->master_model->getRecords('account_setting');
        //$data['arr_admin_info']   =   $this->master_model->getRecords('admin_login');
       //Pagination Code start here  //

    $perpage=isset($_GET['per_page'])? $_GET['per_page']:10;
    $data['page'] = (isset($_GET['page']))? $perpage*(($_GET['page'])-1): 0;
    $data['total'] = $this->master_model->getRecordCount('pet_product');

    $searchName   =   $this->input->get('search_name');
    if(isset($searchName) && $searchName!='')
    {
      $sqlQry = 'SELECT * FROM pet_product WHERE product_name like "'.$searchName.'%"';  
    }
    else
    {
      $sqlQry  = 'SELECT * FROM pet_product' ; 
    }

    //$data['blocked'] = $this->master_model->getRecordCount('pet_colors',array('user_status'=>'0','type'=>'user'));
    //$data['all'] = $this->master_model->getRecordCount('pet_colors',array('type'=>'user'));
    $dataCnt    =   $this->db->query($sqlQry);

    $pageNum    =   $this->input->get('page');
    
    $pageURL    =   base_url().ADMIN_CTRL.'/petproduct?search_name='.$searchName;
    $_pageRes     =   $this->commonPagination($pageNum,$pageURL,count($dataCnt->result_array()),4,$perpage);
    $data['links']  = $_pageRes['page_links'];
    $sqlQuery   =   $sqlQry.' LIMIT '.$_pageRes['offset'].' ,'.$_pageRes['per_page'].'';
    $dataSql    =   $this->db->query($sqlQuery);
    $data['records']=   $dataSql->result_array();
    //$data['total']  =   count($data['dataRes']);

    /*echo '<pre>';
    echo $data['links'];
    print_r($data['blocked']);

    die;
    */

       $data['page_title'] = PROJECT_NAME.' | Pet Product';
       $data['module_name'] = 'Manage Product';
       $data['content'] = "admin/petproduct/petproduct";
      $this->load->view('admin/template',$data);
  }

  public function submit()
  { 

    /*echo '<pre>'; print_r($_POST);
    echo '<pre>'; print_r($_FILES); die();*/
   // $arr_get_user = $this->master_model->getRecords('account_setting',array('admin_profile_id' =>1));
    if(isset($_POST['submit']))
    {
            $this->form_validation->set_rules('product_name','Product Name','required');
            $this->form_validation->set_rules('price','Product Price Name','required');
            $this->form_validation->set_rules('about','Product Details','required');

      
      if($this->form_validation->run()==TRUE)
      {
          if(isset($_FILES['profile_img']['name']))
          {
 
            // if($_FILES['profile_img']['name']!="")
            // {
              //echo '<pre>'; print_r($_FILES);die();
              
                  $config['upload_path']    ='uploads/admin/product_image/';
                  $config['allowed_types']  ='gif|jpg|png';
                  $config['max_width']      = 0;
                  $config['max_height']     = 0;
                  $config['max_size']       = 0;
                  $config['encrypt_name']   = TRUE;

                  $this->load->library('upload',$config);
                  $this->upload->do_upload("profile_img");
              
                // if ( ! $this->upload->do_upload("profile_img"))
                // {
                //   echo $this->upload->display_errors();
                //   $error = array('error' => $this->upload->display_errors());
                //   exit;
                // }
                // else
                // {
                  $upload_data  = $this->upload->data();
                  $file_name    = $upload_data['file_name'];
                
                $array_data             = array();

                $array_data['product_image']                  = $file_name;
                $this->session->set_userdata('product_image', $file_name);
                $array_data['product_name']                  = $this->input->post('product_name');
                $array_data['product_price']                 = $this->input->post('price');
                $array_data['product_description']           = $this->input->post('about');  
              
                //$whr = array('admin_profile_id'=>1);
                $make_add_record = $this->master_model->insertRecord('pet_product',$array_data,$insert_id=FALSE);
                // }

            }
        
        // }
              if($make_add_record == TRUE)
                {
                  $this->session->set_flashdata('success',' Product Added successfully!!');
                  redirect(base_url().ADMIN_CTRL.'/petproduct');
                }
                else
                {
                  $this->session->set_flashdata('error',' Error While Adding product.');
                  redirect(base_url().ADMIN_CTRL.'/petproduct');
                }
           }
         }
       }

   public function edit($id)
   {
      if(isset($id)!=''){
      $id=base64_decode($id);
      
      if(isset($_POST['edit_product'])){
        $id= $this->input->post('record_id') ;
         $arr_get_product = $this->master_model->getRecords('pet_product',array('id' =>$id));
         // echo '<pre>'; print_r($arr_get_product); die();

          // if($this->form_validation->run()==TRUE)
          // {
          if(isset($_FILES['profile_img']['name']))
          {

            if($_FILES['profile_img']['name']!="")
            {
            // die;
              // echo '<pre>'; print_r($_FILES);
              // die();
              
                  $config['upload_path']    = 'uploads/admin/product_image/';
                  $config['allowed_types']  = 'gif|jpg|png';
                  $config['max_width']      =  0;
                  $config['max_height']     =  0;
                  $config['max_size']        = 0;
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
                  // die;
                  $upload_data  = $this->upload->data();
                  $file_name    = $upload_data['file_name'];
                  $uploaddir = 'uploads/admin/product_image/';
                  // print_r($arr_get_product);die;
                    // echo $uploaddir.$arr_get_product[0]["product_image"];die;
                  if(file_exists($uploaddir.$arr_get_product[0]["product_image"]))
                   {
                      unlink($uploaddir.$arr_get_product[0]["product_image"]);
                   }

                $array_data             = array();

                $data['product_image']       = $file_name;
                // $this->session->set_userdata('profile_image', $file_name);
                $data['product_name'] = $this->input->post('product_name');
                $data['product_price'] = $this->input->post('price');
                $data['product_description'] = $this->input->post('about');
       
                $edit_record = $this->master_model->updateRecord('pet_product',$data,array("id"=>$id));
             }
        }
        else
        {
                $array_data = array();

                $array_data['product_image']       = $file_name;
                // $this->session->set_userdata('profile_image', $file_name);
                $data['product_name'] = $this->input->post('product_name');
                $data['product_price'] = $this->input->post('price');
                $data['product_description'] = $this->input->post('about');
       
                $edit_record = $this->master_model->updateRecord('pet_product',$data,array("id"=>$id));
        }
      }
        if($edit_record == TRUE)
        {
          $this->session->set_flashdata('success',' Product edited successfully!');
          redirect($_SERVER['HTTP_REFERER']);
        }
        else
        {
          $this->session->set_flashdata('error',' Error while editing Product.');
          redirect($_SERVER['HTTP_REFERER']);
        }
      // }
     }
     $id=base64_encode($id);
    }
    $id=base64_decode($id);
      $data['arr_pet_product'] = $this->master_model->getRecords('pet_product',array("id"=>$id));
      $data['page_title']   = PROJECT_NAME.' | Edit Product';
      $data['page_name']    = 'Edit Product';
      $data['module_name']  = 'Manage Product';
      $data['content']      = ADMIN_CTRL.'/petproduct/edit_petproduct';
      $this->load->view(ADMIN_VIEW.'/template',$data);  
  }

    public function delete($id)
    {
      if(isset($id)!='')
      {
        $id=base64_decode($id);
        $delete = $this->master_model->deleteRecord('pet_product',array("id"=>$id));
        if($delete==TRUE)
        {
          $this->session->set_flashdata('success',' Product deleted successfully');
          redirect($_SERVER['HTTP_REFERER']);
        }
        else
        {
          $this->session->set_flashdata('error','Error While Deleting Product. ');
          redirect($_SERVER['HTTP_REFERER']);
        }
      } 
    }

    public function unblock($id)
    {
      if(isset($id)!='')
      {
        $id=base64_decode($id);
        $data = array("product_status"=>'1'); 
        $condition = array("id"=>$id);
        $block = $this->master_model->updateRecord('pet_product',$data,$condition);
        if($block==TRUE)
        {
          $this->session->set_flashdata('success',' Product unblock successfully');
          redirect($_SERVER['HTTP_REFERER']);
        }
        else
        {
          $this->session->set_flashdata('error','Error While unblock Product. ');
          redirect($_SERVER['HTTP_REFERER']);
        }
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

    public function block($id)
    {
      if(isset($id)!='')
      {
        $id=base64_decode($id);
        $data = array("product_status"=>'0'); 
        $condition = array("id"=>$id);
        $block = $this->master_model->updateRecord('pet_product',$data,$condition);
      if($block==TRUE)
      {
        $this->session->set_flashdata('success',' Product block successfully');
        redirect($_SERVER['HTTP_REFERER']);
      }
      else
      {
        $this->session->set_flashdata('error','Error While block Product. ');
        redirect($_SERVER['HTTP_REFERER']);
      }
      redirect($_SERVER['HTTP_REFERER']);
    }
  }

  public function multi_action()
  {
    if($_POST['action']=='delete')
    {
      foreach ($_POST['chk'] as $key) 
      {
        $delete = $this->master_model->deleteRecord('pet_product',array("id"=>$key));
      }
      if($delete==TRUE)
      {
        $this->session->set_flashdata('success',' Selected Product Deleted Successfully');
        redirect($_SERVER['HTTP_REFERER']);
      }
      else
      {
        $this->session->set_flashdata('error','Error While Deleting Selected Product. ');
        redirect($_SERVER['HTTP_REFERER']);
      }
    }
      if($_POST['action']=='block')
      {
      foreach ($_POST['chk'] as $key)
       {
        $id=$key;
        $data = array("product_status"=>'0'); 
        $condition = array("id"=>$id);
        $block = $this->master_model->updateRecord('pet_product',$data,$condition);
      }
      $this->session->set_flashdata('success',' Selected Product Blocked Successfully');
      redirect($_SERVER['HTTP_REFERER']);
    }

    if($_POST['action']=='unblock')
    {
      foreach ($_POST['chk'] as $key)
       {
        $id=$key;
        $data = array("product_status"=>'1'); 
        $condition = array("id"=>$id);
        $block = $this->master_model->updateRecord('pet_product',$data,$condition);
      }
      $this->session->set_flashdata('success',' Selected Product Unblocked Successfully');
      redirect($_SERVER['HTTP_REFERER']);
    }
  }
           

    public function commonPagination($segmnetUri,$baseUrl,$totalRec,$configuri,$numOfRec='')
  {
    $resp = array();
        $page_number = $segmnetUri;
        $page_url = $config['base_url'] = $baseUrl;
        $config['uri_segment'] = $configuri;
        if(empty($numOfRec))
        {$numOfRec = 25;}
        $config['per_page'] = $resp['per_page'] = $numOfRec;
        $config['num_links'] = 4;
        if(empty($page_number)) $page_number = 1;
        $offset = ($page_number-1) * $config['per_page'];
        $resp['offset'] = $offset;
        $config['use_page_numbers'] = TRUE; 
        $config['page_query_string'] = TRUE; 
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $totalRec;        
        $page_url = $page_url.'/'.$page_number;
        $config['full_tag_open'] = '<div><nav><ul class="pagination pagination-sm pagination-colory">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="'.$page_url.'">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';     
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';        
        $this->pagination->cur_page = $offset;
        $this->pagination->initialize($config);
        $config['page_links'] = $this->pagination->create_links();
        $resp['page_links'] = $config['page_links'] ;
        return $resp;
  }

}
