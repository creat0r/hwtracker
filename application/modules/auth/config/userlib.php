<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Userlib Configurations
 *
 * Contains all config settings for the Userlib class
 *
 * @package		BackendPro
 * @subpackage 	Configurations
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Authentication Actions
 *
 * These are all the actions performed when an auth process
 * has been completed DO NOT SEND THE LOGIN ACTIONS BACK TO
 * THE LOGIN CONTROLLER, IT WILL CAUSE AN INFINITE LOOP
 */
$config['userlib_action_login'] = 'welcome/student';
$config['userlib_action_logout'] = 'auth/login';
$config['userlib_action_register'] ='auth/register';
$config['userlib_action_activation'] ='';
$config['userlib_action_forgotten_password'] = 'auth/login';
$config['userlib_action_admin_login'] = 'admin';
$config['userlib_action_admin_logout'] = '';
$config['userlib_forgotten_password'] = 'auth/forgotten_password';
$config['userlib_action_auth_login'] = 'auth/login';
$config['userlib_action_teacher_login'] = 'welcome/teacher';
//$config['uselib_action_admin_login'] = 'admin';

/**
 * User Profile Fields
 *
 * Define here all custom user profile fields and their respective rules.
 * To define a new custom profile field, you must specify an
 * associative array from the database column name => Full Name/Rule.
 * If no rule is given for a specific field it will not be validated.
 */
/*

$config['userlib_profile_fields'] = array('first_name' => 'First Name');
$config['userlib_profile_rules'] = array('first_name' => 'required|alpha_numeric');
 
$config['userlib_profile_fields'] = array('last_name' => 'Last name');
$config['userlib_profile_rules'] = array('last_name' => 'required|alpha');
 
$config['userlib_profile_fields'] = array('parent_email1' => 'Parent Email 1');
$config['userlib_profile_rules'] = array('parent_email1' => 'required|valid_email');
 
$config['userlib_profile_fields'] = array('parent_email2' => 'Parent Email 2');
$config['userlib_profile_rules'] = array('parent_email2' => 'required|valid_email');
 
$config['userlib_profile_fields'] = array('advisor' => 'Advisor');
$config['userlib_profile_rules'] = array('advisor' => 'alpha_numeric');

$config['userlib_profile_fields'] = array('teacher' => 'Teacher');
$config['userlib_profile_rules'] = array('teacher' => 'numberic');

*/

// it should be like this, $db['default']['hostname'] = "localhost";

$config['userlib_profile_fields']['first_name'] = 'First Name';
$config['userlib_profile_rules']['first_name'] = 'required|alpha_numeric';
 
$config['userlib_profile_fields']['last_name'] = 'Last name';
$config['userlib_profile_rules']['last_name'] = 'required|alpha';
 
$config['userlib_profile_fields']['parent_email1'] = 'Parent Email 1';
$config['userlib_profile_rules']['parent_email1'] =  'required|valid_email';
 
$config['userlib_profile_fields']['parent_email2'] =  'Parent Email 2';
$config['userlib_profile_rules']['parent_email2'] = 'required|valid_email';
 
$config['userlib_profile_fields']['advisor'] = 'Advisor';
$config['userlib_profile_rules']['advisor'] =  'alpha_numeric';

$config['userlib_profile_fields']['gender'] = 'Gender';
$config['userlib_profile_rules']['gender'] =  'required|alpha';

$config['userlib_profile_fields']['role'] = 'Role';
$config['userlib_profile_rules']['role'] = 'required|alpha';



/* End of file userlib.php */
/* Location: ./modules/auth/config/userlib.php */