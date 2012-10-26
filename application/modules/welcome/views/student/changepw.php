<?php //views/teacher/changepw
	$this->load->view('student/topmenu');

	print displayStatus();
	$formatts = array('class'=>'validate','id' => 'myform_pw', 'data-transition'=>'flip','data-ajax'=>'false');
	echo form_open('welcome/student/changepw/'.$this->session->userdata('id'),$formatts)."\n";
	
	echo '<div data-role="fieldcontain">'."\n";
	print form_label($this->lang->line('userlib_password'),'password');
    print form_password('password',NULL,'id="password" class="text"');
    echo "</div>\n\n";

    echo '<div data-role="fieldcontain">'."\n";
    print form_label($this->lang->line('userlib_confirm_password'),'passconf');
    print form_password('passconf',NULL,'id="passconf" class="text"');
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

	$("#myform_pw").validate();

	</script>