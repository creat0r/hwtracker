<?php

class Teacher extends Public_Controller 
{

    private $teacherid;
    private $username;
    private $usergroup;

    public function __construct()
    {
        parent::__construct();
        //check('Teachers');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('homeworklib');
        $this->load->model('auth/user_model');
        $this->load->model('kaimonokago/MKaimonokago');
        $this->load->model('Mhomework');
        $this->teacherid=$this->session->userdata('id');
        $this->username = $this->session->userdata('username');
        $this->usergroup = $this->session->userdata('group');
        if(! $this->username || $this->usergroup !=='Teacher')
        {
            //redirect
            //flashMsg('warning','You don\'t have permission to view this page.');
            redirect ('welcome/student/index','refresh');
        }
    }


    function index()
    {
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        //check('Teachers');
        // get advisees missing homework
        $data['advisory'] = $this->Mhomework->getbyadvisory($this->teacherid);
        $data['teacherid']=$this->teacherid;
        // display login form
        $data['title']='Homework Missed by My Advisees';
        $data['page']="teacher/home";
        $this->load->view($this->_container, $data); 
    }
    

    function mysubject()
    {
        //check('Teachers');
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        $data['title']='All Missed Homework in My Subject';
        $id = $this->uri->segment(4);

        // get all my students record
        $data['allmystudents'] = $this->Mhomework->getallmystudents($this->teacherid);

        $data['page']="teacher/allstudents";
        $this->load->view($this->_container, $data); 

    }



    public function setting()
    {
         // Modify form, first load
        $id  = $this->session->userdata('id');
        // get user details from id
        $user=$this->user_model->getUsers(array('users.id'=>$id));
        $user = $user->row_array();
        // from auth/controllers/members function form()
        

        if($this->input->post('submit'))
        {
            // Setup validation rules
            if(is_null($id))
            {
                //redirect
                flashMsg('warning','Your ID is not found. Logout and Login again.');
                redirect ('welcome/teacher/index','refresh');
            }
            else
            {
                    $config[] = array(
                                    'field'=>'username',
                                    'label'=>$this->lang->line('userlib_username'),
                                    'rules'=>"trim|required|callback_spare_edit_username"
                                    );
                    $config[] = array(
                                    'field'=>'email',
                                    'label'=>$this->lang->line('userlib_email'),
                                    'rules'=>"trim|required|valid_email|callback_spare_edit_email"
                                    );
                    $config[] = array(
                                    'field'=>'first_name',
                                    'label'=>'First Name',
                                    'rules'=>"trim|required|"
                                    );
                    $config[] = array(
                                    'field'=>'last_name',
                                    'label'=>'Last Name',
                                    'rules'=>"trim|required"
                                    );
                    $config[] = array(
                                    'field'=>'gender',
                                    'label'=>'Gender',
                                    'rules'=>"trim"
                                    );
                   // don't add this since it is an array
                   /* $config[] = array(
                                    'field'=>'school',
                                    'label'=>'School',
                                    'rules'=>"trim"
                                    );*/
                    
            // Use edit user rules (make sure no-one other than the current user has the same email)
            }
            // Form submited, check rules
            $this->form_validation->set_rules($config);
            // Setup form default values

            // RUN
            if ($this->form_validation->run() == FALSE)
            {

                // Display form
                $this->form_validation->output_errors();
                $this->form_validation->set_default_value('id',$user['id']);
                $this->form_validation->set_default_value('username',$user['username']);
                $this->form_validation->set_default_value('email',$user['email']);
                $this->form_validation->set_default_value('first_name',$user['first_name']);
                $this->form_validation->set_default_value('last_name',$user['last_name']);
                $this->form_validation->set_default_value('gender',$user['gender']);
                $this->form_validation->set_default_value('school',$user['school']);
                //$this->form_validation->set_default_value('parent_email2',$user['parent_email2']);
                //$this->form_validation->set_default_value('advisor',$user['advisor']);
                // dropdown for advisor/teacher list
                
                $data['user']=$user;
                $data['title']="My Settings";
                $data['header']=$this->preference->item('site_name');
                $data['fttitle']=$this->preference->item('company_name');
                $data['page']="teacher/setting";
                $this->load->view($this->_container, $data);
            }
            else
            {
                
                // SAVE
                $user = $this->_get_user_details();//get id, username, email from post
                $user['modified'] = date('Y-m-d H:i:s');
                // get first_name, last_name, gender and school from post
                $profile = $this->_get_profile_details();

                $this->db->trans_begin();
                $this->user_model->update('Users',$user,array('id'=>$user['id']));

                // The && count($profile) > 0 has been added here since if no update keys=>values
                // are passed to the update method it errors saying the set method must be set
                // See bug #51
                if($this->preference->item('allow_user_profiles') && count($profile) > 0)
                {
                    $this->user_model->update('UserProfiles',$profile,array('user_id'=>$user['id']));
                }

                if($this->db->trans_status() === TRUE)
                {
                    $this->db->trans_commit();
                    flashMsg('success',sprintf($this->lang->line('userlib_user_saved'),$user['username']));
                }
                else
                {
                    $this->db->trans_rollback();
                    flashMsg('error',sprintf($this->lang->line('backendpro_action_failed'),$this->lang->line('userlib_edit_user')));
                }
                
                //flashMsg('success','test');
                redirect('welcome/teacher/index','refresh'); 
            }
            // upto her from funciton form()
        }
        else
        {

            //load data from db
           
            // set default value
            $this->form_validation->set_default_value('id',$user['id']);
            $this->form_validation->set_default_value('username',$user['username']);
            $this->form_validation->set_default_value('email',$user['email']);
            $this->form_validation->set_default_value('first_name',$user['first_name']);
            $this->form_validation->set_default_value('last_name',$user['last_name']);
            $this->form_validation->set_default_value('gender',$user['gender']);
            $this->form_validation->set_default_value('school',$user['school']);

            $data['user']=$user;
            $data['title']="My Settings";
            $data['header']=$this->preference->item('site_name');
            $data['fttitle']=$this->preference->item('company_name');
            $data['page']="teacher/setting";
            $this->load->view($this->_container, $data);

        }
    }



    function studentrecord()
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
        $data['page'] =  "teacher/homework_bystudent";
        $data['title']='Homework Missed by '.$studentname. " in All Subjects";
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        $this->load->view($this->_container,$data);
    }



    function addstudentrecord()
    {
       $this->bep_assets->load_asset_group('mobiledatepicker');
        if($this->input->post('submit'))
        {

            $config[] = array(
                            'field'=>'assignment_name',
                            'label'=>'Assignment name',
                            'rules'=>"trim|required"
                            );
            $config[] = array(
                            'field'=>'studentid',
                            'label'=>'Student name',
                            'rules'=>"trim|required"
                            );
            $config[] = array(
                            'field'=>'subjectid',
                            'label'=>'Subject Name',
                            'rules'=>"trim|required"
                            );
            $config[] = array(
                            'field'=>'teacherid',
                            'label'=>'Teacher Name',
                            'rules'=>"trim|required"
                            );
            $config[] = array(
                            'field'=>'date',
                            'label'=>'Date',
                            'rules'=>"trim|required"
                            );
                    
            
            // Form submited, check rules
            $this->form_validation->set_rules($config);

            // RUN
            if ($this->form_validation->run() == FALSE)
            {

                // set input data and return to the form
                // display the form
                // need assignment name, student id and name dropdown, date, subject id/name dropdown, hidden teacherid
                // get all the students
                $where= array('group'=>4);
                //$what='5';
                $students=$this->user_model->getUsers($where);
                $students=$students->result_array();
                foreach($students as $student)
                {
                    $studentdata[$student['id']] = $student['first_name']." ".$student['last_name'];
                }
                $data['students']=$this -> add_blank_option($studentdata, ' - Choose Student -');

                //$data['students']=$studentdata;

                //subject dropdown
                $module ='subjects';
                $prefix='hw_';
                $criteria="name";
                $order="asc";
                $subjects = $this->MKaimonokago->getAllSimple($module, $where = NULL, $what = NULL,$prefix,$criteria, $order);
                
                foreach ($subjects as $row)
                {
                    $subjectlist[$row['id']] = $row['name'];
                }
                $data['subjectlist'] = $this -> add_blank_option($subjectlist, ' - Choose Subject-');


                $this->form_validation->output_errors();

                $data['page'] =  "teacher/addstudentrecord";
                $data['title']='Add Student Missed Homework';
                $data['header']=$this->preference->item('site_name');
                $data['fttitle']=$this->preference->item('company_name');
                $this->load->view($this->_container,$data);

            }
            else
            {
                //save it
                $hwrecord['assignment_name']=$this->input->post('assignment_name');
                $hwrecord['studentid']=$this->input->post('studentid');
                $hwrecord['subjectid']=$this->input->post('subjectid');
                $hwrecord['teacherid']=$this->input->post('teacherid');
                $hwrecord['date']=$this->input->post('date');
                
                // get time now
                //$hwrecord['date']=date("Y-m-d H:i:s",time());
                
                // call model to insert
                $this->Mhomework->insertstudentrecord($hwrecord);
                // redirect with message
                flashMsg('success','New record is added.');
                //flashMsg('success','test');
                redirect('welcome/teacher/index','refresh'); 

            }
            
        }
        else
        {
            // display the form
            // need assignment name, student id and name dropdown, date, subject id/name dropdown, hidden teacherid
            // get all the students
            $where= array('group'=>4);
            //$what='5';
            $students=$this->user_model->getUsers($where);
            $students=$students->result_array();
            
            if(! empty($students))
            {
                foreach($students as $student)
                {
                    $studentdata[$student['id']] = $student['first_name']." ".$student['last_name'];
                }
                $data['students']=$this -> add_blank_option($studentdata, ' - Choose Student -');
            }
            else
            {
                $data['students']="";
            }
            
            //$data['students']=$studentdata;

            //subject dropdown
            $module ='subjects';
            $prefix='hw_';
            $criteria="name";
            $order="asc";
            $subjects = $this->MKaimonokago->getAllSimple($module, $where = NULL, $what = NULL,$prefix,$criteria,$order);
            
            foreach ($subjects as $row)
            {
                $subjectlist[$row['id']] = $row['name'];
            }
            $data['subjectlist'] = $this -> add_blank_option($subjectlist, ' - Choose Subject -');

            $data['page'] =  "teacher/addstudentrecord";
            $data['title']='Add Student Missed Homework';
            $data['header']=$this->preference->item('site_name');
            $data['fttitle']=$this->preference->item('company_name');
            $this->load->view($this->_container,$data);

        }
        
    }




    function changepw()
    {

        if($this->input->post('submit'))
        {
            // config pw and pwconf
            $config[]=array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'required|matches[passconf]'
                    );
            $config[]=array(
                 'field'   => 'passconf',
                 'label'   => 'Password Confirmation',
                 'rules'   => 'required'
                    );   
            // Form submited, check rules
            $this->form_validation->set_rules($config);

            // RUN
            if ($this->form_validation->run() == FALSE)
            {
                $this->form_validation->output_errors();
                $data['page'] =  "teacher/changepw";
                $data['title']='Change Password';
                $data['header']=$this->preference->item('site_name');
                $data['fttitle']=$this->preference->item('company_name');
                $this->load->view($this->_container,$data); 
            }
            else
            {
                //save it
                //$this->userlib->encode_password($this->input->post('password'));
                $teacherid=$this->input->post('id');
                $data= array(
                    'password'=>$this->userlib->encode_password($this->input->post('password'))
                    );
                
                $this->Mhomework->updatepw($data,$teacherid);
                // redirect with message
                // redirect with message
                flashMsg('success','You have changed your password.');
                //flashMsg('success','test');
                redirect('welcome/teacher/index','refresh'); 
            }
        }        
        else
        {
            // display form
            $data['page'] =  "teacher/changepw";
            $data['title']='Change Password';
            $data['header']=$this->preference->item('site_name');
            $data['fttitle']=$this->preference->item('company_name');
            $this->load->view($this->_container,$data);
        }
    }




    function _pull_profile_details($id)
    {
        $row = array();
        $query=$this->user_model->fetch('UserProfiles','*','',array('user_id'=>$id));
        $row = $query->row_array();
        return $row;
    }



    function _get_user_details()
    {
        $data = array();
        $data['id'] = $this->input->post('id');
        $data['username'] = $this->input->post('username');
        $data['email'] = $this->input->post('email');
        return $data;
    }


    function _get_profile_details()
    {
        $data = array();
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['gender'] = $this->input->post('gender');
        $school = $this->input->post('school');
        
        if($school && is_array($school))// check it if school has value, otherwise implode will give error.
        {
            $school = implode(",", $school);
            $data['school'] = $school;
        }
        
        
        return $data;
    }
    


     /*
    * This function add blank option to dropdown.
    */
    function add_blank_option($options, $blank_option = '') 
    {
        if (is_array($options) && is_string($blank_option))
        {
           if (empty($blank_option))
           {
              $blank_option = array( NULL => '--');
           }
           else
           {
              $blank_option = array( NULL => $blank_option);
           }
           $options = $blank_option + $options;
           return $options;
        }
        else
        {
           show_error("Wrong options array passed");
        }
    } 

  
	
}//end controller class
