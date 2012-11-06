<?php

class Welcome extends Public_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('auth/user_model');
        $this->load->model('kaimonokago/MKaimonokago');
        $this->load->model('Mhomework');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->library('encrypt');
    }

    function index()
    {
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        $data['title']="Submit Missed Homework";
        if( ! $this->input->post('submit'))
        {
            if($this->session->userdata('username') AND $this->session->userdata('group')=='Student')
            {
                // this is teacher, redirect to teacher page
                redirect('welcome/student/index','refresh');
            }
            elseif($this->session->userdata('username') AND $this->session->userdata('group')=='Teacher')
            {
                // this is teacher, redirect to teacher page
                redirect('welcome/teacher/index','refresh');
            }
            else
            {
                // display login form
                $data['page']="student/index";
                $this->load->view($this->_container, $data); 
            }
                 
        }
    }

    function getpage()
    {
        $page=$this->uri->segment(3);
        $data['encrypted_string'] = $page;
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        $data['cache'] = $this->cache->get($page);
        $data['page']="public/index";
        $this->load->view($this->_container, $data);
    }


    function formtest()
    {
        if($this->input->post('submit'))
        {
            $profile = $this->_get_profile_details();
            $data['profile']=$profile;
        }
        else
        {
            $data['profile']="no profile";
        }
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        
        $data['page']="test/test1";
        $this->load->view($this->_container, $data);

    }

    function _get_profile_details()
    {
        $data = array();
        $data['username'] = $this->input->post('username');
        $data['email'] = $this->input->post('email');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['gender'] = $this->input->post('gender');
        $schoolarray=$school = $this->input->post('school');
        if($school AND is_array($school))
        {
            $school = implode(",", $school);
            $data['school'] = $school;
        }
        
        //$data['schoolarray']=$schoolarray;
        return $data;
    }

}//end controller class
