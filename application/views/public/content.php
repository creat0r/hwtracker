<div data-role="content" data-theme="d">    

<?php 
//echo validation_errors(); 
print displayStatus();

// content
if( isset($page))
    {
        $this->load->view($page);  
    }


?>
	
</div>