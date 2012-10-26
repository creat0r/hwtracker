<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * Auth_form_processing
 *
 * Authentication form processing class. This class performs
 * all actions to provide the user with suitable forms to
 * login/logout/register etc with the system.
 *
 * This file is only loaded the when the user goes to
 * the auth controller.
 *
 * @package			BackendPro
 * @subpackage		Libraries
 */
class Homeworklib
{
    private $CI;
    
	function __construct()
	{
		// Get CI Instance
		$this->CI = &get_instance();
		/*
		$this->CI->load->helper('form');

		// Load any files directly related to the authentication module
		$this->CI->load->library('auth/User_email');
		$this->CI->bep_assets->load_asset_group('FORMS');

		// Load any other helpers/libraries needed
		$this->CI->load->library('form_validation');
        $this->CI->load->helper('auth/userlib');
        $this->CI->load->library('auth/userlib');//lang auth/userlib is loaded here
        $this->CI->load->config('auth/userlib');
        $this->CI->load->library('status/status');
		//$this->CI->lang->load('auth/userlib', 'english');
        $this->CI->load->model('user_model');

		log_message('debug','BackendPro : Auth_form_processing class loaded');
		*/
	}


	function changepw()
    {



    }


}
