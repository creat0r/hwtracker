<?php   /* application/modules/auth/views/public/form_login.php */
    //echo '<div data-role="content" data-theme="b">';   

    print "<h3>".$header."</h3>";

    print form_open('auth/login',array('id'=>'myform_login', 'class'=>'horizontal','data-ajax'=>'false'));

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='login_field'>$login_field</label>"."\n";
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
        'placeholder'=>'Password',
        'type'=>'password'
        );
    echo form_input($password)."\n";
    echo "</div>\n\n";
/*
    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='remember'>$this->lang->line('userlib_remember_me')</label>:"."\n";
    $rememberme= array(
        'id'=>'remember',
        'class'=>'required',
        'name'=>'remember',
        'value'=>'yes'
        );
    echo form_checkbox($rememberme)."\n";
    echo "</div>\n\n";

    if($this->preference->item('use_login_captcha'))
    {
        echo '<div data-role="fieldcontain">'."\n";
        echo "<label for='recaptcha_response_field'>$this->lang->line('userlib_captcha')</label>:"."\n";
        print $captcha
        echo form_input()."\n";
        echo "</div>\n\n";
    }    
    
*/
    echo form_submit('submit', 'Submit', 'data-icon="gear" data-mini="true" id="submit"')."\n";

    echo '<a href="'.site_url().'/auth/forgotten_password" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop" data-mini="true" data-theme="a">Forgot password</a>';
    echo '<a href="'.site_url().'/auth/register" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop" data-mini="true" data-theme="c">Register</a>';
    print form_close();

    //echo "</div>";
    ?>

<script>

    $("#myform_login").validate();

</script>