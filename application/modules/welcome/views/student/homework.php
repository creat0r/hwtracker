<?php
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
	echo form_dropdown('subjectid', $subjectlist,  NULL, 'id="subjectid" class="required" data-mini="true" data-native-menu="false"')."<br />\n";
	echo "</div>\n\n";

	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="teachername"><em>* </em> Subject Teacher: </label>'."\n";
	echo form_dropdown('teachername', $teachername,  NULL, 'id="teachername" class="required" data-mini="true" data-native-menu="false" ')."<br />\n";
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


echo "session info: ";
	print_r($this->session->all_userdata()) ;
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
