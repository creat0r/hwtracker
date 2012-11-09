<?php //welcome/views/student/setting.php

    //$this->load->view('student/topmenu');

    //echo '<div data-role="content" data-theme="b">';  
	print displayStatus();
    print "<h2>$title</h2>";
    print form_open('welcome/student/setting',array('id'=>'myform3', 'class'=>'horizontal','data-ajax'=>'false'));

	echo '<div>'."\n";
	$myemail = $this->form_validation->email;
    $size = 50;
	echo gravatar($myemail, $size);
    echo anchor('https://en.gravatar.com/', 'Change your avatar', 'target="_blank" data-role="button" data-inline="true" data-theme="c" id="avatar" data-mini="true"');
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='username'><em>* </em> ".$this->lang->line('userlib_username')."</label>"."\n";
        $username= array(
        'id'=>'username',
        'class'=>'required',
        'name'=>'username',
        'value'=>$this->form_validation->username,
        );
    echo form_input($username)."\n";
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='email'><em>* </em> ".$this->lang->line('userlib_email')."</label>"."\n";
        $email= array(
        'id'=>'email',
        'class'=>'required',
        'name'=>'email',
        'value'=>$this->form_validation->email,
        );
    echo form_input($email)."\n";
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='first_name'><em>* </em> First Name</label>"."\n";
        $first_name= array(
        'id'=>'first_name',
        'class'=>'required',
        'name'=>'first_name',
        'value'=>$this->form_validation->first_name,
        );
    echo form_input($first_name)."\n";
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='last_name'><em>* </em> Last Name</label>"."\n";
        $last_name= array(
        'id'=>'last_name',
        'class'=>'required',
        'name'=>'last_name',
        'value'=>$this->form_validation->last_name,
        );
    echo form_input($last_name)."\n";
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="advisor"><em>* </em> Advisor: </label>'."\n";
    if(!empty($advisor))
    {
        $options = array(
            $this->form_validation->advisor
        );
        echo form_dropdown('advisor', $advisor,  $options, 'id="advisor" class="required" data-native-menu="false" data-theme="c"')."<br />\n";
    }
    else
    {
        echo "No teacher registered. Contact the application administrator.";
    }
	
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='parent_email1'><em>* </em> Parent email 1</label>"."\n";
        $parent_email= array(
        'id'=>'parent_email1',
        'class'=>'required',
        'name'=>'parent_email1',
        'value'=>$this->form_validation->parent_email1,
        );
    echo form_input($parent_email)."\n";
    echo "</div>\n\n";


    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='parent_email2'>Parent email 2</label>"."\n";
        $parent_email2= array(
        'id'=>'parent_email2',
        //'class'=>'required',
        'name'=>'parent_email2',
        'value'=>$this->form_validation->parent_email2,
        );
    echo form_input($parent_email2)."\n";
    echo "</div>\n\n";


    echo form_hidden('id', $this->form_validation->id);

    // Only display captcha if needed

    echo '<a href="'.site_url().'/welcome/student" data-role="button" data-icon="back" data-inline="true" data-transition="pop" data-mini="true" data-theme="e">'.$this->lang->line('general_cancel').'</a>';
    
    echo form_submit('submit', 'Submit', 'data-icon="gear" data-inline="true" data-mini="true" id="submit"')."\n";
                
    print form_close();
    //echo "</div>";
    echo '<a href="'. base_url().'index.php/welcome/student/changepw/'.$this->form_validation->id.'" data-role="button" data-inline="true" data-ajax="false" data-icon="plus" data-mini="true" data-theme="c">Change Password</a>';


?>

<script>

    $("#myform3").validate();

</script>

<?php
/*
//echo $this->form_validation->username;
echo "setting page";
echo "<pre>";
print_r($user);
echo "</pre>";

echo "session info: ";
print_r($this->session->all_userdata()) ;
echo "<br />";
*/
?>