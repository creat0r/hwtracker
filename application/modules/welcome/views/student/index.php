<?php 
	//$this->load->view('student/topmenu');
    print form_open('auth/login',array('id'=>'myform', 'class'=>'validate horizontal','data-ajax'=>'false'));

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='login_field'>Email</label>"."\n";
    $login_field= array(
        'id'=>'login_field',
        'class'=>'required',
        'name'=>'login_field',
        'placeholder'=>'Email'
        );
    echo form_input($login_field)."\n";
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='password'>Password</label>"."\n";
    $password= array(
        'id'=>'password',
        'class'=>'required',
        'name'=>'password',
        'type'=>'password',
        'placeholder'=>'Password'
        );
    echo form_input($password)."\n";
    echo "</div>\n\n";
    echo form_submit('submit', 'Submit', 'data-icon="gear" data-mini="true" data-inline="true"')."\n";

    echo '<a href="'.site_url().'/auth/forgotten_password" data-role="button" data-inline="true" data-icon="arrow-r" data-rel="dialog" data-transition="pop" data-mini="true" data-theme="a">Forgot password</a>';
    echo '<a href="'.site_url().'/auth/register" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop" data-icon="arrow-r" data-mini="true" data-theme="c">Register</a>';
    print form_close();



	?>	
	<!-- the result of the search will be rendered inside this div -->


	<script>

	$("#myform").validate();

	</script>

	<?php

/*
	// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		echo "<br />profile columns are : ";
print_r($profile_columns);

	echo "<br />session info: ";
	print_r($this->session->all_userdata()) ;
	echo "username is<br />";
	echo $this->session->userdata('username');
	echo "group is<br />";
	echo $this->session->userdata('group');

	echo "<br />ans is: ";


    $email = '123@nacad.ac.jp';
    $ans=$this->form_validation->email_check($email);
    if($ans)
    {
    	echo "TRUE";
    }
    else
    {
    	echo "false";
    }
    print_r ($ans);
    echo $this->preference->item('company_name');


	echo "php session data";
	var_dump($_SESSION);

	echo "<pre>teachername: ";
	print_r($teachername);
	echo "</pre>";
	echo "<pre>teachers: ";
	print_r($teachers);
	echo "</pre>";

	
echo "<pre>subjects: ";
	//print_r($subjects);
	echo "</pre>";
	/*
foreach($teachername->result_array() as $row)
{
	echo "<pre>";
	print_r($row);	
	echo "</pre>";
}
*/
/*
print_r($this->config->item('userlib_profile_fields'));
$fields['id'] = "ID";
$fields = array_merge($fields, $this->config->item('userlib_profile_fields'));
echo "fields are: <br />";
print_r($fields);
echo "<br />";

	if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		print_r ($profile_fields_array);
		}
*/
?>	
