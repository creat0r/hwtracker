<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * 
 * 
 */
class Hwtracker 
{
	private $CI;

	public function __construct()
    {
        // Get CI Instance
		$this->CI = &get_instance();

        $this->CI->load->model('kaimonokago/MKaimonokago');
    }

	

    function get_user_details($what)
    {
    	$module='users';
        $where='id';
        $prefix='be_';
        $user_details=$this->CI->MKaimonokago->getSimple($module, $where, $what,$prefix);
        return $user_details;
    }


    function get_subject($what)
    {
    	$module='subjects';
        $where='id';
        $prefix = 'hw_';
        $subjectdetails=$this->CI->MKaimonokago->getSimple($module, $where, $what,$prefix);
        return $subjectdetails;
    }


	function get_advisor($what)//$userdetails['advisor']
    {
        $module='user_profiles';
        $where='user_id';
        $prefix = 'be_';
        $advisor=$this->CI->MKaimonokago->getSimple($module, $where, $what,$prefix);
        return $advisor;
    }


    function get_principal($what)
    {
    	$module='user_profiles';
        $where='role';
        $prefix='be_';
        $principalprofiledetails=$this->CI->MKaimonokago->getSimple($module, $where, $what,$prefix);
        return $principalprofiledetails;    
    }


    function get_user_profile($what)
    {	
    	$module='user_profiles';
        $where='user_id';
        $prefix='be_';
        $userprofiledetails=$this->CI->MKaimonokago->getSimple($module, $where, $what,$prefix);
    	return $userprofiledetails;
    }


    function get_gender($gender)
    {
    	if($gender=='male')
        {
            $prefix='Mr.';
        }
        else
        {
            $prefix='Ms.';
        }
        return $prefix;
    }


}