<?php   /* application/modules/auth/views/public/form_forgotten_password.php */
    //echo '<div data-role="content" data-theme="b">';  

    print "<h3>".$header."</h3>";
    print form_open('auth/forgotten_password',array('id'=>'myform_forgottenpw', 'class'=>'vertical','data-ajax'=>'false'));

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='email'>".$this->lang->line('userlib_email')."</label>"."\n";
        $email= array(
        'id'=>'email',
        'class'=>'required',
        'name'=>'email',
        'placeholder'=>'Email'
        );
    echo form_input($email)."\n";
    echo "</div>\n\n";

    echo '<a href="'.site_url().'/welcome/student" data-role="button" data-icon="back" data-inline="true" data-transition="pop" data-mini="true" data-theme="e">'.$this->lang->line('general_cancel').'</a>';
    
    echo form_submit('submit', 'Submit', 'data-icon="gear" data-inline="true" data-mini="true" id="submit"')."\n";
            	
    print form_close();

    ?>


<script>

    $("#myform_forgottenpw").validate();

</script>