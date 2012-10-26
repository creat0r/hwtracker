<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * modules/homework/controllers/admin.php
 * 
 * Author   Shin Okada
 * Contact okada.shin@gmail.com
 * version: 2.0
 *
 *
 */

class Admin extends Shop_Admin_Controller 
{
    private $module;



    function __construct()
    {
        parent::__construct();
        // Check for access permission
        check('Homework');
        $this->load->model('welcome/Mhomework');
        $this->module=basename(dirname(dirname(__FILE__)));

        //$this->module='category';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_homework'),$this->module.'/admin');
        mb_internal_encoding('UTF-8');
    }



    function index()
    {
        // get all the homework by student
        $data['hwall']=$this->Mhomework->getallmystudents($id=NULL);
        //$data = $this->common_home();
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_index";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);
    }



    function student()
    {
        // get hw by student with id
        $id =$this->uri->segment(4);
        // get student details from be_user_profiles
        // get user details from id
        $student=$this->user_model->getUsers(array('users.id'=>$id));
        $student = $student->row_array();
        $studentname=$student['first_name']. " ".$student['last_name'];
        
        $data['hws']=$this->Mhomework->gethw($id);
        $data['hwbymonth']=$this->Mhomework->gethwbydate('m', $id);
        $data['hwbyweek']=$this->Mhomework->gethwbydate('w', $id);
        // get total homework missed 
        $data['hwtotal']=$this->Mhomework->get_total($id);

        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_bystudent";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']='Homework Missed by '.$studentname;
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_homework')." Missed by Student",$this->module.'/admin/student/');    
        $this->load->view($this->_container,$data);

    }


    function edit()
    {
        // edit hw by hw id



        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_edit";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);

    }


  
    function hw_byteacher_oradvisor()
    {
        // display hw by advisor id or advisor id
        // link will be admin/advisor/id or admin/teacher/id


        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_create";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);
    }
    


}