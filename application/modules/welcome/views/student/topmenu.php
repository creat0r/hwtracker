<?php
$userid = $this->session->userdata('id');
$username = $this->session->userdata('username');
$group =$this->session->userdata('group');
if($userid AND $username AND $group=='Student')
{
	print '<a href="'. base_url().'index.php/welcome/student/index" data-role="button" data-inline="true" data-transition="pop" data-icon="home" data-mini="true" data-theme="c">Home</a>'."\n".
	'<a href="'.base_url().'index.php/welcome/student/setting" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop"  data-icon="grid" data-mini="true" data-theme="c">Settings</a>'."\n";
	if($hwtotal['totalmissed']>0)// show this if student has missed homework
	{
		echo '<a href="'. base_url().'index.php/welcome/student/myhomework/'.$userid.'" data-role="button" data-inline="true" data-ajax="false" data-icon="star" data-mini="true" data-theme="c">Missed Homework</a>'."\n";

	}
//echo '<a href="'. base_url().'index.php/welcome/student/changepw/'.$userid.'" data-role="button" data-inline="true" data-ajax="false" data-icon="plus" data-mini="true" data-theme="c">Change Password</a>';


//echo '<a href="'.base_url().'index.php/auth/logout" data-role="button" data-inline="true"  data-transition="pop" data-mini="true" data-theme="a">Logout</a>';
	echo "<p>Hi ".$this->session->userdata('first_name')."</p>\n";
	print displayStatus();
	print "<h3>$title</h3>\n";
}


?>