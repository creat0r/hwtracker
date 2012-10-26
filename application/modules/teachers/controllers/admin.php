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
        check('Teachers');
        $this->load->model('schools/Mschools');
        $this->load->model('auth/user_model');
        //$this->load->model('kaimonokago/MKaimonokago');
        $this->module=basename(dirname(dirname(__FILE__)));
        //$this->module='category';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_teachers'),$this->module.'/admin');
        mb_internal_encoding('UTF-8');
    }



    function index()
    {
        // get all the teachers
        //$table='be_users';
        $where= array('group'=>5);
        //$what='5';
        $teachers=$this->user_model->getUsers($where);
        $teachers=$teachers->result_array();
  
        $data['items']=$teachers;

        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_index";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);


    }

}