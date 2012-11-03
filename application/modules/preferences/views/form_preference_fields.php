<h2><?php print $header;?></h2>

<?php print form_open($form_link);?>
<table id="preference_form">
	<?php foreach($field as $name => $data): ?>
	<?php
	/*
echo "<pre>name is: ";
print_r($name);
echo "</pre><pre> data is: ";
	 print_r($data); 
	 echo "</pre>";
	  */
	 ?>
	<tr>
	    <td class='label'>

	    <?php print form_label($data['label'],$name);?>
	    <?php
	    if (FALSE !== ($desc = $this->lang->line('preference_desc_'.$name)))
	    {
	        print "<small>".$desc."</small>";
	    }
	    ?>
	    </td>
	    <td><?php print $data['input'];?></td>
	</tr>
	<?php endforeach; ?>
</table>

<div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
    <?php print $this->bep_assets->icon('disk');?>
    <?php print $this->lang->line('general_save');?>
    </button>

    <a href="<?php print site_url($cancel_link);?>" class="negative">
    <?php print $this->bep_assets->icon('cross');?>
    <?php print $this->lang->line('general_cancel');?>
    </a>
</div>
<?php print form_close();?>

<?php
/*
$email_to=$this->preference->item('email_to');
//$email_to=(array)$email_to;
var_dump($email_to);
foreach ($email_to as $key => $value) {
		print_r($value1);
}

 $myoption = array( 
	    'params' => array
	        (
	            'options' => array
	                (
	                    'subjectteacher' => 'Subject Teacher',
	                    'advisor' => 'Advisor',
	                    'principal' => 'Principal',
	                )
	        )
	);


echo "<pre>myoption: ";
print_r($myoption);
echo "</pre>";

$optionone=$myoption['params']['options'];
foreach ($optionone as $keyvalue=> $value)
{
	$data=array(
				//'name'=>'email_to',
				'value'=>$keyvalue,
				);
			echo form_checkbox('email_to',$keyvalue).$value;
}


*/

?>