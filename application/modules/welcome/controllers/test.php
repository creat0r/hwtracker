<?php

class Test extends Public_Controller 
{

    public function __construct()
    {
        parent::__construct();
        //check('Student');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('auth/user_model');
        $this->load->model('kaimonokago/MKaimonokago');
        $this->load->model('Mhomework');
    }


    public function index()
    {   
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        
        // display login form
        $data['page']="test/index";
        $this->load->view($this->_container, $data); 
        
    }



}//end controller class