<?php

//print_r($apcinfo);
	;
	$this->load->view('student/topmenu');

	print displayStatus();
	$formatts = array('class'=>'validate','id' => 'myform2', 'data-transition'=>'flip','data-ajax'=>'false');
	echo form_open('welcome/student/mailto',$formatts)."\n";
	
	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="assignmentname"><em>* </em> Assignment name: </label>'."\n";
	$assignmentnameatts= array(
		'id'=>'assignmentname',
		'class'=>'required',
		'name'=>'assignmentname',
		'placeholder'=>'Assignment name'
		);
	echo form_input($assignmentnameatts)."\n";
	echo "</div>\n\n";
	

	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="subjectid"><em>* </em> Subject: </label>'."\n";
	if(!empty($subjectlist))
	{
		echo form_dropdown('subjectid', $subjectlist,  NULL, 'id="subjectid" class="required" data-mini="true" data-native-menu="false"')."<br />\n";
	}
	else
	{
		echo "No subject registered. Contact the application administrator.";
	}
	echo "</div>\n\n";

	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="teachername"><em>* </em> Subject Teacher: </label>'."\n";
	if(!empty($teachername))
	{
		echo form_dropdown('teachername', $teachername,  NULL, 'id="teachername" class="required" data-mini="true" data-native-menu="false" ')."<br />\n";
	}
	else
	{
		echo "No teacher registered. Contact the application administrator.";
	}
	echo "</div>\n\n";

	//hidden form for first and last name
	$data = array(
              'id'  => $this->session->userdata('id'),
            );

	echo form_hidden($data);

	echo form_submit('submit', 'Submit', 'data-icon="gear" data-mini="true" id="submit"')."\n";
	echo form_close();
	?>
	
	<script>

	$("#myform2").validate();

	</script>
<?php
/*
$base=$this->config->item('base_url');
$mystring = $base;
$findme   = 'localhost';
$pos = strpos($mystring, $findme);
if(ENVIRONMENT=='development' OR $pos)
{
   echo "it is local";
}
else
{
	echo "not local";
}
*/
/*
$item=$this->preference->item('cachepagetime');
var_dump($item);
if(empty($item))
{
	echo "yes";
}
else
{
	echo "no";
}

echo "<pre>";
echo "session info: ";
print_r($this->session->all_userdata()) ;
echo "</pre>";
*/


	/*
	echo "<br />";
print_r($teachername);


print_r($hwtotal);
if($hwtotal['totalmissed']>0)
{
	echo "yes";
}
else
{
	echo "no";
}
	*/
?>
