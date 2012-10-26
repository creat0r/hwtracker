<?php //mailto.php
$this->load->view('student/topmenu');
$formatts = array('data-ajax'=>'false');
echo form_open('welcome/student/sendemail',$formatts)."\n";
if(!empty($userdetails['parent_email2']))
{
	$parent_email2=",".$userdetails['parent_email2'];
}
else
{
	$parent_email2="";
}
echo "To: ".$userdetails['parent_email1'].$parent_email2."<br />";

echo "cc to subject teacher: $teacher_gender". $teacherprofiledetails['last_name']."<br />";

echo "cc to advisor: $advisor_gender $advisor<br />";
echo "cc to principal: $principal_gender".$principalprofiledetails['last_name']."<br />";
echo "Subject: $subjectname homework<br />";
echo $content;

//email
$data = array(
              'to'  => $userdetails['parent_email1']. $userdetails['parent_email2'],
              'cc' => $teacheruserdetails['email'].", ".$principaluserdetails['email'],
              'subjectname'   => "$subjectname homework",
              'content'=>$content,
              'assignmentname'=>$assignmentname,
              'subjectid'=>$subjectid,
              'studentid'=>$userdetails['id'],
              'teacherid'=> $teacheruserdetails['id']
            );



echo form_hidden($data);
echo form_submit('submit', 'Submit', 'data-icon="gear" data-mini="true" id="submit"')."\n";
echo form_close();
?>

<?php

//print_r($userdetails);
//echo "<br />";

//$teachername=array_shift($arrayteachers);
//print_r($teachername);
//print_r($subjectname);
//print_r($advisor);
echo "<pre>userdetails: ";
print_r($userdetails);
echo "</pre>";

echo "<pre>teacherprofiledetails: ";
//print_r($data);
print_r($teacherprofiledetails);
echo "</pre>";
var_dump($userdetails['parent_email2']);
if(empty($userdetails['parent_email2']))
{
	echo "empty";
}
/*
//var_dump($teachers);
if($advisorname)
{
	var_dump($advisorname);
	echo "<br />";
}

if($username)
{
	echo "username is ";
print_r($username);
echo "<br />";
}
if($subject)
{
	echo "subject is ";
	print_r($subject);
echo "<br />";
}
//if($teachername)
//{
	echo "teachername is ";
	var_dump($teachername);
	echo "<br />";
//}
//if($teachers)
//{
	if($teachers)
	{
		echo "teachers is not empty";
	}
	else
	{
		echo "teachers IS empty";
	}
	echo "teachers is ";
	var_dump($teachers);
	echo "<br />";
//}

if($assignmentname)
{
	echo "assignment is ";
	print_r($assignmentname);
	echo "<br />";
}
*/
?>
