<?php

class Student extends Public_Controller 
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
    }


    public function index()
    {   
        $data['header']=$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        $data['title']="Submit Missed Homework";
        if( ! $this->input->post('submit'))
        {
            if($this->session->userdata('username') AND $this->session->userdata('group')=='Student')
            {
                // display subjects, teachers, assignment input etc.
                // get subject list
                $module ='subjects';
                $prefix='hw_';
                $criteria="name";
                $order="asc";
                $subjects = $this->MKaimonokago->getAllSimple($module, $where = NULL, $what = NULL,$prefix, $criteria, $order);
                
                foreach ($subjects as $row)
                {
                    $subjectlist[$row['id']] = $row['name'];
                }
                $data['subjectlist'] = $this -> add_blank_option($subjectlist, ' - Choose Subject-');

                // get teachers array for dropdown
                $where = array('group'=>'5');
                $teachers = $this->user_model->getUsers($where);
                foreach($teachers->result_array() as $row)
                {
                    $teacherlist[$row['id']]=$row['last_name'].', '. $row['first_name'];   
                }
                $data['teachername'] = $this -> add_blank_option($teacherlist, ' - Choose Teacher-');
                $data['teachers']=$teachers;
                // get hwtotal
                $data['hwtotal']=$this->hwtotal();
                // get if all the setting is filled if not redirect to setting with warning
                /*
                    codes here
                */
                $data['page']="student/homework";
                $this->load->view($this->_container, $data);  
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




    public function mailto()
    {
        $data['header'] =$this->preference->item('site_name');
        $data['fttitle']=$this->preference->item('company_name');
        $data['title']="Sending Email";
        $data['hwtotal']=$this->hwtotal();
        $id             =$this->input->post('id');
        $data['subjectid'] = $subjectid =$this->input->post('subjectid');//subject id
        $teachernameid    =$this->input->post('teachername');//teacher id
        //$advisorname  =$this->input->post('advisorname');
        $assignmentname =$this->input->post('assignmentname');
        //$teachernames is an array, let's implode it to string
        //$data['arrayteachers']=$teachernames;
        // find advisory's email
        //$user=$this->user_model->getUsers(array('users.id'=>$id));
        //$data['advisor']=$user['advisor'];
        
        if($id AND $subjectid AND $assignmentname AND $teachernameid)
        {
            // get user details from id
            $user=$this->user_model->getUsers(array('users.id'=>$id));
            $userdetails= $user->row_array();
            //$data['userdetails']=$userdetails;
            $data['userdetails']=$userdetails;
            $data['first_name'] = $first_name = $userdetails['first_name'];
            $data['last_name'] = $last_name= $userdetails['last_name'];
            /*
            $data['studentid'] = $id;
            $data['first_name'] = $first_name = $userdetails['first_name'];
            $data['last_name'] = $last_name= $userdetails['last_name'];
            $data['parent_email1'] = $parent_email1 = $userdetails['parent_email1'];
            $data['parent_email2'] = $parent_email2 = $userdetails['parent_email2'];
            */
            // find advisor name
            //$data['advisor'] = $userdetails['advisor'];
            $module='user_profiles';
            $where='user_id';
            $what = $userdetails['advisor'];
            $prefix = 'be_';
            $advisor=$this->MKaimonokago->getSimple($module, $where, $what,$prefix);
            $data['advisor'] = $advisor['last_name'];

            // advisor gender for Mr or Ms.
            if($advisor['gender']=='male')
            {
                $data['advisor_gender']='Mr.';
            }
            else
            {
                $data['advisor_gender']='Ms.';
            }
            
            // find subject name from id
            $module='subjects';
            $where='id';
            $what = $subjectid;
            $prefix = 'hw_';
            $subjectdetails=$this->MKaimonokago->getSimple($module, $where, $what,$prefix);
            //getInfo($module, $id, $lang_id=NULL)
            //$subject = $this->fetch($moudle,'name','',$where);
            $data['subjectname'] = $subjectname = $subjectdetails['name'];
            // get subject teacher user details
            $module='users';
            $where='id';
            $what = $teachernameid;
            $prefix='be_';
            $data['teacheruserdetails']=$teachername=$this->MKaimonokago->getSimple($module, $where, $what,$prefix);
            

            // find subject teacher name from id
            $module='user_profiles';
            $where='user_id';
            $what = $teachernameid;
            $prefix='be_';
            $data['teacherprofiledetails']=$teacherprofiledetails=$this->MKaimonokago->getSimple($module, $where, $what,$prefix);
            //$data['teachername']=$teachername['last_name'];
            //$data['teacherid']=$teachername['user_id'];

            // teacher gender
            if($teacherprofiledetails['gender']=='male')
            {
                $data['teacher_gender']='Mr.';
            }
            else
            {
                $data['teacher_gender']='Ms.';
            }
            // find MS principal name
            // find subject teacher name and genger from id
            $module='user_profiles';
            $where='role';
            $what = 'ms_principal';
            $prefix='be_';
            $data['principalprofiledetails']=$principalprofiledetails=$this->MKaimonokago->getSimple($module, $where, $what,$prefix);
            
            if($principalprofiledetails['gender']=='male')
            {
                $data['principal_gender']='Mr.';
            }
            else
            {
                $data['principal_gender']='Ms.';
            }
            // get principal's email from users
            $module='users';
            $where='id';
            $what = $principalprofiledetails['user_id'];
            $prefix='be_';
            $data['principaluserdetails']=$principaluserdetails=$this->MKaimonokago->getSimple($module, $where, $what,$prefix);
            

            // prepare for the content
            $username=$first_name." ".$last_name;

            $content = <<<EOD
<p>Dear parent,</p>

<p>I am writing to let you know that I did not complete my homework assignment today, $assignmentname, in $subjectname. I will make sure that it is
completed and handed in by the next class meeting.</p>

<p>Please 'Reply All' to confirm that you have read and understand this email.</p>

<p>Thank you<br />
$username</p>
EOD;

            //$data['teachers']=$teachernames;
            //$data['advisorname']=$advisorname;
            $data['assignmentname']=$assignmentname;
            $data['content']=$content;
            //$data['content_email']=$content_email;    
            //$data['msprincipal']="jschatzky@canacad.ac.jp";
            $data['page']="student/mailto";
            $this->load->view($this->_container, $data);
        }
        else
        {
            flashMsg('info','Something went wrong. Try it again.');
            redirect('welcome/student/index','refresh');
        }
    }


    function sendemail()// also insert studentid, assignment_name, teacherid, date to db hw_homework
    {
        $studentid = $this->input->post('studentid');
        $subjectid = $this->input->post('subjectid');
        $assignmentname = $this->input->post('assignmentname');
        $teacherid = $this->input->post('teacherid');
        /*

        'to'  => "$parent_email1, $parent_email2",
        'cc' => "$teachername, $msprincipal",
        'subject'   => "$subject homework",
        'content'=>$content
        */


        $config[] = array(
                            'field'=>'to',
                            'label'=>'To',
                            'rules'=>"trim|required|valid_email"
                            );
        $config[] = array(
                            'field'=>'cc',
                            'label'=>'cc',
                            'rules'=>"trim|required"
                            );
        $config[] = array(
                            'field'=>'subjectname',
                            'label'=>'Subject',
                            'rules'=>"trim|required"
                            );
        $config[] = array(
                            'field'=>'content',
                            'label'=>'Content',
                            'rules'=>"trim|required"
                            );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE)
        {
            // if any validation errors, display them
            $this->form_validation->output_errors();
            //$captcha_result = '';
            //$data['cap_img'] = $this->_generate_captcha();
            //$data['title'] = $this->preference->item('site_name').": ". lang('webshop_message_contact_us');
            //$data['page']="student/mailto";
            //$this->load->view($this->_container, $data);
            redirect('welcome/student/mailto','refresh');
        }
        else
        {
            /* not at the moment
            // validation has passed. Now send the email
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            // get email from preferences/settings
            $myemail = $this->preference->item('admin_email');
            $this->load->library('email');
            $this->email->from($email.$name);
            $this->email->to($parentemail1);// Send to parents, subject, advisory teacher and principal
            $this->email->subject(sprintf(lang('webshop_message_subject'),$this->preference->item('site_name')));
            $this->email->message(lang('webshop_message_sender').
            $name."\r\n".lang('webshop_message_sender_email').": ".
            $email. "\r\n".lang('webshop_message_message').": " . $message);
            $this->email->send();
            */

            // save it in DB 
            $table='homework';
            $data = array(
               'studentid' => $studentid ,
               'subjectid' => $subjectid,
               'assignment_name' => $assignmentname ,
               'teacherid' => $teacherid ,
               //'date' => ''
            );
            $prefix = 'hw_';
            $this->MKaimonokago->simpleinsertitem($table, $data,$prefix);
            flashMsg('success', 'You have sent message.');
            // $this->session->set_flashdata('subscribe_msg', lang('webshop_message_thank_for_message'));
            redirect('welcome/student/myhomework/'.$studentid,'refresh');
        }
    }
    

    public function setting()
    {
         // Modify form, first load
        $id  = $this->session->userdata('id');
        if(empty($id))
        {
            redirect('welcome/student/index','refresh');
        }
        // get user details from id
        $user=$this->user_model->getUsers(array('users.id'=>$id));
        $user = $user->row_array();
        // from auth/controllers/members function form()
        

        if($this->input->post('submit'))
        {
            //form is submitted 
            // validate
            // VALIDATION FIELDS
            /*
            $fields['id'] = "ID";
            $fields['confirm_password'] = $this->lang->line('userlib_confirm_password');
            $fields['group'] = $this->lang->line('userlib_group');
            $fields['active'] = $this->lang->line('userlib_active');
            $fields = array_merge($fields, $this->config->item('userlib_profile_fields'));
            $config;
            $this->form_validation->set_fields($fields);
            */
            // Setup validation rules
            if(is_null($id))
            {
                //redirect
                flashMsg('warning','Your ID is not found. Logout and Login again.');
                redirect ('welcome/student/index','refresh');
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
                                    'field'=>'parent_email1',
                                    'label'=>'Parent Email 1',
                                    'rules'=>"trim|required|valid_email"
                                    );
                    $config[] = array(
                                    'field'=>'parent_email2',
                                    'label'=>'Parent Email 2',
                                    'rules'=>"trim|valid_email"
                                    );
                    
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
                $this->form_validation->set_default_value('parent_email1',$user['parent_email1']);
                $this->form_validation->set_default_value('parent_email2',$user['parent_email2']);
                $this->form_validation->set_default_value('advisor',$user['advisor']);
                // dropdown for advisor/teacher list
                // get teachers array for dropdown
                $where = array('group'=>'5');
                $teachers = $this->user_model->getUsers($where);
                foreach($teachers->result_array() as $row)
                {
                    $teacherlist[$row['id']]=$row['last_name'].', '. $row['first_name'];   
                }
                $data['advisors'] = $this -> add_blank_option($teacherlist, ' - Choose Your Advisor-');

                $data['user']=$user;
                $data['title']="My Settings";
                $data['header']=$this->preference->item('site_name');
                $data['fttitle']=$this->preference->item('company_name');
                $data['page']="student/setting";
                $this->load->view($this->_container, $data);
            }
            else
            {
                
                // SAVE
                $user = $this->_get_user_details();//get id, username, email from post
                $user['modified'] = date('Y-m-d H:i:s');
                // get first_name, last_name, parent_email1, parent_email2 from post
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
                redirect('welcome/student/index','refresh'); 
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
            $this->form_validation->set_default_value('parent_email1',$user['parent_email1']);
            $this->form_validation->set_default_value('parent_email2',$user['parent_email2']);
            $this->form_validation->set_default_value('advisor',$user['advisor']);
            // dropdown for advisor/teacher list
            $where = array('group'=>'5');
            $teachers = $this->user_model->getUsers($where);
            foreach($teachers->result_array() as $row)
            {
                $teacherlist[$row['id']]=$row['last_name'].', '. $row['first_name'];   
            }
            $data['advisor'] = $this -> add_blank_option($teacherlist, ' - Choose Your Advisor-');

            $data['user']=$user;
            $data['title']="My Settings";
            $data['header']=$this->preference->item('site_name');
            $data['fttitle']=$this->preference->item('company_name');
            $data['page']="student/setting";
            $this->load->view($this->_container, $data);

        }
    }
	

    /*
    * display all homework
    *
    */


    public function myhomework()
    {
        $id=$this->uri->segment(4);
        // find subject teacher name and genger from id
        if($id==$this->session->userdata('id'))
        {
            // get homework details by subjects
            $what = $id;
            $data['hwdetails']=$this->Mhomework->gethw($what);
            // get total number of homework


            // get homework details by month
            $month = 'm';
            $week ='w';
            $data['hwdetailsbymonth']=$this->Mhomework->gethwbydate($month, $what);
            // get homework details by week
            $data['hwdetailsbyweek']=$this->Mhomework->gethwbydate($week, $what);
            // get total homework missed 
            $data['hwtotal']=$this->Mhomework->get_total($what);

            // total homework missed
            //$data['hwdetailsbyallmonth']=$this->Mhomework->gethwbydate($month);
            //$data['hwdetailsbyallweek']=$this->Mhomework->gethwbydate($week);

            $data['title']="My Missed Homework";
            $data['header']=$this->preference->item('site_name');
            $data['fttitle']=$this->preference->item('company_name');
            $data['page']="student/myhomework";
            $this->load->view($this->_container, $data);
        }
        else
        {
            flashMsg('warning', 'Refresh and try it again....');
            redirect('welcome/student/index', 'refresh');
        }
        
    }






    function changepw()
    {
        $userid=$this->uri->segment(4);
        $data['hwtotal']=$this->Mhomework->get_total($userid);
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
                $data['page'] =  "student/changepw";
                $data['title']='Change Password';
                $data['header']=$this->preference->item('site_name');
                $data['fttitle']=$this->preference->item('company_name');
                $this->load->view($this->_container,$data); 
            }
            else
            {
                //save it
                //$this->userlib->encode_password($this->input->post('password'));
                $userid=$this->input->post('id');
                $data= array(
                    'password'=>$this->userlib->encode_password($this->input->post('password'))
                    );
                
                $this->Mhomework->updatepw($data,$userid);
                // redirect with message
                // redirect with message
                flashMsg('success','You have changed your password.');
                //flashMsg('success','test');
                redirect('welcome/student/index','refresh'); 
            }
        }        
        else
        {
            // display form
            $data['page'] =  "student/changepw";
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
        $data['parent_email1'] = $this->input->post('parent_email1');
        $data['parent_email2'] = $this->input->post('parent_email2');
        $data['advisor'] = $this->input->post('advisor');
        return $data;
    }


    /*
    * check setting field is filled
    */
    function _checksetting()
    {
        /*
        //get id from the session
        $id  = $this->session->userdata('id');
        // get user details from id
        $user=$this->user_model->getUsers(array('users.id'=>$id));
        $user = $user->row_array();
*/
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



    function hwtotal()
    {
        $id=$this->session->userdata('id');
        $hwtotal=$this->Mhomework->get_total($id);
        return $hwtotal;
    }



}//end controller class