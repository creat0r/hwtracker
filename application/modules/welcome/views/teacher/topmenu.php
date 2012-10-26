<?php //welcome/views/teacher/topmenu

$userid = $this->session->userdata('id');
$username = $this->session->userdata('username');
$group =$this->session->userdata('group');
if($userid AND $username AND $group=='Teacher'){
	print '<a href="'. base_url().'index.php/welcome/teacher/index" data-role="button" data-inline="true" data-ajax="false" data-icon="home" data-mini="true" data-theme="c">My Advisory</a>
<a href="'.base_url().'index.php/welcome/teacher/setting" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop"  data-icon="grid" data-mini="true" data-theme="c">Settings</a>
<a href="'. base_url().'index.php/welcome/teacher/mysubject/'.$userid.'" data-role="button" data-inline="true" data-ajax="false" data-icon="star" data-mini="true" data-theme="c">My Subject</a>
<a href="'. base_url().'index.php/welcome/teacher/addstudentrecord/" data-role="button" data-inline="true" data-ajax="false" data-icon="plus" data-mini="true" data-theme="c">Add Record</a>';

}
?>

<?php

	echo "Hi ".$this->session->userdata('first_name');

	print displayStatus();
	print "<h3>$title</h3>";

?>