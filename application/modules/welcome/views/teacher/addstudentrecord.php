<?php //addstudentrecord.php ?>

<?php 
	$this->load->view('teacher/topmenu');
?>
	<script>
		//reset type=date inputs to text
		/*
		$( document ).bind( "mobileinit", function(){
			$.mobile.page.prototype.options.degradeInputs.date = true;
		});	*/

	</script>
<?php
// need assignment name, student id and name dropdown, date, subject id/name dropdown, hidden teacherid
                
	$formatts = array('class'=>'validate','id' => 'myform3', 'data-transition'=>'flip','data-ajax'=>'false');
	echo form_open('welcome/teacher/addstudentrecord',$formatts)."\n";
	

	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="assignment_name">Assignment name: </label>'."\n";
	$assignmentnameatts= array(
		'id'=>'assignment_name',
		'class'=>'required',
		'name'=>'assignment_name',
		'placeholder'=>'Assignment name'
		);
	echo form_input($assignmentnameatts)."\n";
	echo "</div>\n\n";
	
	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="studentid">Student name: </label>'."\n";
	echo form_dropdown('studentid', $students,  NULL, 'id="studentid" class="required" data-mini="true" data-native-menu="false"')."<br />\n";
	echo "</div>\n\n";

	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="subjectid">Subject: </label>'."\n";
	echo form_dropdown('subjectid', $subjectlist,  NULL, 'id="subjectid" class="required" data-mini="true" data-native-menu="false"')."<br />\n";
	echo "</div>\n\n";


	echo '<div data-role="fieldcontain">'."\n";
	echo '<label for="date">Date Input:</label>';
    echo '<input name="date" id="date" type="date" data-role="datebox" class="required" data-options=\'{"mode": "calbox", "useFocus": true,  "overrideDateFormat": "%Y-%m-%d", "useNewStyle":true}\'>';
	echo "</div>\n\n";


	//hidden form for first and last name
	$data = array(
              'teacherid'  => $this->session->userdata('id'),
            );

	echo form_hidden($data);

	echo form_submit('submit', 'Submit', 'data-icon="gear" data-mini="true" id="submit"')."\n";
	echo form_close();
	?>
	
	<script>

	$("#myform3").validate();
jQuery.extend(jQuery.mobile.datebox.prototype.options, {
    //'overrideDateFormat': '%Y-%m-%d',
    //'overrideHeaderFormat': '%Y-%m-%d'
})
	</script>

	<?php
echo "<pre>";
print_r($subjectlist);
print_r($students);
echo "</pre>";


	?>