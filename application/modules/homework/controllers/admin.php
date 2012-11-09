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
        // get all the teacher for student advisor
        /*
        $where= array('group'=>5);
        //$what='5';
        $advisors=$this->user_model->getUsers($where);
        $advisors=$advisors->result_array();
        */
        $advisors=$this->getadvisors();
        $data['advisors']=$advisors;
        //$data = $this->common_home();
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_general";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['title']=ucfirst($this->module).' Total Number Missed';
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
        // get all student's data for table
        $data['studenthws']=$this->Mhomework->gethw($id, TRUE);
        // get data for week, month
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


    function show_week()
    {
        //getallmystudents($id=NULL, $week=NULL, $month=NULL)
        $date=$this->uri->segment(4);//this_week, last_week
        $data['hwall']=$this->Mhomework->getallmystudents($id=NULL, $date, NULL);
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_general";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $thisweek = date("W-Y");
        $lastweek = date("W-Y", strtotime("-1 week") ) ;
        if($date=='this_week')
        {
            $data['title']='Homework Missed during Week '.$thisweek;
        }
        elseif($date=='last_week')
        {
            $data['title']='Homework Missed during Week '.$lastweek;
        }
        $advisors=$this->getadvisors();
        $data['advisors']=$advisors;
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_homework')." by Week",$this->module.'/admin/show_week/');    
        $this->load->view($this->_container,$data);
    }

    function show_month()
    {
        $date=$this->uri->segment(4);//this_week, last_week
        $data['hwall']=$this->Mhomework->getallmystudents($id=NULL, NULL, $date);
        $data['page'] = $this->config->item('backendpro_template_admin') . "homework_general";
        $data['module'] = $this->module;
        $data['header'] = $this->lang->line('backendpro_access_control');
        $thismonth = date("F-Y"); 
        $lastmonth=date("F-Y", strtotime("-1 month") ) ;
        if($date=='this_month')
        {
            $data['title']='Homework Missed during '.$thismonth;
        }
        elseif($date=='last_month')
        {
            $data['title']='Homework Missed during '.$lastmonth;
        }
        $advisors=$this->getadvisors();
        $data['advisors']=$advisors;
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('hwezemail_homework')." by Month",$this->module.'/admin/show_week/');    
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
    

    function delete_hw()
    {



    }

    function getadvisors()
    {
        $where= array('group'=>5);
        //$what='5';
        $advisors=$this->user_model->getUsers($where);
        $advisors=$advisors->result_array();

        return $advisors;
    }


}