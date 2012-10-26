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
        check('Subjects');
        //$this->load->model('MHomework');
        $this->module=basename(dirname(dirname(__FILE__)));
        //$this->module='category';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_subjects'),$this->module.'/admin');
        mb_internal_encoding('UTF-8');
    }



    function index()
    {
        $module ='subjects';
        $prefix='hw_';
        $criteria="name";
        $order="asc";
        $subjects = $this->MKaimonokago->getAllSimple($module, $where = NULL, $what = NULL,$prefix,$criteria, $order);
        $data['items']=$subjects;
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_index";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);
    }


    function create()
    {
        $this->bep_site->set_crumb("Add ".$this->lang->line('hwezemail_subjects'),$this->module.'/admin');
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_create";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);
    }

}