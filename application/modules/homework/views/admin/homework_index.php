<h2><?php echo $title;?></h2>
<div class="buttons">
	<a href="<?php print  site_url('homework/admin/create')?>">
    <?php print $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('kago_create')." ".$this->lang->line('hwezemail_homework'); ?>
    </a>
</div>
<div class="clearboth">&nbsp;</div>

<script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'First Name');
        data.addColumn('string', 'Last Name');
        data.addColumn('number', 'Number of Homework Missed');
        data.addRows([
	<?php
        if(count($hwall))
        {
            foreach($hwall as $hw)
            {
                echo "['<a href=\"".site_url()."/homework/admin/student/".$hw['studentid']."\">".$hw['first_name']."</a>', '".$hw['last_name']."',".$hw['COUNT(studentid)']."],";
            }
        }
		
	?>

/*
          ['Mike', 5],
          ['Jim',  2],
          ['Alice', 1],
          ['Bob',  4]*/

        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, allowHtml:true});
      }
    </script>
 <div id='table_div'></div>



<?php
/*
echo "<pre>";
print_r($hwall);
echo "</pre>";
*/
?>