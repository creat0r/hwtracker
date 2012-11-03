<?php

class Welcome extends Public_Controller 
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
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->library('encrypt');
    }

    function getpage()
    {
        $page=$this->uri->segment(3);
        $data['encrypted_string'] = $page;

        //$data['plaintext_string'] = $this->encrypt->decode($encrypted_string);
        //$foo = $this->cache->get('my_cached_item');
        //$data['title']="Missed Homework by ";
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        $data['cache'] = $this->cache->get($page);
        $data['page']="test/index";

        $this->load->view($this->_container, $data);
    }
}//end controller class
