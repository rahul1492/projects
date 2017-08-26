<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        //Get Total Records Count
        $this->db->select("*");
        $this->db->from("cities");
        if (!empty($_GET['cityFilter'])) {
            $this->db->like('city_name', $_GET['cityFilter']);
        }
        $cityRecordsCount = $this->db->get();

        $totalRecords = $cityRecordsCount->num_rows();
        $limit = 5;

        if (!empty($_GET['cityFilter'])) {
            $config["base_url"] = base_url('listing/index?cityFilter=' . $_GET['cityFilter']);
        } else {
            $config["base_url"] = base_url('listing/index?cityFilter=');
        }

        $config["total_rows"] = $totalRecords;
        $config["per_page"] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        $config['num_links'] = 2;
        $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        $str_links = $this->pagination->create_links();
        $links = explode('&nbsp;', $str_links);

        $offset = 0;
        if (!empty($_GET['per_page'])) {
            $pageNo = $_GET['per_page'];
            $offset = ($pageNo - 1) * $limit;
        }
        
        //Get actual result from all records with pagination
        $this->db->select("*");
        $this->db->from("cities");
        if (!empty($_GET['cityFilter'])) {
            $this->db->like('city_name', $_GET['cityFilter']);
        }
        $this->db->limit($limit, $offset);
        $cityRecords = $this->db->get();
        $this->load->view('listCities', array(
            'totalResult' => $totalRecords,
            'results' => $cityRecords->result(),
            'links' => $links
        ));
    }

}
