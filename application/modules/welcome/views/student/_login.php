
<div data-role="content" data-theme="b">	

<?php

	print displayStatus();

	echo '<div data-role="content" data-theme="b">';   

    print form_open('auth/login',array('id'=>'myform2', 'class'=>'validate horizontal','data-ajax'=>'false'));

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
    echo form_submit('submit', 'Submit', 'data-icon="gear" id="submit"')."\n";

    echo '<a href="'.site_url().'/auth/forgotten_password" data-role="button" data-inline="true" data-icon="arrow-r" data-rel="dialog" data-transition="pop" data-theme="a">Forgot password</a>';
    echo '<a href="'.site_url().'/auth/register" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop" data-icon="arrow-r" data-theme="c">Register</a>';
    print form_close();

    echo "</div>";

}

?>	
	<!-- the result of the search will be rendered inside this div -->
</div><!-- /content -->

<script>

$("#myform2").validate();

</script>

<?php
echo "session info: ";
print_r($this->session->all_userdata()) ;
