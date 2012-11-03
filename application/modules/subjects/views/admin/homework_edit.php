<h2><?php echo $title;?></h2>
<?php


echo form_open('subjects/admin/edit');

echo "\n<table id='preference_form'><tr><td class='label'><label for='catname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'name','class'=>'text','value' => $subject['name']);
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options, $subject['status']);
echo "</td></tr></table>\n";


echo form_hidden('id',$subject['id']);

?>

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
<?php

//echo form_submit('submit',$this->lang->line('kago_update'));
echo form_close();

?>

 