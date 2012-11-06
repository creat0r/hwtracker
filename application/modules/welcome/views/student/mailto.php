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
echo "To: ".$userdetails['parent_email1'].$parent_email2."<br />\n";
// find to who you are sending from preference
$email_to=$this->preference->item('email_to');
$findsubject   = 'subject';
$findadvisor ='advisor';
$findprincipal ='principal';
$subjectpos = strpos($email_to, $findsubject);
$advisorpos = strpos($email_to, $findadvisor);
$principalpos = strpos($email_to, $findprincipal);
if($subjectpos !== false)
{
	echo "cc to subject teacher: $teacher_gender ". $teacherdetails['last_name']."<br />\n";
}
if($advisorpos !== false)
{
	echo "cc to advisor: $advisor_gender"." " .$advisordetails['last_name']."<br />\n";
}
if($principalpos !== false)
{
	echo "cc to principal: $principal_gender ".$principaldetails['last_name']."<br />\n";
}

echo "Subject: $subjectname homework<br />\n";
echo $content;

//email
$data = array(
              'to'  => $userdetails['parent_email1']. $parent_email2,
              'cc' => $teacherdetails['email'].", ".$advisordetails['email'].", ".$principaldetails['email'],
              'email_subject'   => "$subjectname homework",
              'content'=>$content,
              'assignmentname'=>$assignmentname,
              'subjectid'=>$subjectid,
              'studentid'=>$userdetails['id'],
              'subject_teacherid'=> $teacherdetails['id'],
              'username'=>$username,
              'useremail'=>$userdetails['email'],
            );



echo form_hidden($data);
echo form_submit('submit', 'Submit', 'data-icon="gear" data-mini="true" id="submit"')."\n";
echo form_close();
?>

<?php
/*
echo "<pre>session data: ";
print_r($this->session->all_userdata());
echo "</pre>";
*/


//$teachername=array_shift($arrayteachers);
//print_r($teachername);
//print_r($subjectname);
//print_r($advisor);
/*
echo "<pre>userdetails: ";
print_r($userdetails);
echo "</pre>";
echo "<pre>advisordetails: ";
print_r($advisordetails);
echo "</pre>";
echo "<pre>teacherdetails: ";
//print_r($data);
print_r($teacherdetails);
echo "</pre>";
echo "<pre>principaldetails: ";
//print_r($data);
print_r($principaldetails);
echo "</pre>";
*/
//echo "<pre>advisor: ";
//print_r($data);
//print_r($advisor);
//echo "</pre>";
//var_dump($userdetails['parent_email2']);
//if(empty($userdetails['parent_email2']))
//{
	//echo "empty";
//}
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
