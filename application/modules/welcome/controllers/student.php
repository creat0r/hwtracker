<?php

class Student extends Public_Controller 
{
    private $configcachetime;

    public function __construct()
    {
        parent::__construct();
        //check('Students');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('Hwtracker');
        $this->load->library('form_validation');
        $this->load->model('auth/user_model');
        $this->load->model('kaimonokago/MKaimonokago');
        $this->load->model('Mhomework');
        $this->configcachetime=$this->config->item('cachetime');
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
                $status='active';
                $subjects = $this->MKaimonokago->getAllSimple($module, $where = NULL, $what = NULL,$prefix, $criteria, $order, $status);
                
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
        $assignmentname =$this->input->post('assignmentname');
        
        if($id AND $subjectid AND $assignmentname AND $teachernameid)
        {
            // get user details from session
            $userdetails=$this->session->all_userdata();
            $data['userdetails']=$userdetails;
            $data['first_name'] = $first_name = $userdetails['first_name'];
            $data['last_name'] = $last_name= $userdetails['last_name'];
            
            // get advisor details
            $advisor=$userdetails['advisor'];//advisorid
            $advisor=$this->user_model->getUsers(array('users.id'=>$advisor));
            $data['advisordetails']= $advisordetails=$advisor->row_array();
            
            // advisor gender for Mr or Ms.
            $gender = $advisordetails['gender'];
            $data['advisor_gender']=$this->hwtracker->get_gender($gender);

            // find subject name from id
            $what = $subjectid;
            $subjectdetails=$this->hwtracker->get_subject($what);
            $data['subjectname'] = $subjectname = $subjectdetails['name'];

            // get subject teacher user details
            //$what = $teachernameid;
            $teacherdetails=$this->user_model->getUsers(array('users.id'=>$teachernameid));
            $data['teacherdetails']= $teacherdetails=$teacherdetails->row_array();

            // teacher gender
            $gender = $teacherdetails['gender'];
            $data['teacher_gender']=$this->hwtracker->get_gender($gender);

            // find MS principal name
            $what = 'ms_principal';
            $principalprofiledetails=$this->hwtracker->get_principal($what);
            $principalid=$principalprofiledetails['user_id'];
            $principaldetails=$this->user_model->getUsers(array('users.id'=>$principalid));
            $data['principaldetails']= $principaldetails=$principaldetails->row_array();
            // find prinpal's genger
            $gender = $principaldetails['gender'];
            $data['principal_gender']=$this->hwtracker->get_gender($gender);

            // prepare for the content
            $data['username']=$username=$first_name." ".$last_name;
            // for link to show student missed homework
            $encrypted = md5($first_name.$last_name);
            $link=base_url()."index.php/welcome/getpage/".$encrypted;

            // get time from preference or config
            if($this->preference->item('cachepagetime')>0)
            {
                $cachetime=$this->preference->item('cachepagetime');
            }
            else
            {
                $cachetime=$this->configcachetime;
            }
            $time = $cachetime/60;
            // get the site name
            $site_name = $this->preference->item('site_name');
            $company_name = $this->preference->item('company_name');


            $content = <<<EOD
<p>Dear parent,</p>

<p>I am writing to let you know that I did not complete my homework assignment today, $assignmentname, in $subjectname. I will make sure that it is
completed and handed in by the next class meeting.</p>

<p>Please 'Reply All' to confirm that you have read and understand this email.</p>
<p><a href="$link" target="_blank">See more details.</a> This link is avaiable for $time minutes.</p>
<p>Thank you<br />
$username</p>

<p style="font-size:10px; color:grey;"> -- This email was intended for the parents of $username and sent from $company_name $site_name. -- </p> 
EOD;

            $data['assignmentname']=$assignmentname;
            $data['content']=$content;
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
        $to = $this->input->post('to');
        $cc = $this->input->post('cc');
        $email_subject = $this->input->post('email_subject');
        $content = $this->input->post('content');
        $assignmentname = $this->input->post('assignmentname');
        $subjectid = $this->input->post('subjectid');
        $studentid = $this->input->post('studentid');
        $subject_teacherid = $this->input->post('subject_teacherid');
        $username = $this->input->post('username');
        $useremail = $this->input->post('useremail');

        $config[] = array(
                            'field'=>'to',
                            'label'=>'To',
                            'rules'=>"trim|required"
                            );
        $config[] = array(
                            'field'=>'cc',
                            'label'=>'cc',
                            'rules'=>"trim|required"
                            );
        $config[] = array(
                            'field'=>'email_subject',
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
            redirect('welcome/student/mailto','refresh');
        }
        else
        {
            // not at the moment
            // validation has passed. Now send the email
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $this->email->initialize($config); 
            $this->email->from($useremail,$username);

            if(ENVIRONMENT=='development')
            {
                // send to admin_email
                $to=$this->preference->item('admin_email'); 
                $this->email->to($to);// send only to $to
            }
            else
            {
                $this->email->to($to);// Send to parents, subject, advisory teacher and principal
                $this->email->cc($cc);
            }
            //$reply_to=array($useremail,$cc,$to);
            //$this->email->reply_to($reply_to);
            $this->email->subject($email_subject);
            $this->email->message($content);
            $this->email->send();
            

            // save it in DB 
            $table='homework';
            $data = array(
               'studentid' => $studentid ,
               'subjectid' => $subjectid,
               'assignment_name' => $assignmentname ,
               'teacherid' => $subject_teacherid ,
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
        // encript first and last_name
        $user=$this->user_model->getUsers(array('users.id'=>$id));
        $userdetails= $user->row_array();
        //$data['userdetails']=$userdetails;
        $data['userdetails']=$userdetails;
        $data['first_name'] = $first_name = $userdetails['first_name'];
        $data['last_name'] = $last_name= $userdetails['last_name'];
        
        $encrypted = md5($first_name.$last_name);

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
            // save it to cache  
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $data['encrypted']=$encrypted;
            $cachedpage = $data;
            // get time from preference
            /*
            $this->preference->item('cachepagetime');
            // Save into the cache for 5 minutes
            $this->cache->save($encrypted, $cachedpage, 300);
            */
            // get time from preference
             
            if($this->preference->item('cachepagetime')>0)
            {
                $cachetime=$this->preference->item('cachepagetime');
            }
            else
            {
                $cachetime=$this->configcachetime;
            }

                
            // Save into the cache for 5 minutes
            $this->cache->save($encrypted, $cachedpage, $cachetime);

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