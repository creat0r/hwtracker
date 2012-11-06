<?php // dialog page
    //echo '<div data-role="content" data-theme="b">';  
	print displayStatus();
    print "<h2>$title</h2>";
    print form_open('welcome/teacher/setting',array('id'=>'myform3', 'class'=>'horizontal','data-ajax'=>'false'));

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
    echo '<fieldset data-role="controlgroup">'."\n";
    echo "<legend for='school'><em>* </em> School</legend>"."\n";
    $mystring = $this->form_validation->school;
    $findes   = 'es'; $findms='ms'; $findhs='hs';
    $es = strpos($mystring, $findes); $ms = strpos($mystring, $findms); $hs = strpos($mystring, $findhs);
    $dataes = array('name'=>'school[]','id'=>'es','value'=>'es','checked'=>($es !== FALSE ) ? 'checked' : '');
    $datams = array('name'=>'school[]','id'=>'ms','value'=>'ms','checked'=>($ms !== FALSE ) ? 'checked' : '');
    $datahs = array('name'=>'school[]','id'=>'hs','value'=>'hs','checked'=>($hs !== FALSE ) ? 'checked' : '');
    echo form_checkbox($dataes).'<label for="es">Elementary School</label>'."\n";
    echo form_checkbox($datams).'<label for="ms">Middle School</label>'."\n";
    echo form_checkbox($datahs).'<label for="hs">High School</label>'."\n";     
    echo '</fieldset>'."\n";
    echo "</div>\n\n";

    //gender
    echo '<div data-role="fieldcontain">'."\n";
    echo '<fieldset data-role="controlgroup">'."\n";
    echo "<legend for='gender'><em>* </em> Gender</legend>"."\n";
    $datamale= array('name' =>'gender' , 'id'=>'male', 'value'=>'male','checked'=>($this->form_validation->gender == 'male' ? 'checked' : '') );
    $datafemale= array('name' =>'gender' , 'id'=>'female', 'value'=> 'female','checked'=>($this->form_validation->gender == 'female' ? 'checked' : '') );
    //echo "Male ".form_radio('gender','male','id'='male' $this->form_validation->set_radio('gender','male',$selected = ($this->form_validation->gender == 'male') ? TRUE : FALSE))."\n";
    //echo "Female ".form_radio('gender','female','id'='female' $this->form_validation->set_radio('gender','female',$selected = ($this->form_validation->gender == 'female') ? TRUE : FALSE))."\n";
    echo form_radio($datamale).'<label for="male">Male</label>'."\n";
    echo form_radio($datafemale).'<label for="female">Female</label>'."\n";
    echo '</fieldset>'."\n";
    echo "</div>\n\n";



    echo form_hidden('id', $this->form_validation->id);

/* // move to change password
    echo '<div data-role="fieldcontain">'."\n";
    echo "<label for='password'>".$this->lang->line('userlib_password')."</label>"."\n";
        $password= array(
        'id'=>'password',
        'class'=>'required',
        'name'=>'password',
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
        'type'=>'password'
        );
    echo form_input($confirm_password)."\n";
    echo "</div>\n\n";
*/
    // Only display captcha if needed

    echo '<a href="'.site_url().'/welcome/teacher" data-role="button" data-icon="back" data-inline="true" data-transition="pop" data-mini="true" data-theme="e">'.$this->lang->line('general_cancel').'</a>';
    
    echo form_submit('submit', 'Submit', 'data-icon="gear" data-inline="true" data-mini="true" id="submit"')."\n";
                
    print form_close();
    //echo "</div>";
    echo '<a href="'. base_url().'index.php/welcome/teacher/changepw/" data-role="button" data-inline="true" data-ajax="false" data-icon="plus" data-mini="true" data-theme="c">Change Password</a>'
?>


<script>

    $("#myform3").validate();

</script>

<?php
/*
var_dump($es);
echo "<br />";
var_dump($ms);
echo "<br />";
var_dump($hs);
echo "<br />";
echo $this->form_validation->school;

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