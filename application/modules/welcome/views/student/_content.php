<?php
// content
echo "hi this is in student/content.php";
if( isset($page))
	{
        $this->load->view($page);  
    }