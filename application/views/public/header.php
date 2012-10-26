<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $header; ?> : Canadian Academy</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<script src="https://www.google.com/jsapi"></script>
	<?php print $this->bep_site->get_variables()?>
	<?php print $this->bep_assets->get_header_assets();?>
	<?php print $this->bep_site->get_js_blocks()?>
</head>
<body class="no-js">
	
	<script type="text/javascript">document.body.className=(' '+document.body.className+' ').replace(' no-js ',' with-js ')</script>

	<div data-role="page">

	<div data-role="header" data-theme="b">
		<h1><?php echo $header; ?></h1>
		<?php
		if($this->session->userdata('username'))
		{
			echo "<div id='logout'>";
			echo '<a href="'. base_url().'index.php/auth/logout" data-role="button" data-inline="true"  data-mini="true" data-transition="pop" data-theme="a">Logout</a>
		';
			echo "</div>";
		}
?>
	</div><!-- /header -->