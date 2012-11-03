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
    private $prefix;


    function __construct()
    {
        parent::__construct();
        // Check for access permission
        check('Subjects');
        //$this->load->model('MHomework');
        $this->module=basename(dirname(dirname(__FILE__)));
        $this->prefix="hw_";
        //$this->module='category';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_subjects'),$this->module.'/admin');
        mb_internal_encoding('UTF-8');
    }



    function index()
    {
        $module ='subjects';
        //$prefix='hw_';
        $criteria="name";
        $order="asc";
        //$status="active";
        $subjects = $this->MKaimonokago->getAllSimple($module, $where = NULL, $what = NULL,$this->prefix,$criteria, $order, $status=NULL);
        $data['items']=$subjects;
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_index";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module);
        $this->load->view($this->_container,$data);
    }



    function _fields()
    {
        $data = array(
            'name'          =>  db_clean($_POST['name']),
            'status'        =>  db_clean($_POST['status'],8),
        );
        // $this->MKaimonokago->addItem($this->module, $data);
        return $data;
    }




    function create()
    {
        if ($this->input->post('name'))
        {
            $data = $this-> _fields();
            $this->MKaimonokago->addItem($this->module,$data,$return_id=FALSE,$this->prefix);
            //$this->MMenus->addMenu();
            //$this->session->set_flashdata('message','Menu created');
            flashMsg('success',$this->lang->line('kago_created'));
            redirect($this->module.'/admin/index','refresh');
        }
        else
        {
            $data['cancel_link']= $this->module."/admin/index/";
            $this->bep_site->set_crumb("Add ".$this->lang->line('hwezemail_subjects'),$this->module.'/admin');
            $data['page'] = $this->config->item('backendpro_template_admin') . "homework_create";
            $data['module'] = $this->module;
            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['title']=ucfirst($this->module);
            $this->load->view($this->_container,$data);        
        }
    }


    function edit()
    {
        $id=$this->uri->segment(4);
        if ($this->input->post('name'))
        {
            $data = $this-> _fields();
            $this->MKaimonokago->updateItem($this->module,$data);
            //$this->MCats->updateCategory();
            flashMsg('success',$this->lang->line('hwezemail_subject').$this->lang->line('hwezemail_updated'));
            redirect($this->module.'/admin/index','refresh');
        }
        else
        {
            $data['subject']=$this->MKaimonokago->getSimple($this->module, $where = array('id'=>$id), $what = NULL,$prefix='hw_');
            $data['cancel_link']= $this->module."/admin/index/";
            $this->bep_site->set_crumb("Edit ".$this->lang->line('hwezemail_subjects'),$this->module.'/admin');
            $data['page'] = $this->config->item('backendpro_template_admin') . "homework_edit";
            $data['module'] = $this->module;
            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['title']=ucfirst($this->module);
            $this->load->view($this->_container,$data);  
        }
        
    }


}// end of class
