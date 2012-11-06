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
    //private $module;

    function __construct()
    {
        parent::__construct();
        // Check for access permission
        check('Teachers');
        $this->load->model('schools/Mschools');

        $this->module=basename(dirname(dirname(__FILE__)));
        //$this->module='category';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_students'),$this->module.'/admin');
        mb_internal_encoding('UTF-8');
    }



    function index()
    {
        // get all the students
        $where= array('group'=>4);
        //$what='5';
        //$student=TRUE;
        //$students=$this->user_model->getUsers($where, $limit = array('limit' => NULL, 'offset' => ''),$student);
        $students=$this->user_model->getUsers($where);
        $students=$students->result_array();
        $data['items']=$students;

        // get all the teacher for student advisor
        $where= array('group'=>5);
        //$what='5';
        $advisors=$this->user_model->getUsers($where);
        $advisors=$advisors->result_array();
        $data['advisors']=$advisors;

        // find advisor for each student
        /*
        foreach($students as $student)
        {
            
        }
        */
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_index";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);


    }

}