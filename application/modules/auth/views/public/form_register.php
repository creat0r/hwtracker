<?php  /*  application/modules/auth/views/public/form_register.php */
    //echo '<div data-role="content" data-theme="b">';  
    print displayStatus();
    print "<h3>".$header."</h3>";
    print form_open('auth/register',array('id'=>'myform_register', 'class'=>'horizontal','data-ajax'=>'false'));


    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='username'>".$this->lang->line('userlib_username')."</label>"."\n";
        $username= array(
        'id'=>'username',
        'class'=>'required',
        'name'=>'username',
        'placeholder'=>'User name',
        'value'=>set_value('username'),
        );
    echo form_input($username)."\n";
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='email'>".$this->lang->line('userlib_email')."</label>"."\n";
        $email= array(
        'id'=>'email',
        'class'=>'required',
        'name'=>'email',
        'placeholder'=>'Email',
        'value'=>set_value('email'),
        );
    echo form_input($email)."\n";
    echo "</div>\n\n";


    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='password'>".$this->lang->line('userlib_password')."</label>"."\n";
        $password= array(
        'id'=>'password',
        'class'=>'required',
        'name'=>'password',
        'placeholder'=>'Password',
        'type'=>'password'
        );
    echo form_input($password)."\n";
    echo "</div>\n\n";


    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='confirm_password'>".$this->lang->line('userlib_confirm_password')."</label>"."\n";
        $confirm_password= array(
        'id'=>'confirm_password',
        'class'=>'required',
        'name'=>'confirm_password',
        'placeholder'=>'Confirm password',
        'type'=>'password'
        );
    echo form_input($confirm_password)."\n";
    echo "</div>\n\n";

    // first_name
    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='first_name'>".$this->lang->line('webshop_first_name')."</label>"."\n";
        $first_name= array(
        'id'=>'first_name',
        //'class'=>'required',
        'name'=>'first_name',
        'placeholder'=>'First name',
        'value'=>set_value('first_name'),
        );
    echo form_input($first_name)."\n";
    echo "</div>\n\n";

    // last_name
    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='last_name'>".$this->lang->line('webshop_last_name')."</label>"."\n";
        $last_name= array(
        'id'=>'last_name',
        //'class'=>'required',
        'name'=>'last_name',
        'placeholder'=>'Last name',
        'value'=>set_value('last_name'),
        );
    echo form_input($last_name)."\n";
    echo "</div>\n\n";

    // parent_email1
    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='parent_email1'>Parent Email 1</label>"."\n";
        $parent_email1= array(
        'id'=>'parent_email1',
        //'class'=>'required',
        'name'=>'parent_email1',
        'placeholder'=>'Parent email 1',
        'value'=>set_value('parent_email1'),
        );
    echo form_input($parent_email1)."\n";
    echo "</div>\n\n";

    // parent_email2
    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='parent_email2'>Parent Email 2 (optional)</label>"."\n";
        $parent_email2= array(
        'id'=>'parent_email2',
        'name'=>'parent_email2',
        'placeholder'=>'Parent email 2(optional)',
        'value'=>set_value('parent_email2'),
        );
    echo form_input($parent_email2)."\n";
    echo "</div>\n\n";

    // advisor
    echo '<div data-role="fieldcontain">'."\n";
    echo '<label for="advisor">Advisor</label>'."\n";
    echo form_dropdown('advisor', $advisors, set_value('advisor'), 'id="advisor" class="required" data-native-menu="false" data-theme="c"')."<br />\n";
    echo "</div>\n\n";


    

    // Only display captcha if needed
    if($this->preference->item('use_registration_captcha')){
        echo '<div data-role="fieldcontain">'."\n";
        echo "<label for='recaptcha_response_field'>".$this->lang->line('userlib_captcha')."</label>"."\n";
        echo $captcha."\n";
        echo "</div>\n\n";
    }

    echo '<a href="'.site_url().'/welcome/student" data-role="button" data-icon="back" data-inline="true" data-transition="pop" data-mini="true" data-theme="e">'.$this->lang->line('general_cancel').'</a>';
    
    echo form_submit('submit', 'Submit', 'data-icon="gear" data-inline="true" data-mini="true" id="submit"')."\n";
                
    print form_close();
    //echo "</div>";

?>

<script>

    $("#myform_register").validate();

</script>

<?php

//print_r($advisors);
function spare_workemail($str)
    {

        // if first_item and second_item are equal
        if(stristr($str, '@canacad.ac.jp') !== FALSE)
        {
        // success
           // echo "success";
        return TRUE;
        }
        else
        {
        // set error message
        //$this->form_validation->set_message('spare_workemail', 'No match');

        // return fail
//            echo  "not workemail";
        return FALSE;
        }
    }

function belongstowork($email){
     $endsWith = "@canacad.ac.jp";
     //see: http://stackoverflow.com/a/619725/568884
     return substr_compare($endsWith, $email, -strlen($email), strlen($email)) === 0;
 }      
$email = 'test@caanacad.ac.jp';
echo $email;
var_dump(spare_workemail($email));
if(spare_workemail($email)==FALSE)
{
    echo "false";
}
else
{
    echo "true";
}


