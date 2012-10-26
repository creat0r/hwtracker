<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mhomework extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_total($id=NULL)
    {
      
        $Q = "SELECT COUNT(studentID) totalmissed
            FROM hw_homework 
            WHERE studentid=$id";

        $query = $this->db->query($Q);
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data = $row;
            }
        }
        $query->free_result();
        return $data;
    }




    function gethw($what)// by studentid
    {
        
        $Q="SELECT hw_subjects.name, COUNT(hw_homework.id) 
            FROM hw_homework 
            LEFT JOIN hw_subjects
            ON hw_subjects.id= hw_homework.subjectid 
            WHERE hw_homework.studentid = $what 
            GROUP BY subjectid 
            ORDER BY hw_subjects.name";

        $query = $this->db->query($Q);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }


    /*
    *   This will find missed homework by month, week, and total and by id
    *   
    * 
    */

    function gethwbydate($date, $id=NULL)
    {
        if($date == 'm')
        {
            // find by month
            $key = "`month`";
            $dateformat="'%M'";

        }
        elseif ($date == 'w') 
        {
            // find by week 
            $key ="`weekno`";
            $dateformat="'%U'";
        }


        if(! empty($id))
        {
            $Q = "SELECT studentID, DATE_FORMAT(`date`, $dateformat) $key,COUNT(studentID) totalMissed
            FROM hw_homework
            WHERE studentID = $id
            GROUP BY studentID, DATE_FORMAT(`date`, $dateformat)";

        }
        else
        {
            $Q="SELECT  studentID, DATE_FORMAT(`date`, $dateformat) $key, COUNT(studentID) totalMissed
            FROM hw_homework
            GROUP BY studentID, DATE_FORMAT(`date`, $dateformat)";
        }
        $query = $this->db->query($Q);
                                    
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row;
            }
              
        }
        $query->free_result();
        return $data;
    }



    function getbyadvisory($id)
    {
        $Q="SELECT studentid, COUNT(studentid),be_user_profiles.first_name, be_user_profiles.last_name
            FROM be_user_profiles
            LEFT JOIN hw_homework
            ON be_user_profiles.user_id= hw_homework.studentid
            WHERE be_user_profiles.advisor = $id
            GROUP BY be_user_profiles.user_id
            ORDER BY be_user_profiles.last_name";
        //$this->db->get_where('hw_homework', array(''));
        $query = $this->db->query($Q);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row;
            }
              
        }
        else
        {
            $data = FALSE;
        }
        $query->free_result();
        return $data;
    }


    /*
    *   get all students homework by teacherid
    *
    */

    function getallmystudents($id=NULL)
    {
        if(! empty($id))
        {
            $Q="SELECT studentid, COUNT(studentid),be_user_profiles.first_name, be_user_profiles.last_name
            FROM hw_homework 
            LEFT JOIN be_user_profiles
            ON be_user_profiles.user_id= hw_homework.studentid
            WHERE hw_homework.teacherid = $id
            GROUP BY be_user_profiles.user_id";
        }
        else
        {
            $Q="SELECT studentid, COUNT(studentid),be_user_profiles.first_name, be_user_profiles.last_name
            FROM be_user_profiles
            RIGHT JOIN hw_homework
            ON be_user_profiles.user_id= hw_homework.studentid
            GROUP BY be_user_profiles.user_id";
        }
        
        //$this->db->get_where('hw_homework', array(''));
        $query = $this->db->query($Q);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row;
            }
              
        }
        $query->free_result();
        return $data;
    }


    /*
    *    get all homework by date for admin
    *       
    */
    function getallbystudent($date, $id=NULL)
    {
        if($date == 'm')
        {
            // find by month
            $key = "`month`";
            $dateformat="'%M'";

        }
        elseif ($date == 'w') 
        {
            // find by week 
            $key ="`weekno`";
            $dateformat="'%U'";
        }


        if(! empty($id))
        {
            $Q = "SELECT studentID, DATE_FORMAT(`date`, $dateformat) $key,COUNT(studentID) totalMissed
            FROM hw_homework
            WHERE studentID = $id
            GROUP BY studentID, DATE_FORMAT(`date`, $dateformat)";

        }
        else
        {
            $Q="SELECT  studentID, DATE_FORMAT(`date`, $dateformat) $key, COUNT(studentID) totalMissed
            FROM hw_homework
            GROUP BY studentID, DATE_FORMAT(`date`, $dateformat)";
        }
        $query = $this->db->query($Q);
                                    
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row;
            }
              
        }
        $query->free_result();
        return $data;
    }


    function insertstudentrecord($record)
    {
        $table='hw_homework';
        $this->db->insert($table, $record); 
    }


    function updatepw($data,$teacherid)
    {
        $this->db->where('id',$teacherid);
        $this->db->update('be_users', $data); 

    }

 
}//end class