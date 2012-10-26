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

	