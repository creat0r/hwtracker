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
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

    }


    public function index()
    {   
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        
        if ( ! $foo = $this->cache->get('foo'))
        {
           //  echo 'Saving to the cache!<br />';
             $data['foo'] = 'foobarbaz!';

             // Save into the cache for 5 minutes
             $this->cache->save('foo', $foo, 300);
        }

        //echo $foo;
        // display login form
        $data['page']="test/index";
        $this->load->view($this->_container, $data); 
        
    }

    function testcache()
    {
        $data['foo'] = $this->cache->get('foo');
        $data['page']="test/cacheoutput";
        $this->load->view($this->_container, $data);
    }



}//end controller class